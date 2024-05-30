<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use App\Models\Customer;
use App\Models\DetailTransaksi;
use App\Models\Hampers;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function index()
    {
        try {
            $transaksi = Transaksi::with('customer', 'customer.user', 'alamat', 'detail.produk.resep.bahanBaku', 'detail.hampers.detailhampers.produk.resep.bahanBaku',)->get();
            $now = Carbon::now();
            $tomorrow = $now->copy()->addDay();
            foreach ($transaksi as $trans) {
                $tanggalPesanan = Carbon::parse($trans->tanggal_penerimaan);
                if (($trans->status == "belum dibayar" || $trans->status == "sudah dijarak")
                    && $tanggalPesanan->lte($now->addDays(1)) && $now->gt($tanggalPesanan)
                ) {
                    $trans->status = "dibatalkan";
                    $trans->save();
                }
                if ($trans->status == "sedang dikirim kurir" && $tanggalPesanan->lt($now)) {
                    $trans->status = "selesai";
                    $trans->save();
                }
                if ($trans->status == "diterima" && $tanggalPesanan->isSameDay($tomorrow)) {
                    $trans->status = "diproses";
                    $trans->save();
                }
                if ($trans->status == "diproses" && $tanggalPesanan->isSameDay($now)) {
                    if ($trans->id_alamat) {
                        $trans->status = "sedang dikirim kurir";
                        $trans->save();
                    } else {
                        $trans->status = "siap di-pickup";
                        $trans->save();
                    }
                    foreach ($trans->detail as $detail_transaksi) {
                        if ($detail_transaksi->id_produk) {
                            foreach ($detail_transaksi->produk->resep as $resep) {
                                $bahan = BahanBaku::find($resep->id_bahan_baku);
                                $bahan->stok = $bahan->stok - $resep->takaran;
                                $bahan->save();
                            }
                        }
                        if ($detail_transaksi->id_hampers) {
                            foreach ($detail_transaksi->hampers->detailhampers as $detailhampers) {
                                if ($detailhampers->id_produk) {
                                    foreach ($detailhampers->produk->resep as $resep) {
                                        $bahan = BahanBaku::find($resep->id_bahan_baku);
                                        $bahan->stok = $bahan->stok - $resep->takaran;
                                        $bahan->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $transaksi,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $storeData = $request->all();
            $validate = Validator::make($storeData, [
                'id_customer' => 'required|numeric',
                'id_alamat' => 'sometimes',
                'tanggal_pesanan' => 'required|date',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $storeData['total_harga'] = 0;
            $storeData['tip'] = 0;
            $storeData['jarak'] = 0;
            $storeData['status'] = "belum dibayar";

            $transaksi = Transaksi::create($storeData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $transaksi
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }

    public function uploadBuktiBayar(Request $request, $id)
    {
        try {
            $transaksi = Transaksi::find($id);
            if (!$transaksi) throw new \Exception("Transaksi tidak ditemukan");

            $storeData = $request->all();
            $validate = Validator::make($storeData, [
                'bukti_bayar' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }

            $image = $request->file('bukti_bayar');
            $image_uploaded_path = $image->store('bukti_bayar', 'public');
            $storeData['bukti_bayar'] = basename($image_uploaded_path);

            $transaksi->bukti_bayar = $storeData['bukti_bayar'];
            $transaksi->status = "sudah dibayar";
            $transaksi->save();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $transaksi
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $transaksi = Transaksi::find($id);

            if (!$transaksi) throw new \Exception("Transaksi tidak ditemukan");
            $updatedData = $request->all();
            $validate = Validator::make($updatedData, [
                'status' => 'sometimes|string',
                'jarak' => 'sometimes|numeric',
                'tip' => 'sometimes|numeric',
                'total_harga' => 'sometimes|numeric',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $transaksi->update($updatedData);
            if ($transaksi->status === "diterima") {
                $customer = Customer::find($transaksi->id_customer);
                $hmin3 = Carbon::now()->subDays(3);
                $hmax3 = Carbon::now()->addDays(3);
                $tanggal_lahir = Carbon::parse($customer->tanggal_lahir);
                $poin = 0;
                $dibayar = $transaksi->total_harga;
                while ($dibayar >= 10000) {
                    if ($dibayar >= 1000000) {
                        $dibayar -= 1000000;
                        $poin += 200;
                    }
                    if ($dibayar >= 500000) {
                        $dibayar -= 500000;
                        $poin += 75;
                    }
                    if ($dibayar >= 100000) {
                        $dibayar -= 100000;
                        $poin += 15;
                    }
                    if ($dibayar >= 10000) {
                        $dibayar -= 10000;
                        $poin += 1;
                    }
                }
                if ($tanggal_lahir->between($hmin3, $hmax3)) $poin = $poin * 2;
                $customer->promo_poin += $poin;
                $customer->save();
            }
            if ($transaksi->status === "ditolak") {
                $customer = Customer::find($transaksi->id_customer);
                $customer->saldo = $transaksi->tip + $transaksi->total_harga;
                $customer->save();
            }
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $transaksi
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }
    public function showByIdUser($id)
    {
        try {
            $customer = Customer::where('id_user', $id)->first();
            if (!$customer) throw new \Exception("Customer tidak ditemukan");
            $transaksi = Transaksi::with('customer', 'alamat', 'detail.produk', 'detail.hampers',)->where('id_customer', $customer->id)->get();
            $now = Carbon::now();
            $tomorrow = $now->copy()->addDay();
            foreach ($transaksi as $trans) {
                $tanggalPesanan = Carbon::parse($trans->tanggal_penerimaan);
                if ($trans->status == "belum dibayar" && $tanggalPesanan->lt($now->subDays(2))) {
                    $trans->status = "batal";
                    $trans->save();
                }
                if ($trans->status == "sedang dikirim kurir" && $tanggalPesanan->lt($now)) {
                    $trans->status = "selesai";
                    $trans->save();
                }
                if ($trans->status == "diterima" && $tanggalPesanan->isSameDay($tomorrow)) {
                    $trans->status = "diproses";
                    $trans->save();
                }
                if ($trans->status == "diproses" && $tanggalPesanan->isSameDay($now)) {
                    if ($trans->id_alamat) {
                        $trans->status = "sedang dikirim kurir";
                        $trans->save();
                    } else {
                        $trans->status = "siap di-pickup";
                        $trans->save();
                    }
                    foreach ($trans->detail as $detail_transaksi) {
                        if ($detail_transaksi->id_produk) {
                            foreach ($detail_transaksi->produk->resep as $resep) {
                                $bahan = BahanBaku::find($resep->id_bahan_baku);
                                $bahan->stok = $bahan->stok - $resep->takaran;
                                $bahan->save();
                            }
                        }
                        if ($detail_transaksi->id_hampers) {
                            foreach ($detail_transaksi->hampers->detailhampers as $detailhampers) {
                                if ($detailhampers->id_produk) {
                                    foreach ($detailhampers->produk->resep as $resep) {
                                        $bahan = BahanBaku::find($resep->id_bahan_baku);
                                        $bahan->stok = $bahan->stok - $resep->takaran;
                                        $bahan->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $transaksi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }
    public function show($id)
    {
        try {
            $transaksi = Transaksi::with('customer', 'alamat', 'detail.produk', 'detail.hampers',)->find($id);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $transaksi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }
}
