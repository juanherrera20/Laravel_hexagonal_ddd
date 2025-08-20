<?php

use Illuminate\Support\Facades\Route;
use Src\OrderManagement\Order\Infrastructure\Controllers\OrderController;

Route::prefix('order')->controller(OrderController::class)->group(function () {

});