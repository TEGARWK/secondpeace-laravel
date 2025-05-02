<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $primaryKey = 'id_pesanan';
    protected $table = 'pesanan';

    protected $fillable = [
        'id_user',
        'id_produk',
        'id_alamat',
        'id_pembayaran',
        'status_pesanan',
        'nomor_resi',
        'ekspedisi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }

    public function pembayaran()
{
    return $this->hasOne(Pembayaran::class, 'id_pesanan')->withDefault();
}

}
