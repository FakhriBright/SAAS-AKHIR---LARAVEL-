<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Authenticatable
{
    use Notifiable;

    protected $table = 'pelanggans';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'nama_pelanggan',
        'email',
        'password',
        'telepon',
        'alamat1',
        'alamat2',
        'alamat3',
        'kartu_id',
        'foto',
        'tgl_lahir',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'tgl_lahir' => 'date',
    ];

    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'id_pelanggan');
    }
}
