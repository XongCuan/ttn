<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/internals')
->name('internal.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\InternalMiddleware::class])
    ->group(function () {
        Route::controller(TCore\Internal\Http\Controllers\Employee\EmployeeController::class)
        ->prefix('/employees')
        ->name('employee.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });
});