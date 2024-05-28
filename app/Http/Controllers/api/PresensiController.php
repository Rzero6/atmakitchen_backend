<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PresensiController extends Controller
{
    public function index()
    {
        try {
            $presensi = Presensi::with('karyawan.user', 'karyawan.user.role')->get();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $presensi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    public function show()
    {
        try {
            $presensiHariIni = Presensi::where('tanggal', Carbon::now()->toDateString())->first();
            if (!$presensiHariIni) {
                $dateHariIni = Carbon::now()->toDateString();
                $karyawan = Karyawan::all();
                foreach ($karyawan as $akaryawan) {
                    $presensiBaru = [
                        'id_karyawan' => $akaryawan->id,
                        'tanggal' => $dateHariIni,
                        'kehadiran' => 1,
                    ];
                    Presensi::create($presensiBaru);
                }
            }
            $presensi = Presensi::with('karyawan.user', 'karyawan.user.role')->where('tanggal', Carbon::now()->toDateString())->get();

            if (!$presensi) throw new \Exception("Presensi tidak ditemukan");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $presensi
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }

    public function update($id)
    {
        try {
            $presensi = Presensi::find($id);
            if (!$presensi) throw new \Exception("Presensi tidak ditemukan");
            $presensi->kehadiran = !$presensi->kehadiran;
            $presensi->save();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data',
                "data" => $presensi
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
