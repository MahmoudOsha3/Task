<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\{LoginController , RegisterController} ;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StockController;

Route::post('register' , [RegisterController::class , 'register']);
Route::post('login' , [LoginController::class , 'login']) ;

Route::middleware('auth:sanctum')->group(function(){
    Route::post('order', [OrderController::class , 'store'])->name('order.store') ;
    Route::put('order/receive/{order}', [OrderController::class , 'receive'])->name('order.receive') ;
    Route::get('stock/{product}' , [StockController::class , 'getProductStockDetails'])->name('stock.product');
});



