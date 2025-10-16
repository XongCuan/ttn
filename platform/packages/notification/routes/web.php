<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/notifications')
->name('notification.')
->group(function() {
    Route::controller(TCore\Notification\Http\Controllers\NotificationContentController::class)
        ->prefix('/notification-contents')
        ->name('notification_content.')
        ->group(function () {
            Route::middleware([TCore\Acl\Http\Middleware\ManagerMiddleware::class])
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::delete('/delete/{id}', 'delete')->name('delete');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update', 'update')->name('update');
            });
            
            Route::get('/show/{id}', 'show')->name('show');
        });
    

    Route::controller(TCore\Notification\Http\Controllers\NotificationController::class)
        ->prefix('/notifications')
        ->name('notification.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/show/{id}', 'show')->name('show');
        });
});