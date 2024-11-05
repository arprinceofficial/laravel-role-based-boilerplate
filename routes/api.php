<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

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
    Route::post('/role', [RoleController::class, 'index']);
    Route::post('/role-create', [RoleController::class, 'create']);
    Route::post('/role-update', [RoleController::class, 'update']);
    Route::delete('/role-delete/{id}', [RoleController::class, 'destroy']);

    // Permission
    Route::post('/permission', [PermissionController::class, 'index']);
    Route::post('/permission-create', [PermissionController::class, 'create']);
    Route::post('/permission-update', [PermissionController::class, 'update']);
    Route::delete('/permission-delete/{id}', [PermissionController::class, 'destroy']);
});

