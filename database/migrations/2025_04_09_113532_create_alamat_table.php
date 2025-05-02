<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlamatTable extends Migration
{
    public function up()
    {
        Schema::create('alamat', function (Blueprint $table) {
            $table->id('id_alamat');
            $table->unsignedBigInteger('id_user');
            $table->string('nama');
            $table->string('no_whatsapp');
            $table->text('alamat');
            $table->boolean('utama')->default(false);
            $table->timestamps();

            // Ubah foreign key untuk merujuk ke kolom 'id' di tabel 'users'
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('alamat');
    }
}
