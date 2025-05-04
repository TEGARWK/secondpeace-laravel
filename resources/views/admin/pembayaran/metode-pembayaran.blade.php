@extends('layouts.master')

@section('title', 'Metode Pembayaran')

@section('content')
<header class="mb-4">
    <link rel="stylesheet" href="{{ asset('css/metode-pembayaran.css') }}">
</header>

<div class="metode-container">
    <div class="metode-card">
        <h2 class="metode-title">Metode Pembayaran</h2>
        <h4 class="metode-subtitle">Daftar Metode Pembayaran</h4>

        <div class="metode-button-container">
            <button class="metode-btn tambah-btn">Tambah Metode Pembayaran</button>
        </div>

        <table class="metode-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Metode</th>
                    <th>Kategori</th>
                    <th>No Rekening</th>
                    <th>Status Rekening</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>BRI</td>
                    <td>Bank</td>
                    <td>1122334455</td>
                    <td>Aktif</td>
                    <td>
                        <button class="metode-btn edit-btn">Edit</button>
                        <button class="metode-btn delete-btn">Hapus</button>
                    </td>
                </tr>
                <tr class="row-alternate">
                    <td>2</td>
                    <td>BCA</td>
                    <td>Bank</td>
                    <td>9922883374</td>
                    <td>Aktif</td>
                    <td>
                        <button class="metode-btn edit-btn">Edit</button>
                        <button class="metode-btn delete-btn">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Link Aja</td>
                    <td>E-Wallet</td>
                    <td>0011223344</td>
                    <td>Aktif</td>
                    <td>
                        <button class="metode-btn edit-btn">Edit</button>
                        <button class="metode-btn delete-btn">Hapus</button>
                    </td>
                </tr>
                <tr class="row-alternate">
                    <td>4</td>
                    <td>Dana</td>
                    <td>E-Wallet</td>
                    <td>9988776655</td>
                    <td>Aktif</td>
                    <td>
                        <button class="metode-btn edit-btn">Edit</button>
                        <button class="metode-btn delete-btn">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Gopay</td>
                    <td>E-Wallet</td>
                    <td>5544667733</td>
                    <td>Aktif</td>
                    <td>
                        <button class="metode-btn edit-btn">Edit</button>
                        <button class="metode-btn delete-btn">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
