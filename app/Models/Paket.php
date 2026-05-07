<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paket extends Model
{
    protected $table = 'pakets';
    public $timestamps = true;

    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'harga',
        'jumlah_pax',      // ✅ Pakai 'jumlah_pax', BUKAN 'jumlah_porsi'
        'jenis',
        'kategori',
        'foto1',
        'foto2',
        'foto3',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function detailPemesanans(): HasMany
    {
        return $this->hasMany(DetailPemesanan::class, 'paket_id');
    }

    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}