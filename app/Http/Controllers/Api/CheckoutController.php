<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Alamat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
{
    $request->validate([
        'produk' => 'required|array',
        'produk.*.id_produk' => 'required|integer|exists:produk,id_produk',
        'produk.*.jumlah' => 'required|integer|min:1',
        'payment_method' => 'required|string',
        'ekspedisi' => 'required|string|in:J&T,JNE,SiCepat', // ✅ tambahkan validasi ekspedisi
    ]);

    $userId = Auth::id();

    $alamat = Alamat::where('id_user', $userId)->where('utama', true)->first();
    if (!$alamat) {
        return response()->json(['message' => 'Alamat utama tidak ditemukan'], 400);
    }

    $total = 0;
    foreach ($request->produk as $item) {
        $produk = Produk::find($item['id_produk']);
        if ($produk->stok < $item['jumlah']) {
            return response()->json([
                'message' => "Stok tidak cukup untuk {$produk->nama_produk}"
            ], 400);
        }
        $total += $produk->harga * $item['jumlah'];
    }

    $order_id = 'ORDER-' . strtoupper(Str::random(10));

    $pesanan = Pesanan::create([
        'id_user' => $userId,
        'id_alamat' => $alamat->id_alamat,
        'status_pesanan' => 'Menunggu Pembayaran',
        'id_pembayaran' => $order_id,
        'ekspedisi' => $request->ekspedisi ?? 'J&T', // ✅ simpan ekspedisi ke DB
    ]);

    foreach ($request->produk as $item) {
        $produk = Produk::find($item['id_produk']);

        DetailPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_produk' => $produk->id_produk,
            'jumlah' => $item['jumlah'],
            'total_harga' => $produk->harga * $item['jumlah'],
        ]);

        $produk->stok -= $item['jumlah'];
        $produk->save();
    }

    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production', false);
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $params = [
        'transaction_details' => [
            'order_id' => $order_id,
            'gross_amount' => $total,
        ],
        'customer_details' => [
            'first_name' => Auth::user()->nama,
            'email' => Auth::user()->email,
        ],
        'enabled_payments' => [$request->payment_method],
    ];

    try {
        $snapToken = Snap::getSnapToken($params);
        return response()->json([
            'snap_token' => $snapToken,
            'order_id' => $order_id,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Gagal mendapatkan Snap Token',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}
