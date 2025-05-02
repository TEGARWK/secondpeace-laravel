<?php

namespace App\Http\Controllers\Api;

use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Alamat;
use App\Models\DetailPesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;
use Illuminate\Support\Facades\Http; // tambahkan di atas

class MidtransController extends Controller
{
    public function getSnapToken(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $keranjang = Keranjang::where('id_user', Auth::id())->with('produk')->get();

        if ($keranjang->isEmpty()) {
            return response()->json(['message' => 'Keranjang kosong.'], 400);
        }

        $total = $keranjang->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });

        $order_id = 'ORDER-' . strtoupper(Str::random(10));

        $alamat = Alamat::where('id_user', Auth::id())->where('utama', true)->first();
        if (!$alamat) {
            return response()->json(['message' => 'Alamat utama tidak ditemukan'], 400);
        }

        $pesanan = Pesanan::create([
            'id_user'        => Auth::id(),
            'id_alamat'      => $alamat->id_alamat,
            'status_pesanan' => 'Menunggu Pembayaran',
            'id_pembayaran'  => $order_id,
        ]);

        foreach ($keranjang as $item) {
            DetailPesanan::create([
                'id_pesanan'  => $pesanan->id_pesanan,
                'id_produk'   => $item->produk->id_produk,
                'jumlah'      => $item->jumlah,
                'total_harga' => $item->produk->harga * $item->jumlah,
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $order_id,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->nama,
                'email'      => Auth::user()->email,
            ],
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

    

public function verifyPaymentStatus($order_id)
{
    try {
        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.is_production', false);

        $baseUrl = $isProduction
            ? 'https://api.midtrans.com'
            : 'https://api.sandbox.midtrans.com';

        $response = Http::withBasicAuth($serverKey, '')
            ->get("$baseUrl/v2/$order_id/status");

        if ($response->failed()) {
            return response()->json([
                'message' => 'Gagal ambil status dari Midtrans',
                'midtrans_response' => $response->json(),
            ], $response->status());
        }

        $data = $response->json();
        $status = $data['transaction_status'] ?? 'unknown';

        // update ke database
        $pesanan = Pesanan::where('id_pembayaran', $order_id)->first();
        if ($pesanan) {
            if ($status === 'settlement') {
                $pesanan->status_pesanan = 'Pembayaran Diterima';
            } elseif (in_array($status, ['cancel', 'expire'])) {
                $pesanan->status_pesanan = 'Pesanan Dibatalkan';
            } else {
                $pesanan->status_pesanan = 'Menunggu Pembayaran';
            }
            $pesanan->save();
        }

        return response()->json([
            'status' => $status,
            'order_id' => $order_id,
            'pesanan_status' => $pesanan->status_pesanan ?? null,
            'raw' => $data
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Gagal verifikasi status',
            'error' => $e->getMessage(),
        ], 500);
    }
}


}
