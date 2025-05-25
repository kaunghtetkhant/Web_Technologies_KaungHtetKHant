<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);


Route::middleware('auth:sanctum')->group(function (){
    Route::post('/new_order', [OrderController::class,'store']);

    Route::get('/orders',[OrderController::class,'orders']);

    Route::get('/order/{id}',[OrderController::class,'orderDetails']);

    Route::post('logout',[AuthController::class,'logout']);

    Route::post('profile/update', [AuthController::class,'profileUpdate']);
});
