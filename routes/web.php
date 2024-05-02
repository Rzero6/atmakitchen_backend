<?php

use App\Http\Controllers\api\resetPasswordController;
use App\Http\Controllers\api\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::get('register/verify/{verify_key}', [UserAuthController::class, "verify"]);
Route::get('reset/password/{reset_token}', [resetPasswordController::class, "resettingPassword"]);
Route::post("/password/update", [resetPasswordController::class, "updatePassword"])->name('update.password');
