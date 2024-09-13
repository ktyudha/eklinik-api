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

                // Patients
                Route::get('/patients', [PatientController::class, 'index']);
                Route::post('/patients', [PatientController::class, 'store']);
                Route::get('/patients/{id}', [PatientController::class, 'show']);
                Route::put('/patients/{id}', [PatientController::class, 'update']);
                Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

                // Classifications
                Route::get('/classifications', [ClassificationController::class, 'index']);
                Route::post('/classifications', [ClassificationController::class, 'store']);
                Route::get('/classifications/{id}', [ClassificationController::class, 'show']);
                Route::put('/classifications/{id}', [ClassificationController::class, 'update']);
                Route::delete('/classifications/{id}', [ClassificationController::class, 'destroy']);

                Route::apiResource('medicals', MedicalController::class);
            });
        }
    );
});
