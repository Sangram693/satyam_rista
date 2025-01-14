<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalesmanController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SalesPersonController;

use App\Http\Controllers\TestController;

Route::get('/test', [TestController::class, 'index']);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('create/superAdmin', [SuperAdminController::class, 'store'])->name('create.superAdmin');

Route::post('login', [SalesPersonController::class, 'login'])->name('login');

Route::resource('admin', AdminController::class)->middleware('auth:sanctum');

