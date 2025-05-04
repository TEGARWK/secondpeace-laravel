<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Http\Controllers\Controller;

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

        return view('admin.pesanan.manajemen-pesanan', compact('pesanan'));
    }
}
