@extends('layouts.master')

@section('title', 'Manajemen Produk')

@section('content')
<header class="mb-4">
    <link rel="stylesheet" href="{{ asset('css/manajemenproduk.css') }}">
</header>

<div class="container">
    <h2 class="text-center">Manajemen Produk</h2>
    <h4 class="text-center">Daftar Manajemen Produk</h4>

    <div class="search-container d-flex justify-content-center mb-3">
        <form class="d-flex" method="GET" action="{{ route('manajemen.produk') }}">
            <input 
                type="text" 
                name="search" 
                class="form-control w-25" 
                placeholder="Cari berdasarkan ID Produk" 
                value="{{ request('search') }}"
            >
            <button type="submit" class="btn btn-primary ms-2">Cari</button>
        </form>        
    </div>

    {{-- Tombol Tambah Produk --}}
    <a href="{{ route('produk.create') }}" class="btn btn-success mb-3" style="text-decoration: none;">Tambah Produk</a>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>ID Produk</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Kualitas</th>
                    <th>Size</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $p)
                <tr>
                    <td class="text-center">{{ $p->id_produk }}</td>
                    <td class="text-center">
                        <img src="{{ asset('uploads/' . $p->gambar) }}" alt="{{ $p->nama_produk }}" class="product-image" width="100">
                    </td>
                    <td>{{ $p->nama_produk }}</td>
                    <td>{{ $p->deskripsi }}</td>
                    <td class="text-center">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                    <td class="text-center">{{ ucfirst($p->kualitas) }}</td>
                    <td class="text-center">{{ $p->size }}</td>
                    <td class="text-center">{{ $p->stok }}</td>
                    <td class="text-center">
                        <a href="{{ route('produk.edit', $p->id_produk) }}" class="btn btn-warning btn-sm">Edit</a>
                    
                        <form action="{{ route('produk.destroy', $p->id_produk) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>                                        
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
