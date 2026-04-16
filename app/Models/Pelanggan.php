<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relasi ke pemesanan
    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class);
    }
}
