<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPemesanan extends Model
{
    protected $table = 'detail_pemesanans';

    public $timestamps = true;

    // ✅ MASS ASSIGNMENT - SEMUA FIELD HARUS ADA!
    protected $fillable = [
        'pemesanan_id',
        'paket_id',
        'jumlah',        // 🔥 WAJIB ADA DI SINI!
        'subtotal',
    ];

    // ✅ CASTS
    protected $casts = [
        'jumlah' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relasi ke Pemesanan
     */
    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    /**
     * Relasi ke Paket
     */
    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}
