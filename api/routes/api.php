<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomWorkoutController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\ProgressLogController;
use App\Http\Controllers\WorkoutTemplate;
use App\Http\Controllers\WorkoutTemplateController;
use App\Models\ProgressLog;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

// Route lié aux exercices
Route::prefix('exercises')->group(function () {
    Route::get('/', [ExerciseController::class, 'index'])->name('exercises');
    Route::get('/{exercises}', [ExerciseController::class, 'show'])->name('exercises.show');
    Route::put('/update/{exercises}', [ExerciseController::class, 'update'])->name('exercises.update');
});

// Routes liées aux templates d'entraînement
Route::prefix('workout-templates')->group(function () {
    Route::get('/', [WorkoutTemplateController::class, 'index'])->name('workout-templates.index');
    Route::get('/{workoutTemplate}', [WorkoutTemplateController::class, 'show'])->name('workout-templates.show');
});

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
    
    Route::prefix('progresslog')->group(function () {
        Route::get('/', [ProgressLogController::class, 'index'])->name('progresslog.index');
        Route::post('/store', [ProgressLogController::class, 'store'])->name('progresslog.store');
        Route::get('/user', [ProgressLogController::class, 'show'])->name('progresslog.show');
        Route::put('/update/{progressLog}', [ProgressLogController::class, 'update'])->name('progresslog.update');
        Route::put('/delete/{progressLog}', [ProgressLogController::class, 'destroy'])->name('progresslog.destroy');
    });
    
    Route::prefix('workout-templates')->group(function () {
        Route::post('/store', [WorkoutTemplateController::class, 'store'])->name('workout-templates.store');
        Route::put('/update/{workoutTemplate}', [WorkoutTemplateController::class, 'update'])->name('workout-templates.update');
        Route::delete('/delete/{workoutTemplate}', [WorkoutTemplateController::class, 'destroy'])->name('workout-templates.destroy');
    });

    Route::prefix('custom-workout')->group(function () {
        Route::post('/store', [CustomWorkoutController::class, 'store'])->name('custom-workout.store');
        Route::get('/', [CustomWorkoutController::class, 'index'])->name('workout-templates.index');
        Route::get('/{customWorkout}', [CustomWorkoutController::class, 'show'])->name('workout-templates.show');
        Route::put('/update/{customWorkout}', [CustomWorkoutController::class, 'update'])->name('custom-workout.update');
        Route::put('/delete/{customWorkout}', [CustomWorkoutController::class, 'destroy'])->name('custom-workout.destroy');
    });
});
