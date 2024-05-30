<?php

use App\Http\Controllers\api\AdminAuthController;
use App\Http\Controllers\api\BahanBakuController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\DetailHampersController;
use App\Http\Controllers\api\DetailTransaksiController;
use App\Http\Controllers\api\KaryawanController;
use App\Http\Controllers\api\PengeluaranLainController;
use App\Http\Controllers\api\HampersController;
use App\Http\Controllers\api\PembelianBahanBakuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PenitipController;
use App\Http\Controllers\api\PresensiController;
use App\Http\Controllers\api\ProdukController;
use App\Http\Controllers\api\ResepController;
use App\Http\Controllers\api\resetPasswordController;
use App\Http\Controllers\api\RoleController;
use App\Http\Controllers\api\TransaksiController;
use App\Http\Controllers\api\UserAuthController;
use App\Http\Middleware\RoleMiddleware;

Route::post("/login", [UserAuthController::class, "login"]);
Route::post("/register", [UserAuthController::class, "register"]);
Route::post("/admin/login", [AdminAuthController::class, "login"]);
Route::post("/password/reset", [resetPasswordController::class, "requestResetPassword"]);
Route::get('/role', [RoleController::class, 'index']);
Route::get('/role/{id}', [RoleController::class, 'show']);
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);
Route::get('/hampers', [HampersController::class, 'index']);
Route::get('/hampers/{id}', [HampersController::class, 'show']);

Route::middleware('auth:api')->group(function () {
    Route::put("/password/update/{id}", [UserAuthController::class, "updatePassword"]);
    Route::put("/profile/{id}", [UserAuthController::class, "update"]);

    Route::get("/customer/{id}", [CustomerController::class, "show"]);
    Route::post("/customer/update/profil-pic/{id}", [CustomerController::class, "updateProfilPic"]);

    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/{id}/detail', [DetailTransaksiController::class, 'showByTransaction']);

    Route::get("/customer/{id}/transaksi", [TransaksiController::class, "showByIdUser"]);
    Route::post("/transaksi/{id}", [TransaksiController::class, "uploadBuktiBayar"]);
    Route::get("/transaksi/{id}", [TransaksiController::class, "show"]);
    Route::put("/transaksi/{id}", [TransaksiController::class, "update"]);
    Route::get('/bahanBaku', [BahanBakuController::class, 'index']);
    Route::get("/transaksi/{date}", [TransaksiController::class, "checkStokProduk"]);
});
Route::middleware(['auth:api', RoleMiddleware::class . ':Admin'])->group(function () {
    Route::get('/customer', [CustomerController::class, 'index']);

    Route::post('/bahanBaku', [BahanBakuController::class, 'store']);
    Route::get('/bahanBaku/{id}', [BahanBakuController::class, 'show']);
    Route::put('/bahanBaku/{id}', [BahanBakuController::class, 'update']);
    Route::delete('/bahanBaku/{id}', [BahanBakuController::class, 'destroy']);

    Route::post('/produk/penitip/', [ProdukController::class, 'store']);
    Route::post('/produk', [ProdukController::class, 'storeTanpaPenitip']);
    Route::put('/produk/{id}', [ProdukController::class, 'update']);
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);

    Route::get('/resep', [ResepController::class, 'index']);
    Route::post('/resep', [ResepController::class, 'store']);
    Route::get('/resep/{id}', [ResepController::class, 'show']);
    Route::put('/resep/{id}', [ResepController::class, 'update']);
    Route::delete('/resep/{id}', [ResepController::class, 'destroy']);
    Route::delete('/resep/produk/{idProduk}', [ResepController::class, 'destroyAllPerProduk']);

    Route::post('/hampers', [HampersController::class, 'store']);
    Route::put('/hampers/{id}', [HampersController::class, 'update']);
    Route::delete('/hampers/{id}', [HampersController::class, 'destroy']);

    Route::post('/hampers/detail', [DetailHampersController::class, 'store']);
    Route::delete('/hampers/{id}/detail', [DetailHampersController::class, 'destroyAllPerHampers']);
});
Route::middleware(['auth:api', RoleMiddleware::class . ':Manager Operasional'])->group(function () {

    Route::post('/penitip', [PenitipController::class, 'store']);
    Route::get('/penitip/{id}', [PenitipController::class, 'show']);
    Route::put('/penitip/{id}', [PenitipController::class, 'update']);
    Route::delete('/penitip/{id}', [PenitipController::class, 'destroy']);

    Route::post('/karyawan', [KaryawanController::class, 'store']);
    Route::put('/karyawan/{id}', [KaryawanController::class, 'update']);
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy']);

    Route::get('/pengeluaran', [PengeluaranLainController::class, 'index']);
    Route::post('/pengeluaran', [PengeluaranLainController::class, 'store']);
    Route::get('/pengeluaran/{id}', [PengeluaranLainController::class, 'show']);
    Route::put('/pengeluaran/{id}', [PengeluaranLainController::class, 'update']);
    Route::delete('/pengeluaran/{id}', [PengeluaranLainController::class, 'destroy']);

    Route::get('/presensi', [PresensiController::class, 'index']);
    Route::get('/presensi/hari-ini', [PresensiController::class, 'show']);
    Route::put('/presensi/{id}', [PresensiController::class, 'update']);

    Route::post('/role', [RoleController::class, 'store']);
    Route::put('/role/{id}', [RoleController::class, 'update']);
    Route::delete('/role/{id}', [RoleController::class, 'destroy']);

    Route::get('/pembelianBahan', [PembelianBahanBakuController::class, 'index']);
    Route::post('/pembelianBahan', [PembelianBahanBakuController::class, 'store']);
    Route::get('/pembelianBahan/{id}', [PembelianBahanBakuController::class, 'show']);
    Route::put('/pembelianBahan/{id}', [PembelianBahanBakuController::class, 'update']);
    Route::delete('/pembelianBahan/{id}', [PembelianBahanBakuController::class, 'destroy']);
});

Route::middleware(['auth:api', RoleMiddleware::class . ':Owner'])->group(function () {
    Route::put('/karyawan/gaji-bonus/{id}', [KaryawanController::class, 'updateGajiBonus']);
});

Route::middleware(['auth:api', RoleMiddleware::class . ':Manager Operasional,Admin,Owner'])->group(function () {
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::get('/karyawan/{id}', [KaryawanController::class, 'show']);
    Route::get('/penitip', [PenitipController::class, 'index']);
});
