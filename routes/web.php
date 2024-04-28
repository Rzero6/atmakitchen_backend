<?php

use App\Http\Controllers\api\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::get('register/verify/{verify_key}', [UserAuthController::class, "verify"]);
