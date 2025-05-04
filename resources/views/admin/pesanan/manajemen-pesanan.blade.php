@extends('layouts.master')

@section('title', 'Manajemen Pesanan')

@section('content')

<link rel="stylesheet" href="{{ asset('css/manajemen-pesanan.css') }}">

<div class="container">
    <h2>📦 Manajemen Pesanan</h2>

    <!-- Filter & Aksi -->
    <div class="filter-container">
    <select class="form-select">
        <option>Semua Status</option>
        <option>Menunggu Pembayaran</option>
        <option>Pembayaran Diterima</option>
        <option>Dikirim</option>
        <option>Selesai</option>
    </select>
    <button class="btn btn-primary">Filter</button>
    <button class="btn btn-secondary">Reset</button>
    <button class="btn btn-danger">Hapus Semua Data</button>
    </div>

    <!-- List Card Pesanan -->
    <div class="order-list">
    @foreach ($pesanan as $p)
        <div class="order-card">
        <div class="order-header">
            <div><strong>🧾 ID:</strong> #{{ $p->id_pesanan }}</div>
            <span class="badge status-{{ Str::slug($p->status_pesanan) }}">
            {{ $p->status_pesanan }}
            </span>
        </div>

        <div class="order-body">
            <p><strong>👤 Pelanggan:</strong> {{ $p->user->nama ?? '-' }}</p>
            <p><strong>📍 Alamat:</strong> {{ $p->alamat->alamat ?? '-' }}</p>
            <p>
            <strong>📱 WhatsApp:</strong> 
            <a href="https://wa.me/{{ $p->alamat->no_whatsapp }}" target="_blank">
                    {{ $p->alamat->no_whatsapp }}
            </a>
            </p>

            <p><strong>🧺 Produk:</strong><br>
            @foreach ($p->detailPesanan as $dp)
                {{ $dp->produk->nama_produk }} x{{ $dp->jumlah }}<br>
            @endforeach
            </p>

            <div class="form-row">
            <div class="form-group">
                <label for="resi_{{ $p->id_pesanan }}">📦 No. Resi</label>
                <input type="text" name="resi_{{ $p->id_pesanan }}" value="{{ $p->nomor_resi ?? '' }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="status_{{ $p->id_pesanan }}">📌 Status</label>
                <select name="status_{{ $p->id_pesanan }}" class="form-select">
                @foreach(['Menunggu Pembayaran', 'Pembayaran Diterima', 'Dikirim', 'Selesai'] as $status)
                    <option value="{{ $status }}" {{ $p->status_pesanan === $status ? 'selected' : '' }}>
                    {{ $status }}
                    </option>
                @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>&nbsp;</label>
                <button class="btn btn-success btn-update" data-id="{{ $p->id_pesanan }}">
                💾 Simpan
                </button>
            </div>
            </div>
        </div>
        </div>
    @endforeach
    </div>
</div>

@endsection
