<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// Admin Controller
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LaporanPenjualanController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Middleware\AdminAuth;

// Pelanggan Controller
use App\Http\Middleware\PelangganAuth;

// Redirect ke login admin
Route::get('/', function () {
    return redirect('/login/admin');
});

// Alias bawaan Laravel agar tidak error Route [login] not defined
Route::get('/login', function () {
    return redirect()->route('login.admin');
})->name('login');

// =======================
// LOGIN ADMIN
// =======================
Route::get('/login/admin', [LoginController::class, 'showLoginFormAdmin'])->name('login.admin');
Route::post('/login/admin', [LoginController::class, 'loginAdmin'])->name('login.admin.process');

// =======================
// LOGIN PELANGGAN
// =======================
Route::get('/login/pelanggan', [LoginController::class, 'showLoginFormPelanggan'])->name('login.pelanggan');
Route::post('/login/pelanggan', [LoginController::class, 'loginPelanggan'])->name('login.pelanggan.process');

// =======================
// ADMIN AREA (Hanya setelah login admin)
// =======================
Route::middleware(['auth', AdminAuth::class])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');

    // manajemen produk
    Route::get('/admin/produk/manajemen-produk', [ProdukController::class, 'index'])->name('manajemen.produk');
    Route::get('/produk/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/admin/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::get('/admin/produk/tambah-produk', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/admin/produk/store', [ProdukController::class, 'store'])->name('produk.store');

    // manajemen pesanan
    Route::get('/admin/pesanan/manajemen-pesanan', [PesananController::class, 'index'])->name('manajemen.pesanan');

    // laporan penjualan
    Route::get('/admin/laporan-penjualan/laporan-penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan-penjualan');
    Route::get('/admin/laporan-penjualan/laporan-penjualan/download', [LaporanPenjualanController::class, 'downloadPDF'])->name('laporan-penjualan.download');

    // Route::get('/admin/pembayaran/metode-pembayaran', function () {
    //     return view('admin.pembayaran.metode-pembayaran');
    // })->name('metode.pembayaran');

    // Route::get('/admin/ekspedisi/ekspedisi', function () {
    //     return view('admin.ekspedisi.ekspedisi');
    // })->name('ekspedisi');

});

// =======================
// DASHBOARD PELANGGAN (Hanya setelah login pelanggan)
// =======================
Route::middleware(['auth', PelangganAuth::class])->group(function () {
    Route::get('/pelanggan/dashboard', function () {
        return view('pelanggan.dashboard-pelanggan');
    })->name('dashboard.pelanggan');
});