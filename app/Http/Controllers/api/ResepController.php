<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ResepController extends Controller
{
    public function index()
    {
        try {
            $produks = Produk::with('resep')->get();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $produks
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
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
                'id_produk' => 'required|numeric',
                'id_bahan_baku' => 'required|numeric',
                'takaran' => 'required|numeric',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $produk = Produk::find($storeData['id_produk']);
            if (!$produk) throw new \Exception("Resep tidak ditemukan");
            $resep = Resep::create($request->all());
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $resep
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
    public function show($id)
    {
        try {
            $resep = Resep::find($id);

            if (!$resep) throw new \Exception("Resep tidak ditemukan");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $resep
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
    public function update(Request $request, $id)
    {
        try {
            $resep = Resep::find($id);

            if (!$resep) throw new \Exception("Resep tidak ditemukan");
            $updatedData = $request->all();
            $validate = Validator::make($updatedData, [
                'id_produk' => 'required|numeric',
                'id_bahan_baku' => 'required|numeric',
                'takaran' => 'required|numeric',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $produk = Produk::find($updatedData['id_produk']);
            if (!$produk) throw new \Exception("Resep tidak ditemukan");
            $resep->update($updatedData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $resep
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
    public function destroy($id)
    {
        try {
            $resep = Resep::find($id);

            if (!$resep) throw new \Exception("Resep tidak ditemukan");

            $resep->delete();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil hapus data',
                "data" => $resep
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
