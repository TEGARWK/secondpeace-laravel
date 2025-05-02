<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPesanan extends Model
{
    use HasFactory;

    // ✅ Fix nama tabel manual
    protected $table = 'detail_pesanan';

    // ✅ Primary key custom
    protected $primaryKey = 'id_detail_pesanan';

    // ✅ Kolom yang bisa diisi
    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'jumlah',
        'total_harga',
    ];

    // ✅ Relasi ke Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    // ✅ Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
