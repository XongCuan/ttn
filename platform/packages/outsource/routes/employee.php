<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/outsources')
->name('outsource.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\ManagerOutsourceMiddleware::class])
    ->group(function () {
        Route::controller(TCore\Outsource\Http\Controllers\Employee\EmployeeController::class)
        ->prefix('/employees')
        ->name('employee.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });
});