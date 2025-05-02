<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeranjangTable extends Migration
{
    public function up()
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_keranjang');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // cukup ini
            $table->unsignedBigInteger('id_produk');
            $table->integer('jumlah');
            $table->timestamps();
        
            // Relasi ke tabel produk
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('keranjang');
    }
}
