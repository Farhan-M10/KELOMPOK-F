<?php
// File: routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PengadaanController;




// ==========================================
// ROUTE LOGIN
// ==========================================
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// ROUTE ROOT
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// ROUTE AUTHENTICATED
// ==========================================
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('staff.dashboard');
    })->name('dashboard');

});

// ==========================================
// ROUTE ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.layouts.app');
    })->name('dashboard');

    // Suppliers
    Route::resource('suppliers', SupplierController::class);

    // Kategori
    Route::resource('kategori', KategoriController::class);

    // Jenis Barang
    Route::resource('jenis_barang', JenisBarangController::class);

    // Stok Barang
    Route::prefix('stok_barang')->name('stok_barang.')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::get('/create', [BarangController::class, 'create'])->name('create');
        Route::post('/', [BarangController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BarangController::class, 'update'])->name('update');
        Route::delete('/{id}', [BarangController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/batch', [BarangController::class, 'addBatch'])->name('add-batch');
        Route::get('/export', [BarangController::class, 'export'])->name('export');
        });

    });

// Pengadaan Routes
Route::resource('pengadaan', PengadaanController::class);
Route::post('pengadaan/{id}/update-status', [PengadaanController::class, 'updateStatus'])->name('pengadaan.updateStatus');
Route::get('pengadaan/get-harga-barang/{id}', [PengadaanController::class, 'getHargaBarang'])->name('pengadaan.getHargaBarang');
// Route::prefix('pengadaan')->name('pengadaan.')->group(function () {
//     Route::get('/', [PengadaanController::class, 'index'])->name('index');
//     Route::get('/create', [PengadaanController::class, 'create'])->name('create');
//     Route::post('/', [PengadaanController::class, 'store'])->name('store');
//     Route::get('/{id}', [PengadaanController::class, 'show'])->name('show');
//     Route::get('/{id}/edit', [PengadaanController::class, 'edit'])->name('edit');
//     Route::put('/{id}', [PengadaanController::class, 'update'])->name('update');
//     Route::delete('/{id}', [PengadaanController::class, 'destroy'])->name('destroy');
//     Route::patch('/{id}/status', [PengadaanController::class, 'updateStatus'])->name('update-status');
// });

// ==========================================
// ROUTE STAFF
// ==========================================
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {

    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');

});
