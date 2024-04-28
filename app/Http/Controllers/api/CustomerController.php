<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

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
                        'no_telepon' => $customer->no_telepon,
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
}
