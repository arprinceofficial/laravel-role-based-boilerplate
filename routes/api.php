<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/otp-request', [AuthController::class, 'otpRequest']);
Route::post('/otp-verify', [AuthController::class, 'otpVerify']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/current-user', [AuthController::class, 'currentUser']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
