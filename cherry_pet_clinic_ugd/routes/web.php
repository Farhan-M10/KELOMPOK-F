<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\KategoriController;



// Route Login
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route Dashboard (dilindungi middleware auth)
Route::middleware(['auth'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        return view('admin.layouts.app');
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
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('suppliers', SupplierController::class);
});
Route::get('/suppliers', [SupplierController::class, 'index'])
            ->name('admin.suppliers.index');

Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.layouts.app');
    })->name('dashboard');

    // Kategori
    Route::resource('kategori', KategoriController::class);

    // Jenis Barang
    Route::resource('jenisbarang', JenisBarangController::class);
});

Route::get('/kategori', function () {
    return redirect()->route('admin.kategori.index');
    });
Route::get('/jenis-barang', function () {
    return redirect()->route('admin.jenis_barang.index');
    });
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('kategori', KategoriController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('jenis_barang', JenisBarangController::class);
});
