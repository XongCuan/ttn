<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/marketings')
->name('marketing.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\MarketingMiddleware::class])
    ->group(function () {

        Route::controller(TCore\Marketing\Http\Controllers\Contact\ContactController::class)
        ->prefix('/contacts')
        ->name('contact.')
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