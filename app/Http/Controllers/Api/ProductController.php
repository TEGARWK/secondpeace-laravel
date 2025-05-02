<?php

namespace App\Http\Controllers\Api;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // ✅ HANYA Menampilkan semua produk untuk pelanggan
    public function index()
{
    $products = Produk::all()->map(function ($product) {
        $product->gambar = url('uploads/' . $product->gambar);
        return $product;
    });

    return response()->json([
        'success' => true,
        'products' => $products,
    ]);
}

}
