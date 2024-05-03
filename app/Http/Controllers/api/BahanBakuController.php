<?php

namespace App\Http\Controllers\api;

use App\Models\BahanBaku;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    public function index()
    {
        try {
            $bahanBaku = BahanBaku::all();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $bahanBaku
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
                'nama' => 'required|max:50',
                'stok' => 'required',
                'satuan' => 'required|max:10',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $bahanBaku = BahanBaku::create($request->all());
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $bahanBaku
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
            $bahanBaku = BahanBaku::find($id);

            if (!$bahanBaku) throw new \Exception("BahanBaku tidak ditemukan");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $bahanBaku
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
            $bahanBaku = BahanBaku::find($id);

            if (!$bahanBaku) throw new \Exception("BahanBaku tidak ditemukan");
            $updatedData = $request->all();
            $validate = Validator::make($updatedData, [
                'nama' => 'required|max:50',
                'stok' => 'required',
                'satuan' => 'required|max:10',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $bahanBaku->update($updatedData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $bahanBaku
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
            $bahanBaku = BahanBaku::find($id);

            if (!$bahanBaku) throw new \Exception("BahanBaku tidak ditemukan");

            $bahanBaku->delete();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil hapus data',
                "data" => $bahanBaku
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
