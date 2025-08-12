<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth Routes
// Route::post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);

//     return ['token' => $token->plainTextToken];
// });

Route::post('/auth/register', [AuthController::class, 'registerUser']);

Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::get('/auth/logout', [AuthController::class, 'logoutUser'])->middleware("auth:sanctum");


// Posts Routes
Route::get('/posts', [PostController::class,'index'])->middleware("auth:sanctum");

Route::post('/posts', [PostController::class,'store'])->middleware("auth:sanctum");

Route::put('/posts/{id}', [PostController::class,'update'])->middleware("auth:sanctum");

Route::delete('/posts/{id}', [PostController::class,'destroy'])->middleware("auth:sanctum");



