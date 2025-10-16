<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('login.index');
})->name('home');