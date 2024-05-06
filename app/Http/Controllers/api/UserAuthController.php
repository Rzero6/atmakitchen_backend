<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSend;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        try {

            $str = Str::random(100);
            $registrationData = $request->all();
            $validate = Validator::make($registrationData, [
                'nama' => 'required',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password' => 'required|min:8',
                'tanggal_lahir' => 'required|date_format:Y-m-d',
                'no_telepon' => 'required|max:15',
            ]);

            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $userData = [
                'nama' => $registrationData['nama'],
                'email' => $registrationData['email'],
                'no_telepon' => $registrationData['no_telepon'],
                'password' => bcrypt($request->password),
                'id_role' => 5,
            ];
            $user = User::create($userData);

            $customerData = [
                'id_user' => $user->id,
                'verify_key' => $str,
                'tanggal_lahir' => $registrationData['tanggal_lahir'],
                'promo_poin' => 0,
                'saldo' => 0,
            ];

            $customer = Customer::create($customerData);

            $details = [
                'username' => $user->nama,
                'website' => 'Atma Kitchen',
                'datetime' => date('Y-m-d H:i:s'),
                'url' => request()->getHttpHost() . '/register/verify/' . $str
            ];
            Mail::to($user->email)->send(new MailSend($details));
            return response()->json([
                'message' => 'Link verifikasi telah dikirim ke email anda. Silahkan cek email anda untuk mengaktifkan akun.',
                'data' => $user,
                'customer' => $customer,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
    public function verify($verify_key)
    {
        $customer = Customer::where('verify_key', $verify_key)->first();

        if (!$customer) {
            $message = "Key tidak Valid";
        } elseif ($customer->email_verified_at) {
            $message = "Akun sudah melakukan verifikasi sebelumnya.";
        } else {
            Customer::where('verify_key', $verify_key)->update([
                'email_verified_at' => date('Y-m-d H:i:s'),
            ]);
            $message = "Verifikasi berhasil.";
        }

        return view('verification', compact('message'));
    }

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

    public function updatePassword(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) throw new \Exception("User tidak ditemukan");
            $updatedData = $request->all();
            $validate = Validator::make($updatedData, [
                'password' => 'required|min:8',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $userData = [
                'password' => bcrypt($updatedData['password'])
            ];
            $user->password = $userData['password'];
            $user->save();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ganti password',
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
