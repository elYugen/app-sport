<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MeasurementController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes utilisateur 
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::put('/update/personal_informations/{user}', [UserController::class, 'updatePersonalInformations'])->name('user.updatePersonal');
        Route::put('/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    // Routes de mesures
    Route::prefix('measurement')->group(function () {
        Route::get('/', [MeasurementController::class, 'index'])->name('measurement.index');
        Route::post('/store', [MeasurementController::class, 'store'])->name('measurement.store');
        Route::get('/user', [MeasurementController::class, 'show'])->name('measurement.show');
        Route::put('/update/{measurements}', [MeasurementController::class, 'update'])->name('measurement.update');
        Route::put('/delete/{measurements}', [MeasurementController::class, 'destroy'])->name('measurement.destroy');
    });    
});
