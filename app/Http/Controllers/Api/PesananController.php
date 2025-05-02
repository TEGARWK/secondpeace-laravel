<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;

class PesananController extends Controller
{
    // ✅ Ambil semua pesanan user
    public function index()
    {
        $userId = Auth::id();

        $pesanan = Pesanan::with([
            'detailPesanan.produk',
            'alamat',
        ])
        ->where('id_user', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'pesanan' => $pesanan,
        ]);
    }

    // ✅ Ambil detail 1 pesanan
    public function show($id)
    {
        $userId = Auth::id();

        $pesanan = Pesanan::with([
            'detailPesanan.produk',
            'alamat',
        ])
        ->where('id_user', $userId)
        ->where('id_pesanan', $id)
        ->first();

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'pesanan' => $pesanan,
        ]);
    }
}
