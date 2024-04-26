<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alamat;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AlamatController extends Controller
{
    public function index()
    {
        try {
            $alamat = Alamat::all();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $alamat
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
                'id_customer' => 'required|numeric',
                'nama_penerima' => 'required|max:50',
                'no_telepon' => 'required|max:15',
                'kota' => 'required|max:16',
                'jalan' => 'required',
                'rincian' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $customer = User::find($storeData['id_customer']);
            if (!$customer) throw new \Exception("Customer tidak ditemukan");
            $alamat = Alamat::create($request->all());
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $alamat
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
            $alamat = Alamat::find($id);

            if (!$alamat) throw new \Exception("Alamat tidak ditemukan");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $alamat
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
            $alamat = Alamat::find($id);

            if (!$alamat) throw new \Exception("Alamat tidak ditemukan");
            $updatedData = $request->all();
            $validate = Validator::make($updatedData, [
                'id_customer' => 'required|numeric',
                'nama_penerima' => 'required|max:50',
                'no_telepon' => 'required|max:15',
                'kota' => 'required|max:16',
                'jalan' => 'required',
                'rincian' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $customer = User::find($updatedData['id_customer']);
            if (!$customer) throw new \Exception("Customer tidak ditemukan");
            $alamat->update($updatedData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $alamat
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
            $alamat = Alamat::find($id);

            if (!$alamat) throw new \Exception("Alamat tidak ditemukan");

            $alamat->delete();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil hapus data',
                "data" => $alamat
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
