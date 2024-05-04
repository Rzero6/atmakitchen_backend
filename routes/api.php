<?php

use App\Http\Controllers\api\AdminAuthController;
use App\Http\Controllers\api\BahanBakuController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\KaryawanController;
use App\Http\Controllers\api\PengeluaranLainController;
use App\Http\Controllers\api\HampersController;
use App\Http\Controllers\api\PembelianBahanBakuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PenitipController;
use App\Http\Controllers\api\ProdukController;
use App\Http\Controllers\api\resetPasswordController;
use App\Http\Controllers\api\RoleController;
use App\Http\Controllers\api\UserAuthController;
use App\Http\Middleware\RoleMiddleware;

Route::post("/login", [UserAuthController::class, "login"]);
Route::post("/register", [UserAuthController::class, "register"]);
Route::post("/admin/login", [AdminAuthController::class, "login"]);
Route::post("/password/reset", [resetPasswordController::class, "requestResetPassword"]);
Route::middleware('auth:api')->group(function () {
    Route::post("/password/update/{id}", [UserAuthController::class, "updatePassword"]);
});
Route::middleware(['auth:api', RoleMiddleware::class . ':Admin'])->group(function () {
    Route::get('/customer', [CustomerController::class, 'index']);

    Route::get('/bahanBaku', [BahanBakuController::class, 'index']);
    Route::post('/bahanBaku', [BahanBakuController::class, 'store']);
    Route::get('/bahanBaku/{id}', [BahanBakuController::class, 'show']);
    Route::put('/bahanBaku/{id}', [BahanBakuController::class, 'update']);
    Route::delete('/bahanBaku/{id}', [BahanBakuController::class, 'destroy']);

    Route::post('/produk', [ProdukController::class, 'store']);
    Route::post('/produk', [ProdukController::class, 'storeTanpaPenitip']);
    Route::put('/produk/{id}', [ProdukController::class, 'update']);
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);

    Route::post('/hampers', [HampersController::class, 'store']);
    Route::put('/hampers/{id}', [HampersController::class, 'update']);
    Route::delete('/hampers/{id}', [HampersController::class, 'destroy']);

});
Route::middleware(['auth:api', RoleMiddleware::class . ':Manager Operasional'])->group(function () {

    Route::get('/penitip', [PenitipController::class, 'index']);
    Route::post('/penitip', [PenitipController::class, 'store']);
    Route::get('/penitip/{id}', [PenitipController::class, 'show']);
    Route::put('/penitip/{id}', [PenitipController::class, 'update']);
    Route::delete('/penitip/{id}', [PenitipController::class, 'destroy']);

    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/karyawan', [KaryawanController::class, 'store']);
    Route::get('/karyawan/{id}', [KaryawanController::class, 'show']);
    Route::put('/karyawan/{id}', [KaryawanController::class, 'update']);
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy']);

    Route::get('/pengeluaran', [PengeluaranLainController::class, 'index']);
    Route::post('/pengeluaran', [PengeluaranLainController::class, 'store']);
    Route::get('/pengeluaran/{id}', [PengeluaranLainController::class, 'show']);
    Route::put('/pengeluaran/{id}', [PengeluaranLainController::class, 'update']);
    Route::delete('/pengeluaran/{id}', [PengeluaranLainController::class, 'destroy']);

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
    Route::get('/karyawan/gaji-bonus/{id}', [KaryawanController::class, 'updateGajiBonus']);
});
Route::get('/role', [RoleController::class, 'index']);
Route::get('/role/{id}', [RoleController::class, 'show']);
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);
Route::get('/hampers', [HampersController::class, 'index']);
Route::get('/hampers/{id}', [HampersController::class, 'show']);
