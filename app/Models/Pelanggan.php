<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';

protected $fillable = [
    'nama_pelanggan',
    'email',
    'telepon',
    'alamat1',
    'alamat2',
    'alamat3',
    'password',
    'tgl_lahir',
    'kartu_id',
    'foto',
];
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'id_pelanggan');
    }

    /**
     * Get full address
     */
    public function getFullAlamatAttribute()
    {
        $alamat = $this->alamat1;
        if ($this->alamat2) $alamat .= ', ' . $this->alamat2;
        if ($this->alamat3) $alamat .= ', ' . $this->alamat3;
        return $alamat;
    }
}
