<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPembayaran extends Model
{
    protected $table = 'jenis_pembayarans';
    public $timestamps = true;

    protected $fillable = [
        'metode_pembayaran',
    ];

    public function detailJenisPembayarans(): HasMany
    {
        return $this->hasMany(DetailJenisPembayaran::class, 'id_jenis_pembayaran');
    }

    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'id_jenis_bayar');
    }
}