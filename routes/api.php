<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurabayaBusController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Menu\MenuController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Menu\SubMenuController;
use App\Http\Controllers\Api\Region\RegionController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Medical\MedicalController;
use App\Http\Controllers\Api\Medicine\RecipeController;
use App\Http\Controllers\Api\Patient\PatientController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\Medicine\MedicineController;
use App\Http\Controllers\Api\Queue\QueueMedicalController;
use App\Http\Controllers\Api\Medical\PatientMedicalController;
use App\Http\Controllers\Api\Medicine\MedicineCategoryController;
use App\Http\Controllers\Api\Classification\ClassificationController;

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

                // Medicine Category
                Route::get('/medicine-category', [MedicineCategoryController::class, 'index']);
                Route::post('/medicine-category', [MedicineCategoryController::class, 'store']);
                Route::get('/medicine-category/{id}', [MedicineCategoryController::class, 'show']);
                Route::put('/medicine-category/{id}', [MedicineCategoryController::class, 'update']);
                Route::delete('/medicine-category/{id}', [MedicineCategoryController::class, 'destroy']);

                // Medicine Category
                Route::get('/medicines', [MedicineController::class, 'index']);
                Route::post('/medicines', [MedicineController::class, 'store']);
                Route::get('/medicines/{id}', [MedicineController::class, 'show']);
                Route::put('/medicines/{id}', [MedicineController::class, 'update']);
                Route::delete('/medicines/{id}', [MedicineController::class, 'destroy']);

                // Recipes
                Route::get('/recipes', [RecipeController::class, 'index']);
                Route::post('/recipes', [RecipeController::class, 'store']);
                Route::get('/recipes/{id}', [RecipeController::class, 'show']);
                Route::put('/recipes/{id}', [RecipeController::class, 'update']);
                Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);
            });


            // Region
            Route::prefix('region')->group(function () {
                Route::get('/search', [RegionController::class, 'findVillageFilter']);
                Route::get('/provinces', [RegionController::class, 'provinceIndex']);
                Route::get('/cities', [RegionController::class, 'cityIndex']);
                Route::get('/sub-districts', [RegionController::class, 'subDistrictIndex']);
                Route::get('/villages', [RegionController::class, 'villageIndex']);
                Route::get('/countries', [RegionController::class, 'countryIndex']);
                Route::get('/provinces/{id}', [RegionController::class, 'findOneProvince']);
                Route::get('/cities/{id}', [RegionController::class, 'findOneCity']);
                Route::get('/countries/{id}', [RegionController::class, 'findOneCountry']);
                Route::get('/sub-districts/{id}', [RegionController::class, 'findOneSubDistrict']);
                Route::get('/villages/{id}', [RegionController::class, 'findOneVillage']);
            });
        }
    );

    // =========================== PATIENT API ===========================
    Route::middleware(['auth:patient-api'])->group(
        function () {
            Route::prefix('patient')->group(function () {

                // Appointment
                Route::get('/appointments', [QueueMedicalController::class, 'index']);
                Route::post('/appointments', [QueueMedicalController::class, 'store']);
                Route::get('/appointments/{id}', [QueueMedicalController::class, 'show']);
                Route::put('/appointments/{id}', [QueueMedicalController::class, 'update']);
                Route::delete('/appointments/{id}', [QueueMedicalController::class, 'destroy']);


                // Medical History
                Route::get('medicals', [PatientMedicalController::class, 'index']);
            });
        }
    );

    // =========================== GLOBAL API ===========================
    Route::middleware(['auth:api,patient-api'])->group(
        function () {

            // Payment Medical and Reciipe
            Route::get('/payments', [PaymentController::class, 'index']);
            Route::post('/payments', [PaymentController::class, 'store']);
            Route::get('/payments/{id}', [PaymentController::class, 'show']);
            Route::put('/payments/{id}', [PaymentController::class, 'update']);
            Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);
        }
    );
});
