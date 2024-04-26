<?php

use App\Http\Controllers\api\AdminAuthController;
use App\Http\Controllers\api\BahanBakuController;
use App\Http\Controllers\api\PengeluaranLainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PenitipController;
use App\Http\Controllers\api\UserAuthController;

Route::post("/admin/login", [AdminAuthController::class, "login"]);
Route::post("/login", [UserAuthController::class, "login"]);
Route::middleware('auth:admin')->group(function () {

    Route::get('/penitip', [PenitipController::class, 'index']);
    Route::post('/penitip', [PenitipController::class, 'store']);
    Route::get('/penitip/{id}', [PenitipController::class, 'show']);
    Route::put('/penitip/{id}', [PenitipController::class, 'update']);
    Route::delete('/penitip/{id}', [PenitipController::class, 'destroy']);

    Route::get('/pengeluaran', [PengeluaranLainController::class, 'index']);
    Route::post('/pengeluaran', [PengeluaranLainController::class, 'store']);
    Route::get('/pengeluaran/{id}', [PengeluaranLainController::class, 'show']);
    Route::put('/pengeluaran/{id}', [PengeluaranLainController::class, 'update']);
    Route::delete('/pengeluaran/{id}', [PengeluaranLainController::class, 'destroy']);

    Route::get('/bahanBaku', [BahanBakuController::class, 'index']);
    Route::post('/bahanBaku', [BahanBakuController::class, 'store']);
    Route::get('/bahanBaku/{id}', [BahanBakuController::class, 'show']);
    Route::put('/bahanBaku/{id}', [BahanBakuController::class, 'update']);
    Route::delete('/bahanBaku/{id}', [BahanBakuController::class, 'destroy']);
});
