<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Medical\MedicalController;
use App\Http\Controllers\Api\Patient\PatientController;
use App\Http\Controllers\Api\Classification\ClassificationController;
use App\Http\Controllers\Api\Menu\MenuController;
use App\Http\Controllers\Api\Menu\SubMenuController;

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
                // Route::apiResource('medicals', MedicalController::class);

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

                // Menu
                Route::get('/menu', [MenuController::class, 'index']);
                Route::post('/menu', [MenuController::class, 'store']);
                Route::get('/menu/{id}', [MenuController::class, 'show']);
                Route::put('/menu/{id}', [MenuController::class, 'update']);
                Route::delete('/menu/{id}', [MenuController::class, 'destroy']);

                // SubMenu
                Route::get('/sub-menu', [SubMenuController::class, 'index']);
                Route::post('/sub-menu', [SubMenuController::class, 'store']);
                Route::get('/sub-menu/{id}', [SubMenuController::class, 'show']);
                Route::put('/sub-menu/{id}', [SubMenuController::class, 'update']);
                Route::delete('/sub-menu/{id}', [SubMenuController::class, 'destroy']);
            });
        }
    );
});
