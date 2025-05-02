@extends('layouts.master')

@section('title', 'Ekspedisi Pengiriman')

@section('content')
<header class="mb-4">
    <link rel="stylesheet" href="{{ asset('css/ekspedisi.css') }}">
</header>

<div class="ekspedisi-container">
    <div class="ekspedisi-card">
        <h2 class="ekspedisi-title">Ekspedisi Pengiriman</h2>
        <h4 class="ekspedisi-subtitle">Daftar Ekspedisi Pengiriman</h4>

        <div class="ekspedisi-button-container">
            <button class="ekspedisi-btn tambah-btn">Tambah Ekspedisi</button>
        </div>

        <table class="ekspedisi-table">
            <thead>
                <tr>
                    <th>ID Ekspedisi</th>
                    <th>Nama Ekspedisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>4</td>
                    <td>JNT</td>
                    <td>
                        <button class="ekspedisi-btn edit-btn">Edit</button>
                        <button class="ekspedisi-btn delete-btn">Hapus</button>
                    </td>
                </tr>
                <tr class="row-alternate">
                    <td>5</td>
                    <td>JNE</td>
                    <td>
                        <button class="ekspedisi-btn edit-btn">Edit</button>
                        <button class="ekspedisi-btn delete-btn">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Si Cepat</td>
                    <td>
                        <button class="ekspedisi-btn edit-btn">Edit</button>
                        <button class="ekspedisi-btn delete-btn">Hapus</button>
                    </td>
                </tr>
                <tr class="row-alternate">
                    <td>7</td>
                    <td>Ninja Express</td>
                    <td>
                        <button class="ekspedisi-btn edit-btn">Edit</button>
                        <button class="ekspedisi-btn delete-btn">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Lala Move</td>
                    <td>
                        <button class="ekspedisi-btn edit-btn">Edit</button>
                        <button class="ekspedisi-btn delete-btn">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
