<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalesmanController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SalesPersonController;
use App\Http\Controllers\DealerDistributorController;

Route::post('create/superAdmin', [SuperAdminController::class, 'store'])->name('create.superAdmin');

Route::post('login', [SalesPersonController::class, 'login'])->name('login');
Route::post('dealerdistributor/login', [DealerDistributorController::class, 'login'])->name('dealerdistributor.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('salesman', SalesmanController::class);
    Route::apiResource('admin', AdminController::class);
    Route::apiResource('zone', ZoneController::class);
    Route::get('logout', [SalesPersonController::class, 'logout'])->name('logout');
    Route::get('dealerdistributor/logout', [DealerDistributorController::class, 'logout'])
    ->name('dealerdistributor.logout');
    Route::get('dealerdistributor/verify/{id}', [DealerDistributorController::class, 'verify'])
    ->name('dealerdistributor.verify');
    Route::apiResource('dealerdistributor', DealerDistributorController::class);
    

});

Route::get('test', [TestController::class, 'index'])->name('test');
