<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        try {
            $transaksi = Transaksi::all();
            $now = Carbon::now();
            foreach ($transaksi as $trans) {
                if ($trans->status == "belum dibayar" && $trans->tanggal_pesanan->diffInDays($now) < 2) {
                    $trans->status = "batal";
                    $trans->save();
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

    public function store(Request $request)
    {
        try {
            $storeData = $request->all();
            $validate = Validator::make($storeData, [
                'id_customer' => 'required|numeric',
                'id_alamat' => 'required|numeric',
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
            foreach ($transaksi as $trans) {
                if ($trans->status == "belum dibayar" && $trans->tanggal_pesanan->diffInDays($now) < 2) {
                    $trans->status = "batal";
                    $trans->save();
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
