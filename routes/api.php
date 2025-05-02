<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Controller Import
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AlamatController;
use App\Http\Controllers\Api\KeranjangController;
use App\Http\Controllers\Api\MidtransController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\PesananController;

// ========== Rute Publik (Tanpa Token) ==========
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);

// ========== Rute Proteksi Token (Login Required) ==========
Route::middleware('auth:sanctum')->group(function () {

    // User Info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // ================= Profil =================
    Route::post('/user/update', [UserController::class, 'update']);

    // ================= Alamat =================
    Route::get('/user/addresses', [AlamatController::class, 'index']);
    Route::post('/user/address', [AlamatController::class, 'store']);
    Route::put('/user/address/{id}', [AlamatController::class, 'update']);
    Route::delete('/user/address/{id}', [AlamatController::class, 'destroy']);
    Route::patch('/user/address/set-primary/{id}', [AlamatController::class, 'setPrimary']);

    // ================= Keranjang =================
    Route::get('/keranjang/{id_user}', [KeranjangController::class, 'index']);
    Route::post('/keranjang', [KeranjangController::class, 'store']);
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update']);
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy']);

    // ================= Checkout & Pembayaran =================

    // 🔁 Buat pesanan + Snap Token
    Route::post('/checkout', [CheckoutController::class, 'checkout']); // ✅ baru

    // Verifikasi pembayaran manual
    Route::get('/verify-payment/{order_id}', [MidtransController::class, 'verifyPaymentStatus']); // opsional


    Route::get('/pesanan', [PesananController::class, 'index']);
    Route::get('/pesanan/{id}', [PesananController::class, 'show']);

});
