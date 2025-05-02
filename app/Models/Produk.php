<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id_produk
 * @property int $id_user
 * @property string $nama_produk
 * @property string $kategori_produk
 * @property string $deskripsi
 * @property int $harga
 * @property string|null $gambar
 * @property string $kualitas
 * @property string $size
 * @property int $stok
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetailPesanan> $detailPesanan
 * @property-read int|null $detail_pesanan_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereIdProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereKategoriProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereKualitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereNamaProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_user',
        'nama_produk',
        'kategori_produk',
        'deskripsi',
        'harga',
        'kualitas',
        'size',
        'stok',
        'gambar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_produk');
    }

}
