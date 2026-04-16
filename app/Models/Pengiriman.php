<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengiriman extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'pengirimans'; // FIX WAJIB

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}
