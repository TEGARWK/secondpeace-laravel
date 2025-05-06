<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Http\Controllers\Controller;

class PesananController extends Controller
{
    public function index(Request $request) // <--- Tambahkan Request
    {
        $query = Pesanan::with([
            'detailPesanan.produk',
            'alamat',
            'user'
        ]);

        // Tambahkan filter jika status dikirim via GET
        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->status);
        }

        $pesanan = $query->orderBy('created_at', 'desc')->get();

        return view('admin.pesanan.manajemen-pesanan', compact('pesanan'));
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->status_pesanan = $request->status_pesanan;
        $pesanan->nomor_resi = $request->nomor_resi;
        $pesanan->save();

        return redirect()->route('manajemen.pesanan')->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function detail($id)
    {
        $pesanan = Pesanan::with(['user', 'pembayaran', 'alamat', 'detailPesanan.produk'])->findOrFail($id);
        return view('admin.pesanan.rincian-pesanan', compact('pesanan'));
    }
}
