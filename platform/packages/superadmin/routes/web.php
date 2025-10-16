<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/superadmin')
->name('superadmin.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\SuperadminMiddleware::class])
    ->group(function () {

        //Settings
        Route::controller(TCore\Superadmin\Http\Controllers\SettingController::class)
        ->prefix('/settings')
        ->as('setting.')
        ->group(function () {
            Route::get('/working-time', 'workingTime')->name('working_time');
            Route::put('/update', 'update')->name('update');
        });
        
        //Manager team
        Route::controller(TCore\Superadmin\Http\Controllers\TeamController::class)
        ->prefix('/team')
        ->name('team.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/update', 'update')->name('update');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });


        //Manager admin
        Route::controller(TCore\Superadmin\Http\Controllers\AdminController::class)
        ->prefix('/admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/update', 'update')->name('update');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::delete('/delete/{id}', 'delete')->name('delete');

            // salary
            Route::get('/salary/{id}', 'calculateSalary')->name('salary');
        });
    });

    //Manager admin
    Route::prefix('/select-search')->name('select_search.')->group(function () {
        Route::controller(TCore\Superadmin\Http\Controllers\AdminSearchSelectController::class)
        ->name('admin.')
        ->group(function() {

            Route::get('/employees', 'employees')->name('employee');
            Route::get('/all-employees', 'allEmployees')->name('all_employee');
        });
    });
});
