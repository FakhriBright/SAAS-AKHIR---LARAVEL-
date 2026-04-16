<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPemesanan extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relasi ke pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    // relasi ke paket
    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }
}
