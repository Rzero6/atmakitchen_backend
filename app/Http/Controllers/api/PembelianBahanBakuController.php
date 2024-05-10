<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembelianBahanBaku;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\Validator;

class PembelianBahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pembelianBahan = PembelianBahanBaku::all();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $pembelianBahan
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $storeData = $request->all();
            $validate = Validator::make($storeData, [
                'id_bahanBaku' => 'required|numeric',
                'jumlah' => 'required',
                'tglPembelian' => 'required|date',
                'harga' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $bahanBaku = BahanBaku::find($storeData['id_bahanBaku']);
            if (!$bahanBaku) throw new \Exception("Bahan Baku tidak ditemukan");

            $pembelianBahan = PembelianBahanBaku::create($request->all());
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $pembelianBahan
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = PembelianBahanBaku::find($id);

            if (!$data) throw new \Exception("Belum Ada Pembelian Bahan Baku");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $data
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = PembelianBahanBaku::find($id);

            if (!$data) throw new \Exception("Belum Ada Pembellian Bahan Baku");
            $updatedData = $request->all();
            $validate = Validator::make($updatedData, [
                'id_bahanBaku' => 'required|numeric',
                'jumlah' => 'required',
                'tglPembelian' => 'required|date',
                'harga' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $bahanBaku = BahanBaku::find($updatedData['id_bahanBaku']);
            if (!$bahanBaku) throw new \Exception("Bahan Baku tidak ditemukan");
            $data->update($updatedData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $data
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = PembelianBahanBaku::find($id);

            if (!$data) throw new \Exception("Belum Ada Pembelian Bahan Baku");

            $data->delete();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil hapus data',
                "data" => $data
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }
}
