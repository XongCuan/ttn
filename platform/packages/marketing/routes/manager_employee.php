<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/marketings')
->name('marketing.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\ManagerMarketingMiddleware::class])
    ->group(function () {

        Route::controller(TCore\Marketing\Http\Controllers\Employee\EmployeeController::class)
        ->prefix('/employees')
        ->name('employee.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });
});