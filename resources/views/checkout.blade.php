@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Checkout</h2>
    <ul>
        @foreach ($keranjang as $item)
            <li>{{ $item->produk->nama_produk }} - {{ $item->jumlah }} x Rp{{ number_format($item->produk->harga) }}</li>
        @endforeach
    </ul>
    <p>Total: Rp{{ number_format($total) }}</p>
    <button id="pay-button">Bayar Sekarang</button>
</div>

<!-- Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        fetch("{{ route('checkout.token') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                // Kirim data yang diperlukan, misalnya id_user
            })
        })
        .then(response => response.json())
        .then(data => {
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    alert("Pembayaran berhasil!");
                    window.location.href = "{{ route('checkout.success') }}";
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran.");
                },
                onError: function(result) {
                    alert("Pembayaran gagal.");
                },
                onClose: function() {
                    alert("Anda menutup popup tanpa menyelesaikan pembayaran.");
                }
            });
        });
    });
</script>
@endsection
