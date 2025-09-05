
<?php

use Illuminate\Support\Facades\Route;
use Src\OrderManagement\Order\Infrastructure\Controllers\OrderController;

// Aplicar el middleware 'auth:sanctum' a todas las rutas de órdenes si es necesario que estén autenticadas.
// Si solo algunas rutas requieren autenticación, se pueden aplicar individualmente.
Route::middleware('auth:sanctum')->group(function () {
    // Ruta para crear una nueva orden
    Route::post('/', [OrderController::class, 'store']);

    // Ruta para listar las órdenes de un cliente específico
    // customerId es un segmento de la URL que se pasa al método indexByCustomer.
    Route::get('/customers/{customerId}', [OrderController::class, 'indexByCustomer']);

    // Ruta para calcular el total gastado por un cliente específico
    // customerId es un segmento de la URL que se pasa al método totalSpentByCustomer.
    Route::get('/customers/{customerId}/total-spent', [OrderController::class, 'totalSpentByCustomer']);
    
});