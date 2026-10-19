<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     return view('home');
// });

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

Route::get('/', function () {
    return view('auth.login');
});

// Route::view('/login', 'auth.login')->name('login');