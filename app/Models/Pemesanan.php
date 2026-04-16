<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemesanan extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // relasi ke detail pemesanan
    public function detail_pemesanans()
    {
        return $this->hasMany(DetailPemesanan::class);
    }

    // relasi ke pengiriman
    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class);
    }
}
