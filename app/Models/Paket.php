<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paket extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relasi ke detail pemesanan
    public function detail_pemesanans()
    {
        return $this->hasMany(DetailPemesanan::class);
    }
}
