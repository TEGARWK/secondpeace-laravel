<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->bigIncrements('id_pesanan');
            $table->foreignId('id_user')->constrained('users', 'id')->onDelete('cascade');  // Relasi dengan pengguna
            $table->foreignId('id_alamat')->constrained('alamat', 'id_alamat')->onDelete('cascade');  // Relasi dengan alamat
            $table->string('id_pembayaran')->nullable();  // ID untuk pembayaran Midtrans
            $table->enum('status_pesanan', ['Menunggu Pembayaran', 'Pembayaran Diterima', 'Sedang Diproses', 'Pesanan Dibatalkan', 'Pesanan Dikirim', 'Pesanan Diterima']);
            $table->string('nomor_resi')->nullable();  // Untuk nomor resi pengiriman
            $table->string('ekspedisi')->nullable();  // Untuk nama ekspedisi
            $table->timestamps();  // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
