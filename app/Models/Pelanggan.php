<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
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

    protected $hidden = ['password'];

    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'id_pelanggan');
    }
}