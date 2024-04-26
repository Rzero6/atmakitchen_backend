<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            "email" => "required|email:rfc,dns",
            "password" => "required",
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors(),
            ], 400);
        }

        if (!Auth::attempt($loginData)) {
            return response()->json([
                'message' => 'Email atau Password salah',
            ], 401);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();
        // if ($user->email_verified_at === null) {
        //     return response()->json([
        //         'message' => 'Email belum diverifikasi'
        //     ], 401);
        // }
        $token = $user->createToken('Authentication Token')->accessToken;

        return response()->json([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token,
        ], 200);
    }
}
