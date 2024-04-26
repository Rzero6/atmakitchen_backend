<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            "id" => "required",
            "password" => "required",
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors(),
            ], 400);
        }

        if (!Auth::guard('admin')->attempt(['id' => $loginData['id'], 'password' => $loginData['password']])) {
            return response()->json([
                'message' => 'ID atau Password salah',
            ], 401);
        }

        /** @var \App\Models\Karyawan $karyawan **/
        $token = $karyawan->createToken('Authentication Token')->accessToken;

        return response()->json([
            'message' => 'Authenticated',
            'karyawan' => $karyawan,
            'token_type' => 'Bearer',
            'access_token' => $token,
        ], 200);
    }
}
