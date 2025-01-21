<?php

use App\Http\Controllers\Web\V1\CategoryController;
use App\Http\Controllers\Web\V1\CMDBController;
use Illuminate\Support\Facades\Route;


Route::get('/', [CategoryController::class, 'index'])->name('categories');
Route::get('/cmdb', [CMDBController::class, 'index'])->name('cmdb.list');
Route::get('/cmdb/export', [CMDBController::class, 'export'])->name('cmdb.export');
Route::post('/cmdb/import', [CMDBController::class, 'import'])->name('cmdb.import');

require __DIR__.'/auth.php';
