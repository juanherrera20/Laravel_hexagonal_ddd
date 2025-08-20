<?php

// use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Src\IdentityAndAccess\User\Infrastructure\Controllers\UserController;


Route::prefix('users')->group(function () {
    
    // Registro de usuario
    Route::post('/register', [UserController::class, 'register']);

    // Login
    Route::post('/login', [UserController::class, 'login']);

    // Requieren autenticación con Sanctum
    Route::middleware('auth:sanctum')->group(function () {

        // Logout
        Route::post('/logout', [UserController::class, 'logout']);

        // Buscar usuario por ID
        Route::get('/{id}', [UserController::class, 'show']);
    });
});
