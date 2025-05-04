@extends('layouts.master')

@section('title', 'Laporan Penjualan')

@section('content')
<link rel="stylesheet" href="{{ asset('css/laporan-penjualan.css') }}">
<script src="{{ asset('js/laporan-penjualan.js') }}"></script>

<div class="container-laporan">
    <h2 class="text-center mb-4">📈 Laporan Penjualan</h2>

    <form method="GET" class="filter-form">
        <div class="form-group">
            <label for="start_date">Tanggal Mulai:</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}">
        </div>
        <div class="form-group">
            <label for="end_date">Tanggal Selesai:</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}">
        </div>
        <div class="form-group btn-group">
            <button type="submit" class="btn btn-success">Filter</button>
            <a href="{{ route('laporan-penjualan') }}" class="btn btn-secondary">Reset</a>
        </div>
        <div class="form-group">
            <a href="{{ route('laporan-penjualan.download', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                class="btn btn-dark">📄 Download PDF</a>
        </div>
    </form>

    <table class="laporan-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSemua = 0; @endphp
            @forelse($laporan as $index => $item)
                @php $totalSemua += $item->total_harga; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</td>
                    <td>{{ $item->nama_pelanggan }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge status-{{ Str::slug($item->status_pesanan) }}">
                            {{ $item->status_pesanan }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada data penjualan.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-end">Total Pendapatan</th>
                <th colspan="2" class="text-start text-success">
                    <strong>Rp {{ number_format($totalSemua, 0, ',', '.') }}</strong>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
