<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPemesanan extends Model
{
    // ✅ Nama tabel (opsional)
    protected $table = 'detail_pemesanans';

    // ✅ Timestamps
    public $timestamps = true;

    // ✅ MASS ASSIGNMENT - SEMUA FIELD HARUS ADA DI SINI! 🔥
    protected $fillable = [
        'pemesanan_id',    // ✅ Foreign key ke pemesanans
        'paket_id',        // ✅ Foreign key ke pakets (INI YANG ERROR!)
        'jumlah',          // ✅ Quantity
        'subtotal',        // ✅ Harga subtotal
    ];

    // ✅ Casts untuk tipe data
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
