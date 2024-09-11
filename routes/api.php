<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Patient\PatientController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Route::prefix('auth')->group(function () {
    //     Route::post('/login', [AuthController::class, 'login']);
    // });
    Route::get('/test', function () {
        return "Hello this is test";
    });

    Route::apiResource('users', UserController::class);
    Route::apiResource('patients', PatientController::class);
});
