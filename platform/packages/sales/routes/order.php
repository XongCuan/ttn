<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/sales')
->name('sales.')
->group(function() {

    Route::middleware([TCore\Acl\Http\Middleware\SalesMiddleware::class])
    ->prefix('/order-arise')
    ->as('order_arise.')
    ->group(function () {
        Route::controller(TCore\Sales\Http\Controllers\Order\OrderAriseController::class)
        ->group(function () {

            Route::middleware([TCore\Acl\Http\Middleware\LeaderSalesMiddleware::class])
            ->group(function () {
                Route::get('/create/{order_id}', 'create')->name('create');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update', 'update')->name('update');
                Route::post('/store', 'store')->name('store');
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
            Route::get('/', 'index')->name('index');
            Route::get('/show/{id}', 'show')->name('show');
        });
    });

    Route::middleware([TCore\Acl\Http\Middleware\SalesMiddleware::class])
    ->prefix('/order-payment')
    ->as('order_payment.')
    ->group(function () {
        Route::controller(TCore\Sales\Http\Controllers\Order\OrderPaymentController::class)
        ->group(function () {

            Route::middleware([TCore\Acl\Http\Middleware\LeaderSalesMiddleware::class])
            ->group(function () {
                Route::get('/create/{order_id?}', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::post('/store-fake', 'storeFake')->name('store_fake');
                Route::put('/update', 'update')->name('update');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
            Route::get('/', 'index')->name('index');
            Route::get('/show/{id}', 'show')->name('show');
        });
    });

    Route::middleware([TCore\Acl\Http\Middleware\SalesMiddleware::class])
    ->prefix('/order-service')
    ->as('order_service.')
    ->group(function () {
        Route::controller(TCore\Sales\Http\Controllers\Order\OrderServiceController::class)
        ->group(function () {
            Route::middleware([TCore\Acl\Http\Middleware\LeaderSalesMiddleware::class])
            ->group(function () {
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::post('/store-fake', 'storeFake')->name('store_fake');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
            Route::get('/', 'index')->name('index');
            Route::get('/show/{id}', 'show')->name('show');
            Route::put('/edit', 'update')->name('update');
        });
    });

    Route::middleware([TCore\Acl\Http\Middleware\SalesMiddleware::class])
    ->group(function () {

        Route::controller(TCore\Sales\Http\Controllers\Order\OrderController::class)
        ->prefix('/orders')
        ->name('order.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/info/{id}', 'info')->name('info');

            Route::middleware([TCore\Acl\Http\Middleware\LeaderSalesMiddleware::class])
            ->group(function () {
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::put('/update', 'update')->name('update');
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
        });
    });
});