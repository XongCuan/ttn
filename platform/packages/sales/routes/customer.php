<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/sales')
    ->name('sales.')
    ->group(function () {
        Route::middleware([TCore\Acl\Http\Middleware\SalesMiddleware::class])
            ->group(function () {

                Route::controller(TCore\Sales\Http\Controllers\Customer\CustomerController::class)
                    ->prefix('/customers')
                    ->name('customer.')
                    ->group(function () {
                        Route::get('/', 'index')->name('index');


                        Route::get('/create', 'create')->name('create');
                        Route::post('/store', 'store')->name('store');
                        Route::put('/update', 'update')->name('update');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::delete('/delete/{id}', 'delete')->name('delete');
                    });
                
                 Route::controller(TCore\Sales\Http\Controllers\Enq\EnqController::class)
                    ->prefix('/enqs')
                    ->name('enq.')
                    ->group(function () {
                        Route::get('/', 'index')->name('index');


                        Route::get('/create', 'create')->name('create');
                        Route::post('/store', 'store')->name('store');
                        Route::put('/update', 'update')->name('update');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::delete('/delete/{id}', 'delete')->name('delete');
                    });    

                Route::controller(TCore\Sales\Http\Controllers\Customer\CustomerReturnController::class)
                    ->prefix('/customers-return')
                    ->name('customer_return.')
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
