<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\{LoginController , RegisterController} ;
use App\Http\Controllers\Api\OrderController;

Route::post('register' , [RegisterController::class , 'register']);
Route::post('login' , [LoginController::class , 'login']) ;


Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('order', OrderController::class) ;
});



