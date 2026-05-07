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

    // ✅ MASS ASSIGNMENT
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

    // ✅ HIDDEN
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ✅ CASTS - password harus 'hashed'
    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
        'tgl_lahir' => 'date',
    ];

    /**
     * Relasi ke Pemesanan
     */
    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'id_pelanggan');
    }
}
