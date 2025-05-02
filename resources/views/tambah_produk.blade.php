@extends('layouts.master')

@section('title', 'Tambah Produk')

@section('content')
<header class="mb-4">
    <link rel="stylesheet" href="{{ asset('css/tambah_produk.css') }}">
</header>

<div class="admin-container">
    <div class="container py-4">
        <h1 class="mb-4">Tambah Produk</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Tampilkan error validasi -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" class="form-control" placeholder="Masukkan nama produk" required>
            </div>

            <div class="form-group mb-3">
                <label for="kategori_produk">Kategori Produk</label>
                <input type="text" id="kategori_produk" name="kategori_produk" class="form-control" placeholder="Masukkan kategori produk" required>
            </div>

            <div class="form-group mb-3">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="harga">Harga Produk</label>
                <input type="number" id="harga" name="harga" class="form-control" step="0.01" required>
            </div>

            <div class="form-group mb-3">
                <label for="stok">Stok Produk</label>
                <input type="number" id="stok" name="stok" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="gambar">Gambar Produk</label>
                <input type="file" id="gambar" name="gambar" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="kualitas">Kualitas Produk</label>
                <select id="kualitas" name="kualitas" class="form-control" required>
                    <option value="tinggi">Tinggi</option>
                    <option value="sedang">Sedang</option>
                    <option value="rendah">Rendah</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="size">Size</label>
                <select id="size" name="size" class="form-control" required>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Tambah Produk</button>
        </form>
    </div>
</div>
@endsection
