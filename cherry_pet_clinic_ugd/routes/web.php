<?php

use Illuminate\Support\Facades\Route;

// Halaman Login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Proses Login
Route::post('/login', function () {
    // Logic login akan ditambahkan nanti
})->name('login.submit');