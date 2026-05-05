<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanans';

    protected $fillable = [
        'id_pelanggan',
        'id_jenis_bayar',
        'no_resi',
        'tgl_pesan',
        'status_pesan',
        'total_bayar',
    ];

    protected $casts = [
        'tgl_pesan' => 'datetime',
        'total_bayar' => 'decimal:2',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'id_jenis_bayar');
    }

    public function detailPemesanans()
    {
        // ✅ Foreign key 'pemesanan_id' sesuai database
        return $this->hasMany(DetailPemesanan::class, 'pemesanan_id');
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'pemesanan_id');
    }
}
