<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import Routes from bounded Contexts
use Src\ProductManagement\Product\Infrastructure\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Crud Products
// Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
// });


Route::group([], function () { // CustomerManagement
    require base_path('src/CustomerManagement/Customer/Infrastructure/Routes/api.php');
});

Route::group([], function () { // OrderManagement
    require base_path('src/OrderManagement/Order/Infrastructure/Routes/api.php');
});

Route::group([], function () { // IdentityAndAccess
    require base_path('src/IdentityAndAccess/User/Infrastructure/Routes/api.php');
});