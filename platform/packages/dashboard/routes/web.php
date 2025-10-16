<?php

use Illuminate\Support\Facades\Route;

Route::middleware([TCore\Acl\Http\Middleware\AuthMiddleware::class])
->group(function() {
    Route::get('/dashboard', fn() => view('packages_dashboard::index'))->name('dashboard.index');
});