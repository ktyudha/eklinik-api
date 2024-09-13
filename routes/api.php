<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Medical\MedicalController;
use App\Http\Controllers\Api\Patient\PatientController;
use App\Http\Controllers\Api\Classification\ClassificationController;

Route::prefix('v1')->group(function () {

    // =========================== ADMIN API ===========================

    // Admin Login
    Route::prefix('auth/admin')->group(function () {
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
        Route::get('/me', [AdminAuthController::class, 'user'])->name('admin.me');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });

    Route::middleware(['auth:api'])->group(
        function () {
            Route::prefix('admin')->group(function () {

                // Route::apiResource('users', UserController::class);

                // Group
                Route::get('/patients', [PatientController::class, 'index']);
                Route::post('/patients', [PatientController::class, 'store']);
                Route::get('/patients/{id}', [PatientController::class, 'show']);
                Route::put('/patients/{id}', [PatientController::class, 'update']);
                Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

                Route::apiResource('classifications', ClassificationController::class);
                Route::apiResource('medicals', MedicalController::class);
            });
        }
    );
});
