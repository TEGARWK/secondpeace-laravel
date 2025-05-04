@extends('layouts.master')

@section('title', 'Dashboard Admin')

@section('content')
<header class="mb-4">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</header>

<div class="container">
    <div class="content-wrapper">
        <h1>Welcome, Admin!</h1>

        <div class="outer-card">
            <div class="cards-container">
                {{-- Card 1: Total Semua Order --}}
                <div class="card">
                    <div class="card-title">Total Order</div>
                    <div class="stat-box">
                        <div class="stat-content">
                            <span class="stat-number">{{ $totalOrder }}</span>
                            <span class="stat-text">Total Order</span>
                        </div>
                        <i class="fas fa-shopping-cart icon"></i>
                    </div>
                </div>

                {{-- Card 2: Pesanan Dikirim --}}
                <div class="card">
                    <div class="card-title">Pesanan Dikirim</div>
                    <div class="stat-box">
                        <div class="stat-content">
                            <span class="stat-number">{{ $totalDikirim }}</span>
                            <span class="stat-text">Pesanan Dikirim</span>
                        </div>
                        <i class="fas fa-box icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
