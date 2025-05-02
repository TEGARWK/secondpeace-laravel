<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Alamat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Ubah ke true saat production
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function index()
    {
        $keranjang = Keranjang::where('id_user', Auth::id())->with('produk')->get();
        $total = $keranjang->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });

        return view('checkout', compact('keranjang', 'total'));
    }

    public function getSnapToken(Request $request)
    {
        $keranjang = Keranjang::where('id_user', Auth::id())->with('produk')->get();
        $total = $keranjang->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });

        $order_id = 'ORDER-' . Str::uuid();

        // Simpan pesanan sementara
        $pesanan = Pesanan::create([
            'id_user' => Auth::id(),
            'id_alamat' => Alamat::where('id_user', Auth::id())->where('utama', true)->first()->id_alamat,
            'status_pesanan' => 'Menunggu Pembayaran',
            'id_pembayaran' => null,
            'nomor_resi' => null,
            'ekspedisi' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($keranjang as $item) {
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_produk' => $item->produk->id_produk,
                'jumlah' => $item->jumlah,
                'total_harga' => $item->produk->harga * $item->jumlah,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->nama,
                'email' => Auth::user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Simpan snap_token ke pesanan
        $pesanan->update([
            'id_pembayaran' => $order_id,
        ]);

        return response()->json(['snap_token' => $snapToken]);
    }

    public function success()
    {
        return view('checkout_success');
    }
}
