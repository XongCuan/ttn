<?php

use Illuminate\Support\Facades\Route;
use TCore\LeaveRequest\Http\Controllers\LeaveRequestController;

Route::prefix('/leave-request')
    ->name('leave_request.')
    ->middleware([TCore\Acl\Http\Middleware\AuthMiddleware::class])
    ->group(function () {

        Route::controller(LeaveRequestController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/update', 'update')->name('update');
            Route::get('/show/{id}', 'show')->name('show');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });
    });
