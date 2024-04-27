<?php

use App\Http\Controllers\api\AdminAuthController;
use App\Http\Controllers\api\BahanBakuController;
use App\Http\Controllers\api\PengeluaranLainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PenitipController;
use App\Http\Controllers\api\RoleController;
use App\Http\Controllers\api\UserAuthController;
use App\Http\Middleware\RoleMiddleware;

Route::post("/login", [UserAuthController::class, "login"]);
Route::post("/admin/login", [AdminAuthController::class, "login"]);
Route::middleware(['auth:api', RoleMiddleware::class . ':Admin'])->group(function () {

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

    Route::post('/role', [RoleController::class, 'store']);
    Route::get('/role/{id}', [RoleController::class, 'show']);
    Route::put('/role/{id}', [RoleController::class, 'update']);
    Route::delete('/role/{id}', [RoleController::class, 'destroy']);
});

Route::get('/role', [RoleController::class, 'index']);
