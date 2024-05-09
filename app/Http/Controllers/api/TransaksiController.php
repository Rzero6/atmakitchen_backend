<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        try {
            $transaksi = Transaksi::all();
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
    public function showByIdUser($id)
    {
        try {
            $customer = Customer::where('id_user', $id)->first();
            $transaksi = Transaksi::with('customer', 'alamat', 'detail.produk', 'detail.hampers',)->where('id_customer', $customer->id)->get();
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
