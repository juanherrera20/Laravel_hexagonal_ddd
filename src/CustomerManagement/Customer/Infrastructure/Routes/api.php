<?php

use Illuminate\Support\Facades\Route;
use Src\CustomerManagement\Customer\Infrastructure\Controllers\CustomerController;

// Route::prefix('customers')->group(function () {
//     Route::get('/', [CustomerController::class, 'index']);      // Listar
//     Route::post('/', [CustomerController::class, 'store']);     // Crear
//     Route::get('{id}', [CustomerController::class, 'show']);    // Obtener por ID
//     Route::put('{id}', [CustomerController::class, 'update']);  // Actualizar
//     Route::delete('{id}', [CustomerController::class, 'destroy']); // Eliminar
// }); 



Route::prefix('customers')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/', [CustomerController::class, 'index']);        // Listar
        Route::post('/', [CustomerController::class, 'store']);       // Crear
        Route::get('{id}', [CustomerController::class, 'show']);      // Obtener por ID
        Route::put('{id}', [CustomerController::class, 'update']);    // Actualizar
        Route::delete('{id}', [CustomerController::class, 'destroy']); // Eliminar
    });
