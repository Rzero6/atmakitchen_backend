<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\MailSend;
use App\Mail\ResetPasswordMail;
use App\Models\ResetPasswordToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class resetPasswordController extends Controller
{
    public function requestResetPassword(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email:rfc,dns',
            ];

            $validate = Validator::make($request->all(), $rules);

            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $user = User::where('email', $request->email)->first();
            if (!$user) throw new \Exception("Customer tidak ditemukan");
            $oldToken = ResetPasswordToken::where('id_user', $user->id)->first();
            if ($oldToken) $oldToken->delete();

            $str = Str::random(100);
            $tokenData = [
                'id_user' => $user->id,
                'token' => $str,
            ];
            $newToken = ResetPasswordToken::create($tokenData);
            $details = [
                'username' => $user->nama,
                'datetime' => date('Y-m-d H:i:s'),
                'url' => request()->getHttpHost() . '/reset/password/' . $str
            ];
            Mail::to($user->email)->send(new ResetPasswordMail($details));
            return response()->json([
                'message' => 'Link Reset Password telah dikirim ke email anda. Silahkan cek email anda untuk mereset password.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function resettingPassword($reset_token)
    {
        $token = ResetPasswordToken::where('token', $reset_token)->first();
        if (!$token) {
            $message = "Reset Password Token is Expired";
        } else {
            $message = $token->id_user;
        }
        return view('resetPassword', compact('message'));
    }

    public function updatePassword(Request $request)
    {
        try {
            $newPassword = bcrypt($request->password);
            $user = User::find($request->id);
            if (!$user) throw new \Exception('User not found');
            $user->password = $newPassword;
            $user->save();
            $token = ResetPasswordToken::where('id_user', $user->id)->first();
            $token->delete();
            $message = 'Berhasil Mereset Password';
            return view('resetPassword', compact('message'));
        } catch (\Exception $e) {
            return view('resetPassword', compact('message', $e->getMessage()));
        }
    }
}
