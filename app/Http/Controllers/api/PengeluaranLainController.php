<?php

namespace App\Http\Controllers\api;

use App\Models\PengeluaranLain;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengeluaranLainController extends Controller
{
    public function index()
    {
        try {
            $pengeluaranLain = PengeluaranLain::all();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $pengeluaranLain
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
                'rincian' => 'required',
                'nominal' => 'required',
                'tanggal_pengeluaran' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $pengeluaranLain = PengeluaranLain::create($request->all());
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $pengeluaranLain
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
            $pengeluaranLain = PengeluaranLain::find($id);

            if (!$pengeluaranLain) throw new \Exception("PengeluaranLain tidak ditemukan");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $pengeluaranLain
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
            $pengeluaranLain = PengeluaranLain::find($id);

            if (!$pengeluaranLain) throw new \Exception("PengeluaranLain tidak ditemukan");
            $updatedData = $request->all();
            $validate = Validator::make($updatedData, [
                'rincian' => 'required',
                'nominal' => 'required',
                'tanggal_pengeluaran' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $pengeluaranLain->update($updatedData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $pengeluaranLain
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
            $pengeluaranLain = PengeluaranLain::find($id);

            if (!$pengeluaranLain) throw new \Exception("PengeluaranLain tidak ditemukan");

            $pengeluaranLain->delete();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil hapus data',
                "data" => $pengeluaranLain
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
