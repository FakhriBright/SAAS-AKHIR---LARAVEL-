<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengiriman extends Model
{
    // ✅ NAMA TABEL YANG BENAR (plural, ejaan benar)
    protected $table = 'pengirimans';  // ✅ BUKAN 'pengirimen'!

    public $timestamps = true;

    // ✅ MASS ASSIGNMENT
    protected $fillable = [
        'pemesanan_id',
        'id_user',
        'tgl_kirim',
        'tgl_tiba',
        'status_kirim',
        'bukti_foto',
    ];

    // ✅ CASTS
    protected $casts = [
        'tgl_kirim' => 'datetime',
        'tgl_tiba' => 'datetime',
    ];

    /**
     * Relasi ke Pemesanan
     */
    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    /**
     * Relasi ke User (Kurir)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
