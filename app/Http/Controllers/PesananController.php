<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with([
            'detailPesanan.produk',
            'alamat',
            'user'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('manajemenpesanan', compact('pesanan'));
    }
}
