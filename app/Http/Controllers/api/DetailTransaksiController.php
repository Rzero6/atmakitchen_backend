<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Hampers;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailTransaksiController extends Controller
{

    public function store(Request $request)
    {
        try {
            $storeData = $request->all();
            $validate = Validator::make($storeData, [
                'id_transaksi' => 'required',
                'id_produk' => 'sometimes',
                'id_hampers' => 'sometimes',
                'jumlah' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $transaksi = Transaksi::find($storeData['id_transaksi']);
            if (!$transaksi) throw new \Exception("Transaksi tidak ditemukan");

            if (array_key_exists('id_produk', $storeData)) {
                $produk = Produk::find($storeData['id_produk']);
                if (!$produk) throw new \Exception("Produk tidak ditemukan");
            }
            if (array_key_exists('id_bahan_baku', $storeData)) {
                $hampers = Hampers::find($storeData['id_hampers']);
                if (!$hampers) throw new \Exception("Hampers tidak ditemukan");
            }
            $detTrans = DetailTransaksi::create($storeData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $detTrans
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }
    public function showByTransaction($id)
    {
        try {
            $detailTransactions = DetailTransaksi::where('id_transaksi', $id)->get();
            if (!$detailTransactions) throw new \Exception('Detail Transaksi tidak ditemukan');
            return response()->json([
                'status' => true,
                'message' => 'Berhasil ambil data',
                'data' => $detailTransactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }
}
