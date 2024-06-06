<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\HistoriSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistoriSaldoController extends Controller
{
    public function index()
    {
        try {
            $historiSaldo = HistoriSaldo::with('customer.user')->get();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $historiSaldo
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
                'mutasi' => 'required',
                'tujuan' => 'required|max:50',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $storeData['status'] = false;
            $customer = Customer::find($storeData['id_customer']);
            if (!$customer) throw new \Exception("Customer tidak ditemukan");
            $historiSaldo = HistoriSaldo::create($storeData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $historiSaldo
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
            $historiSaldo = HistoriSaldo::find($id);

            if (!$historiSaldo) throw new \Exception("HistoriSaldo tidak ditemukan");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $historiSaldo
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
            $historiSaldo = HistoriSaldo::find($id);

            if (!$historiSaldo) throw new \Exception("HistoriSaldo tidak ditemukan");
            $updatedData = $request->all();
            $validate = Validator::make($updatedData, [
                'status' => 'required|boolean',
                'bukti_transfer' => 'sometimes',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $customer = Customer::find($historiSaldo->id_customer);
            if (!$customer) throw new \Exception("Customer tidak ditemukan");
            $historiSaldo->update($updatedData);
            if ($historiSaldo['status'] && $historiSaldo->bukti_transfer != "ditolak") {
                $customer->saldo += $historiSaldo->mutasi;
                $customer->save();
            }
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $historiSaldo
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }
    public function uploadBuktiTransfer(Request $request, $id)
    {
        try {
            $historiSaldo = HistoriSaldo::find($id);
            if (!$historiSaldo) throw new \Exception("HistoriSaldo tidak ditemukan");

            $storeData = $request->all();
            $validate = Validator::make($storeData, [
                'bukti_transfer' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }

            $image = $request->file('bukti_transfer');
            $image_uploaded_path = $image->store('bukti_transfer', 'public');
            $storeData['bukti_transfer'] = basename($image_uploaded_path);

            $historiSaldo->bukti_transfer = $storeData['bukti_transfer'];
            $historiSaldo->save();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $historiSaldo
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
            $historiSaldo = HistoriSaldo::find($id);

            if (!$historiSaldo) throw new \Exception("HistoriSaldo tidak ditemukan");

            $historiSaldo->delete();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil hapus data',
                "data" => $historiSaldo
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
