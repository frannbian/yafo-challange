<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CMDBController;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class)->only([
    'index',
]);

Route::prefix('categories')->group(function () {
    Route::get('/{category}/cmdb', [CategoryController::class, 'getCMDBByCategory']);
});

Route::resource('cmdb', CMDBController::class)->only([
    'index',
]);

Route::prefix('cmdb')->group(function () {
    Route::get('/export', [CMDBController::class, 'export']);
    Route::post('/import', [CMDBController::class, 'import']);
});
