<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/sales')
->name('sales.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\ManagerSalesMiddleware::class])
    ->group(function () {

        Route::controller(TCore\Sales\Http\Controllers\Employee\EmployeeController::class)
        ->prefix('/employees')
        ->name('employee.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });
});