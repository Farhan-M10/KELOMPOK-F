<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// Route Login
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route Dashboard (dilindungi middleware auth)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    // Dashboard Staff
    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    })->middleware('role:staff')->name('staff.dashboard');

    // Route umum untuk dashboard
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('staff.dashboard');
    })->name('dashboard');
});

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});