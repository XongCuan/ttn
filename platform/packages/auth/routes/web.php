<?php

use Illuminate\Support\Facades\Route;

Route::middleware([TCore\Acl\Http\Middleware\GuestMiddleware::class])
->controller(TCore\Auth\Http\Controllers\LoginController::class)
->prefix('/login')
->name('login.')
->group(function() {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'handle')->name('handle');
});

Route::middleware([TCore\Acl\Http\Middleware\AuthMiddleware::class])->group(function() {

    Route::prefix('/auth')->name('auth.')->group(function() {
        
        Route::controller(TCore\Auth\Http\Controllers\ProfileController::class)
        ->prefix('/profile')
        ->name('profile.')
        ->group(function(){
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
            Route::put('/update-location', 'updateLocation')->name('update_location');
        });

        Route::controller(TCore\Auth\Http\Controllers\ChangePasswordController::class)
        ->prefix('/password')
        ->name('password.')
        ->group(function(){
            Route::get('/', 'index')->name('change');
            Route::put('/', 'update')->name('update');
        });
        
        Route::post('/logout', [TCore\Auth\Http\Controllers\LogoutController::class, 'logout'])->name('logout');
    });
});
