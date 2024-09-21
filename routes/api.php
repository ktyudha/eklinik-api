<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Menu\MenuController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Menu\SubMenuController;
use App\Http\Controllers\Api\Region\RegionController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Medical\MedicalController;
use App\Http\Controllers\Api\Patient\PatientController;
use App\Http\Controllers\Api\Classification\ClassificationController;
use App\Http\Controllers\Api\Queue\QueueMedicalController;

Route::prefix('v1')->group(function () {
    // Patient Login
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/me', [AuthController::class, 'user'])->name('me');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

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

                // Register
                Route::post('/user/register', [UserController::class, 'store']);
                Route::put('/user/{id}', [UserController::class, 'update']);

                // Medical
                Route::apiResource('medical', MedicalController::class);

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


            // Region
            Route::prefix('region')->group(function () {
                Route::get('/provinces', [RegionController::class, 'provinceIndex']);
                Route::get('/cities', [RegionController::class, 'cityIndex']);
                Route::get('/sub-districts', [RegionController::class, 'subDistrictIndex']);
                Route::get('/countries', [RegionController::class, 'countryIndex']);
                Route::get('/provinces/{id}', [RegionController::class, 'findOneProvince']);
                Route::get('/cities/{id}', [RegionController::class, 'findOneCity']);
                Route::get('/countries/{id}', [RegionController::class, 'findOneCountry']);
            });
        }
    );

    // =========================== PATIENT API ===========================
    Route::middleware(['auth:patient-api'])->group(
        function () {
            Route::prefix('patient')->group(function () {

                // Menu
                Route::get('/appointments', [QueueMedicalController::class, 'index']);
                Route::post('/appointments', [QueueMedicalController::class, 'store']);
                Route::get('/appointments/{id}', [QueueMedicalController::class, 'show']);
                Route::put('/appointments/{id}', [QueueMedicalController::class, 'update']);
                Route::delete('/appointments/{id}', [QueueMedicalController::class, 'destroy']);
            });
        }
    );
});
