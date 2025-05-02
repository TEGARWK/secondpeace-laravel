<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id_alamat
 * @property int $id_user
 * @property string $nama
 * @property string $no_whatsapp
 * @property string $alamat
 * @property int $utama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereIdAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereNoWhatsapp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereUtama($value)
 * @mixin \Eloquent
 */
class Alamat extends Model
{
    protected $table = 'alamat';
    protected $primaryKey = 'id_alamat';

    protected $fillable = [
        'id_user',
        'nama',
        'no_whatsapp',
        'alamat',
        'utama',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
