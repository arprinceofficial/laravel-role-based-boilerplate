<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/otp-request', [AuthController::class, 'otpRequest']);
Route::post('/otp-verify', [AuthController::class, 'otpVerify']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('sso-login', [AuthController::class, 'ssoFirebaseLogin']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/current-user', [AuthController::class, 'currentUser']);
    Route::get('/logout', [AuthController::class, 'logout']);

    // Role
    Route::post('/roles', [RoleController::class, 'index']);
    Route::post('/roles-create', [RoleController::class, 'create']);
    Route::post('/roles-update', [RoleController::class, 'update']);
    Route::delete('/roles-delete/{id}', [RoleController::class, 'destroy']);
});

