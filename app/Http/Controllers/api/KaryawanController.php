<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $karyawan = Karyawan::with('user','user.role')->get();

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $karyawan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $storeData = $request->all();
            $validate = Validator::make($storeData, [
                'nama' => 'required|max:50',
                'email' => 'required|email:rfc,dns|unique:users',
                'id_role' => 'required',
                'no_telepon' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $userData = [
                'nama' => $storeData['nama'],
                'email' => $storeData['email'],
                'password' => bcrypt($storeData['nama']),
                'id_role' => $storeData['id_role'],
                'no_telepon' => $storeData['no_telepon'],
            ];
            $user = User::create($userData);
            $karyawanData = [
                'id_user' => $user->id,
                'gaji_harian' => 0,
                'bonus' => 0,
            ];
            $karyawan = Karyawan::create($karyawanData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data',
                "data" => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $karyawan = Karyawan::find($id);

            if (!$karyawan) throw new \Exception("Karyawan tidak ditemukan");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $karyawan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $karyawan = User::find($id);

            if (!$karyawan) throw new \Exception("Karyawan tidak ditemukan");
            $updatedData = $request->all();

            $currentEmail = $karyawan->email;
            $emailValidationRule = $currentEmail === $updatedData['email'] ? 'required|email:rfc,dns' : 'required|email:rfc,dns|unique:users,email';

            $validate = Validator::make($updatedData, [
                'nama' => 'required|max:50',
                'email' => $emailValidationRule,
                'id_role' => 'required',
                'no_telepon' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $karyawan->update($updatedData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $karyawan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    public function updateGajiBonus(Request $request, $id)
    {
        try {
            $karyawan = Karyawan::where('id_user', $id)->first();

            if (!$karyawan) throw new \Exception("Karyawan tidak ditemukan");
            $updatedData = $request->all();
            $validate = Validator::make($updatedData, [
                'gaji_harian' => 'required',
                'bonus' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $karyawan->update($updatedData);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $karyawan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $karyawan = Karyawan::where('id_user', $id)->first();
            if (!$karyawan) throw new \Exception("Karyawan tidak ditemukan");
            $user = User::find($id);
            if (!$user) throw new \Exception("User tidak ditemukan");
            $karyawan->delete();
            $user->delete();

            return response()->json([
                "status" => true,
                "message" => 'Berhasil hapus data'
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
