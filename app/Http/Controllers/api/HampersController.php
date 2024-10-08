<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hampers;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HampersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $hampers = Hampers::with('detailhampers.produk', 'detailhampers.bahanBaku')->get();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $hampers
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
                'harga' => 'required',
                'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }

            $uploadFolder = 'hampers';
            $image = $request->file('image');
            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $storeData['image'] = basename($image_uploaded_path);

            $hampers = Hampers::create($storeData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $hampers
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
            $hampers = Hampers::find($id)->with('detailhampers')->get();

            if (!$hampers) throw new \Exception("Data Hampers tidak ditemukan");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $hampers
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
            $hampers = Hampers::find($id);

            if (!$hampers) throw new \Exception("Hampers tidak ditemukan");
            $updatedData = $request->all();
            $validate = Validator::make($updatedData, [
                'nama' => 'required|max:50',
                'harga' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $hampers->update($updatedData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $hampers
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
            $hampers = Hampers::find($id);

            if (!$hampers) throw new \Exception("Hampers tidak ditemukan");
            if ($hampers->image !== null) {
                $filename = basename($hampers->image);
                if (Storage::disk('public')->exists('hampers/' . $filename)) {
                    Storage::disk('public')->delete('hampers/' . $filename);
                }
            }
            $hampers->delete();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil hapus data',
                "data" => $hampers
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
