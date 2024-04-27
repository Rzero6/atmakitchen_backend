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
            // Retrieve customers along with their associated users
            $customers = Customer::with('user')->get();

            // Format the response JSON
            $formattedCustomers = $customers->map(function ($customer) {
                // Check if the user is null
                if ($customer->user) {
                    return [
                        'id' => $customer->id,
                        'id_user' => $customer->user->id,
                        'nama' => $customer->user->nama,
                        'email' => $customer->user->email,
                        'tanggal_lahir' => $customer->tanggal_lahir,
                    ];
                }
            });

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $formattedCustomers
            ], 200); // Status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); // Status code 400 = bad request
        }
    }
}
