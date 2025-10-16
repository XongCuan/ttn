<?php

use Illuminate\Support\Facades\Route;

Route::middleware([TCore\Acl\Http\Middleware\SalesMiddleware::class])
->prefix('/sales')
->name('sales.')
->group(function() {

    Route::get('/select-employees/{team_id?}', [TCore\Sales\Http\Controllers\SelectEmployeeController::class, 'lists'])->name('select_employee');

    Route::get('/select-team', [TCore\Sales\Http\Controllers\SelectTeamController::class, 'lists'])->name('select_team');

    Route::get('/select-customer', [TCore\Sales\Http\Controllers\SelectCustomerController::class, 'lists'])->name('select_customer');

    Route::middleware([TCore\Acl\Http\Middleware\ManagerSalesMiddleware::class])->group(function() {
        Route::controller(TCore\Sales\Http\Controllers\SettingController::class)
        ->prefix('/settings')->as('setting.')->group(function () {
            Route::get('/kpi', 'kpi')->name('kpi');
            Route::put('/update', 'update')->name('update');
        });

        Route::controller(TCore\Sales\Http\Controllers\LeaveRequestController::class)->prefix('/leave-request')
        ->name('leave_request.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });

    Route::middleware([TCore\Acl\Http\Middleware\LeaderSalesMiddleware::class])->group(function() {
    
        Route::controller(TCore\Sales\Http\Controllers\SourceController::class)
        ->prefix('/sources')
        ->name('source.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/update', 'update')->name('update');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });

        Route::controller(TCore\Sales\Http\Controllers\Contact\ContactTypeController::class)
        ->prefix('/contact-type')
        ->name('contact_type.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/update', 'update')->name('update');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });

        Route::controller(TCore\Sales\Http\Controllers\RangePriceController::class)
        ->prefix('/range-price')
        ->name('range_price.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/update', 'update')->name('update');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });

        Route::controller(TCore\Sales\Http\Controllers\SectorController::class)
        ->prefix('/sector')
        ->name('sector.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/update', 'update')->name('update');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });
    });
});
