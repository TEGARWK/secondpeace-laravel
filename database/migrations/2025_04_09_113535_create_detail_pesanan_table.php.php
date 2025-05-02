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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('id_detail_pesanan');  // ID unik untuk setiap detail pesanan
            $table->unsignedBigInteger('id_pesanan');  // Foreign key untuk pesanan
            $table->unsignedBigInteger('id_produk');  // Foreign key untuk produk
            $table->integer('jumlah');  // Jumlah produk yang dipesan
            $table->decimal('total_harga', 10, 2);  // Total harga produk, menggunakan DECIMAL untuk presisi harga
            $table->timestamps();  // created_at, updated_at

            // Foreign key untuk id_pesanan dan id_produk
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');  // Hapus tabel jika rollback
    }
};
