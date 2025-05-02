<?php

namespace App\Http\Controllers\Api;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KeranjangController extends Controller
{
    // ✅ Ambil keranjang milik user
    public function index($id_user)
    {
        $items = Keranjang::with('produk')->where('id_user', $id_user)->get();

        foreach ($items as $item) {
            if ($item->produk && $item->produk->gambar) {
                $item->produk->gambar = url('uploads/' . $item->produk->gambar);
            }
        }

        return response()->json([
            'success' => true,
            'keranjang' => $items,
        ]);
    }

    // ✅ Tambah produk ke keranjang dengan validasi stok
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer',
            'id_produk' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::find($request->id_produk);
        if (!$produk || $produk->stok < $request->jumlah) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak cukup atau tidak ditemukan',
            ], 400);
        }

        // Cek jika item sudah ada → update jumlah
        $existing = Keranjang::where('id_user', $request->id_user)
            ->where('id_produk', $request->id_produk)
            ->first();

        if ($existing) {
            $existing->jumlah += $request->jumlah;
            $existing->save();

            return response()->json([
                'success' => true,
                'message' => 'Jumlah produk diperbarui di keranjang',
                'data' => $existing,
            ]);
        }

        // Tambahkan item baru
        $item = Keranjang::create([
            'id_user' => $request->id_user,
            'id_produk' => $request->id_produk,
            'jumlah' => $request->jumlah,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke keranjang',
            'data' => $item,
        ]);
    }

    // ✅ Update jumlah
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $item = Keranjang::findOrFail($id);
        $item->jumlah = $request->jumlah;
        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Jumlah diperbarui',
            'data' => $item,
        ]);
    }

    // ✅ Hapus item
    public function destroy($id)
    {
        $item = Keranjang::findOrFail($id);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item dihapus dari keranjang',
        ]);
    }
}
