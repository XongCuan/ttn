<?php

use Illuminate\Support\Facades\Route;


Route::prefix('/working-times')
    ->name('working_time.')
    ->middleware([TCore\Acl\Http\Middleware\AuthMiddleware::class])
    ->group(function () {

        Route::controller(TCore\WorkingTime\Http\Controllers\WorkingTimeController::class)->group(function () {
            
            Route::middleware([TCore\Acl\Http\Middleware\SuperadminMiddleware::class])->group(function () {
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::put('/update', 'update')->name('update');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
            
            Route::middleware(TCore\Acl\Http\Middleware\ManagerMiddleware::class)->group(function() {
                Route::get('/dashboard', 'dashboard')->name('dashboard');
                Route::get('/employee', 'index')->name('index_employee');
            });
            
            Route::get('/', 'index')->name('index');
            Route::post('/checkin', 'checkin')->name('checkin');
            Route::put('/checkout', 'checkout')->name('checkout');
        });
    });


//Type Overtime
Route::prefix('/type-overtime')->as('type_overtime.')
    ->middleware([TCore\Acl\Http\Middleware\AuthMiddleware::class, TCore\Acl\Http\Middleware\SuperadminMiddleware::class])
    ->group(function () {
        Route::controller(TCore\WorkingTime\Http\Controllers\TypeOvertimeController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/edit', 'update')->name('update');
            Route::post('/add', 'store')->name('store');
            Route::delete('/delete/{id}', 'delete')->name('delete');

            Route::get('/select-search', 'selectSearch')->name('search_select');
        });
    });

Route::prefix('/workingtime-ticket')->as('workingtime_ticket.')
->middleware([TCore\Acl\Http\Middleware\AuthMiddleware::class])
->group(function () {
    Route::controller(TCore\WorkingTime\Http\Controllers\WorkingTimeTicketController::class)->group(function () {
        Route::get('/', 'index')->name('index');

        Route::middleware(TCore\Acl\Http\Middleware\ManagerMiddleware::class)->group(function() {
            Route::get('/employee', 'index')->name('index_employee');
            Route::get('/confirm/{id}', 'confirm')->name('confirm');
            Route::put('/handle-confirm', 'handleConfirm')->name('handle_confirm');
        });
        Route::get('/show/{id}', 'show')->name('show');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update', 'update')->name('update');
        Route::post('/store', 'store')->name('store');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
});

//Overtime
Route::prefix('/working-overtime')->as('working_overtime.')
    ->middleware([TCore\Acl\Http\Middleware\AuthMiddleware::class])
    ->group(function () {
        Route::controller(TCore\WorkingTime\Http\Controllers\WorkingOvertimeController::class)->group(function () {
            Route::get('/', 'index')->name('index');

            Route::middleware([TCore\Acl\Http\Middleware\SuperadminMiddleware::class])->group(function () {
                Route::get('/add', 'create')->name('create');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/edit', 'update')->name('update');
                Route::post('/add', 'store')->name('store');
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
        });
    });
