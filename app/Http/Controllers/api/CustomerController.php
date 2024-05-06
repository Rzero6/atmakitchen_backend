<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        try {

            $customers = Customer::with('user')->get();

            $formattedCustomers = $customers->map(function ($customer) {
                if ($customer->user) {
                    return [
                        'id' => $customer->id,
                        'id_user' => $customer->user->id,
                        'nama' => $customer->user->nama,
                        'email' => $customer->user->email,
                        'tanggal_lahir' => $customer->tanggal_lahir,
                        'no_telepon' => $customer->user->no_telepon,
                    ];
                } else {
                    throw new \Exception("User tidak ditemukan");
                }
            });

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $formattedCustomers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    public function show(string $id)
    {
        try {
            $customer = Customer::where('id_user', $id)->first();

            if (!$customer) throw new \Exception("Data Customer tidak ditemukan");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $customer
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }

    public function updateProfilPic(Request $request, $id)
    {
        try {
            $storeData = $request->all();
            $validate = Validator::make($storeData, [
                'profil_pic' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }

            $customer = Customer::find($id);
            if (!$customer) throw new \Exception("Customer tidak ditemukan");

            if ($customer->profil_pic) {
                $filename = basename($customer->profil_pic);
                if (Storage::disk('public')->exists('customer/' . $filename)) {
                    Storage::disk('public')->delete('customer/' . $filename);
                }
            }
            $uploadFolder = 'customer';
            $image = $request->file('profil_pic');
            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $customer->profil_pic = basename($image_uploaded_path);

            $customer->save();

            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $customer
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
