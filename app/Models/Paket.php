<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'pakets';

    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'harga',            // ✅
        'jumlah_porsi',     // ✅ GANTI dari jumlah_pax
        'kategori',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'jumlah_porsi' => 'integer',
    ];
}
