<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GeneralController;

Route::get('/', function () {
    return redirect('/admin/login');
});


Route::middleware('api')->prefix('api')->group(function () {
    Route::get('/categories', [GeneralController::class, 'categories']);

    Route::get('/subcategories', [GeneralController::class, 'subcategories']);

    Route::get('/brands', [GeneralController::class, 'brands']);

    Route::get('/products', [GeneralController::class, 'products']);
    Route::get('/product/{product}', [GeneralController::class, 'productDetails']);

});


Route::get('download/{item}', [GeneralController::class, 'download']);
