<?php
// File: routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PenguranganStokController;
use App\Http\Controllers\ProfileStaffController;
use App\Http\Controllers\LaporanStaffController;
use App\Http\Controllers\DashboardController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

   // WhatsApp routes HARUS DI ATAS
    Route::post('suppliers/{id}/whatsapp/send', [SupplierController::class, 'sendWhatsApp']);
    Route::post('suppliers/{id}/whatsapp/custom', [SupplierController::class, 'sendCustomWhatsApp']);

    // Resource routes di bawah
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

Route::middleware(['auth'])->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Logout Route
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');
});

// Staff Management Routes (Hanya untuk Admin)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('daftar_staff', StaffController::class);

    // Additional staff routes
    Route::patch('staff/{staff}/toggle-status', [StaffController::class, 'toggleStatus'])
        ->name('staff.toggle-status');

    Route::patch('staff/{staff}/update-password', [StaffController::class, 'updatePassword'])
        ->name('staff.update-password');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Staff Management Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('staff', StaffController::class);
    });
});
// ==========================================
// ROUTE STAFF
// ==========================================
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {

    // Ubah dari closure menjadi controller
    Route::get('/penguranganstok', [PenguranganStokController::class, 'index'])
        ->name('pengurangan_stok.index');

    // Route untuk menyimpan pengurangan stok
    Route::post('/pengurangan/store', [PenguranganStokController::class, 'store'])
        ->name('pengurangan.store');

     // Laporan
    Route::get('/laporan', [LaporanStaffController::class, 'index'])
        ->name('laporan.index');
    Route::get('/laporan/{id}', [LaporanStaffController::class, 'show'])
        ->name('laporan.show');
    Route::get('/laporan/export/pdf', [LaporanStaffController::class, 'exportPdf'])
        ->name('laporan.export.pdf');

    // Profile Staff
    Route::get('/profile', [ProfileStaffController::class, 'show'])
        ->name('profile.show');
    Route::get('/profile/edit', [ProfileStaffController::class, 'edit'])
        ->name('profile.edit');
    Route::put('/profile', [ProfileStaffController::class, 'update'])
        ->name('profile.update');
    Route::put('/profile/password', [ProfileStaffController::class, 'updatePassword'])
        ->name('profile.password');

    // Logout Staff
    Route::post('/logout', [ProfileStaffController::class, 'logout'])->name('logout');

    // ... route staff lainnya
});
