<?php

namespace App\Models;

// ✅ IMPORT INI WAJIB ADA untuk return type relationship!
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;  // ✅ INI YANG KURANG!

class Pemesanan extends Model
{
    protected $table = 'pemesanans';
    public $timestamps = true;

    protected $fillable = [
        'id_pelanggan',
        'id_jenis_bayar',
        'no_resi',
        'tgl_pesan',
        'status_pesan',
        'total_bayar',
        'catatan',
    ];

    protected $casts = [
        'tgl_pesan' => 'datetime',
        'total_bayar' => 'decimal:2',
    ];

    /**
     * Relasi ke Pelanggan
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    /**
     * Relasi ke Jenis Pembayaran
     */
    public function jenisPembayaran(): BelongsTo
    {
        return $this->belongsTo(JenisPembayaran::class, 'id_jenis_bayar');
    }

    /**
     * Relasi ke Detail Pemesanan
     */
    public function detailPemesanans(): HasMany
    {
        return $this->hasMany(DetailPemesanan::class, 'pemesanan_id');
    }

    /**
     * Relasi ke Pengiriman ✅ FIXED RETURN TYPE
     */
    public function pengiriman(): HasOne  // ✅ Sekarang Laravel tahu ini dari Illuminate\...
    {
        return $this->hasOne(Pengiriman::class, 'pemesanan_id');
    }

    // ... helper methods ...
}