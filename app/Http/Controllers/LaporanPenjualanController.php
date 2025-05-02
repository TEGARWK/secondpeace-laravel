<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('pesanan')
            ->join('users', 'pesanan.id_user', '=', 'users.id')
            ->join('detail_pesanan', 'pesanan.id_pesanan', '=', 'detail_pesanan.id_pesanan')
            ->join('produk', 'detail_pesanan.id_produk', '=', 'produk.id_produk')
            ->select(
                'pesanan.created_at',
                'users.nama as nama_pelanggan',
                'produk.nama_produk',
                'detail_pesanan.jumlah',
                'detail_pesanan.total_harga',
                'pesanan.status_pesanan'
            );

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('pesanan.created_at', [$request->start_date, $request->end_date]);
        }

        $laporan = $query->orderBy('pesanan.created_at', 'desc')->get();

        return view('laporan-penjualan', compact('laporan'));
    }

    public function downloadPDF(Request $request)
    {
        // Ambil data laporan sesuai query yang digunakan pada index
        $query = DB::table('pesanan')
            ->join('users', 'pesanan.id_user', '=', 'users.id')
            ->join('detail_pesanan', 'pesanan.id_pesanan', '=', 'detail_pesanan.id_pesanan')
            ->join('produk', 'detail_pesanan.id_produk', '=', 'produk.id_produk')
            ->select(
                'pesanan.created_at',
                'users.nama as nama_pelanggan',
                'produk.nama_produk',
                'detail_pesanan.jumlah',
                'detail_pesanan.total_harga',
                'pesanan.status_pesanan'
            );

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('pesanan.created_at', [$request->start_date, $request->end_date]);
        }

        $laporan = $query->orderBy('pesanan.created_at', 'desc')->get();

        // Hitung total pendapatan
        $totalSemua = $laporan->sum('total_harga');

        // Ambil tanggal untuk penamaan file
        $startDate = \Carbon\Carbon::parse($request->start_date)->format('d-m-Y');
        $endDate = \Carbon\Carbon::parse($request->end_date)->format('d-m-Y');

        // Sesuaikan nama file dengan rentang tanggal
        $fileName = "Laporan Penjualan-{$startDate}-{$endDate}.pdf";

        // Generate PDF dengan view yang sudah dibuat
        $pdf = FacadePdf::loadView('penjualan-pdf', compact('laporan', 'totalSemua'));

        // Download PDF dengan nama file dinamis
        return $pdf->download($fileName);
    }

}
