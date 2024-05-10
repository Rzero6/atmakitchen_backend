<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;

class DetailTransaksiController extends Controller
{
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
