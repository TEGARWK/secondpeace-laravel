<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LaporanPenjualanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ProdukController;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\PelangganAuth;
use App\Http\Controllers\PesananController;

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

    // dahboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // manajemen produk
    Route::get('/manajemen-produk', [ProdukController::class, 'index'])->name('manajemen.produk');
    Route::get('/produk/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::get('/produk/tambah-produk', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store');

    // manajemen pesanan
    Route::get('/manajemen-pesanan', [PesananController::class, 'index'])->name('manajemen.pesanan');
    // laporan penjualan
    Route::get('/laporan-penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan-penjualan');
    Route::get('/laporan-penjualan/download', [LaporanPenjualanController::class, 'downloadPDF'])->name('laporan-penjualan.download');

    // midtrans
    Route::post('/midtrans/callback', [MidtransController::class, 'callbackHandler']);
    Route::get('/snap-token/{id}', [MidtransController::class, 'getSnapToken']);

    // Route::get('/metode-pembayaran', function () {
    //     return view('metodepembayaran');
    // })->name('metode.pembayaran');

    // Route::get('/ekspedisi', function () {
    //     return view('ekspedisi');
    // })->name('ekspedisi');

});

// =======================
// DASHBOARD PELANGGAN (Hanya setelah login pelanggan)
// =======================
Route::middleware(['auth', PelangganAuth::class])->group(function () {
    Route::get('/dashboard/pelanggan', function () {
        return view('dashboard-pelanggan');
    })->name('dashboard.pelanggan');

    // Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    // Route::post('/checkout/token', [CheckoutController::class, 'getSnapToken'])->name('checkout.token');
    // Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});