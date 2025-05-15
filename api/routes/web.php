<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
/** 

*    Route::prefix('api')->group(function () {

*        Route::prefix('user')->group(function () {
*            Route::get('/', [UserController::class, 'index'])->name('user.index');
*            Route::post('/store', [UserController::class, 'store'])->name('user.store');
*            Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
*            Route::put('/update/{user}', [UserController::class, 'update'])->name('user.update');
*            Route::put('/update/personal_informations/{user}', [UserController::class, 'updatePersonalInformations'])->name('user.updatePersonal');
*            Route::put('/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');
            
*        });

*    });
    
*/