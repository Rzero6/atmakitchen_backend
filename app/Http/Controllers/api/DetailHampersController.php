<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\Validator;
use App\Models\DetailHampers;
use App\Models\Hampers;
use App\Models\Produk;
use Illuminate\Http\Request;

class DetailHampersController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $storeData = $request->all();
            $validate = Validator::make($storeData, [
                'id_hampers' => 'required',
                'id_produk' => 'sometimes',
                'id_bahan_baku' => 'sometimes',
                'jumlah' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $hampers = Hampers::find($storeData['id_hampers']);
            if (!$hampers) throw new \Exception("Hampers tidak ditemukan");
            if (array_key_exists('id_produk', $storeData)) {
                $produk = Produk::find($storeData['id_produk']);
                if (!$produk) throw new \Exception("Produk tidak ditemukan" . $storeData['id_produk']);
            }
            if (array_key_exists('id_bahan_baku', $storeData)) {
                $bahan = BahanBaku::find($storeData['id_bahan_baku']);
                if (!$bahan) throw new \Exception("BahanBaku tidak ditemukan" . $storeData['id_bahan_baku']);
            }
            $detHampers = DetailHampers::create($storeData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $detHampers
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
    public function destroyAllPerHampers($idHampers)
    {
        try {
            $detHampers = DetailHampers::where('id_hampers', $idHampers)->get();
            foreach ($detHampers as $item) {
                $item->delete();
            }
            return response()->json([
                "status" => true,
                "message" => 'Berhasil hapus data',
                "data" => $detHampers
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
