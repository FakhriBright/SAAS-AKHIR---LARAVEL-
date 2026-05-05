<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengirimans';

    protected $fillable = [
        'pemesanan_id',
        'tgl_kirim',
        'status_kirim',
        'id_user',      // ✅ Foreign key ke tabel users
        'bukti_foto',
    ];

    protected $casts = [
        'tgl_kirim' => 'datetime',
    ];

    /**
     * Relasi ke Pemesanan
     */
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    /**
     * ✅ RELASI BARU: Ke User/Kurir yang menangani pengiriman
     */
    public function user()
    {
        // Foreign key di tabel pengirimans adalah 'id_user'
        return $this->belongsTo(User::class, 'id_user');
    }
}
