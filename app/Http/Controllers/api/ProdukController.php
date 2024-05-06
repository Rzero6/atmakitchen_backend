<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Penitip;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $produk = Produk::all();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $produk
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
                'id_penitip' => 'required|numeric',
                'nama' => 'required|max:50',
                'jenis' => 'required|max:50',
                'harga' => 'required',
                'stok' => 'required',
                'ukuran' => 'required|max:50',
                'image' => 'image:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }

            $penitip = Penitip::find($storeData['id_penitip']);
            if (!$penitip)
                throw new \Exception("Tidak ada penitip!");

            $uploadFolder = 'produk';
            $image = $request->file('image');
            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $storeData['image'] = basename($image_uploaded_path);

            $produk = Produk::create($storeData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $produk
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }

    public function storeTanpaPenitip(Request $request)
    {
        try {
            $storeData = $request->all();
            $validate = Validator::make($storeData, [
                'nama' => 'required|max:50',
                'jenis' => 'required|max:50',
                'harga' => 'required',
                'stok' => 'required',
                'limit_po' => 'required',
                'ukuran' => 'required|max:50',
                'image' => 'image:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $uploadFolder = 'produk';
            $image = $request->file('image');
            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $storeData['image'] = basename($image_uploaded_path);

            $produk = Produk::create($storeData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $produk
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
            $produk = Produk::find($id);

            if (!$produk) throw new \Exception("Produk tidak ditemukan");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $produk
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
            $produk = Produk::find($id);

            if (!$produk) throw new \Exception("Alamat tidak ditemukan");
            $updatedData = $request->all();
            $validate = Validator::make($updatedData, [
                'nama' => 'required|max:50',
                'jenis' => 'required|max:50',
                'harga' => 'required',
                'stok' => 'required',
                'ukuran' => 'required|max:50',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }

            $produk->update($updatedData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $produk
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
            $produk = Produk::find($id);

            if (!$produk) throw new \Exception("Produk tidak ditemukan");
            if ($produk->image !== null) {
                $filename = basename($produk->image);
                if (Storage::disk('public')->exists('produk/' . $filename)) {
                    Storage::disk('public')->delete('produk/' . $filename);
                }
            }
            $produk->delete();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil hapus data',
                "data" => $produk
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
