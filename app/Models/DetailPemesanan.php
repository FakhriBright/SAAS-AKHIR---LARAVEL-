<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pemesanans';

    protected $fillable = [
        'pemesanan_id',  // ✅ Sesuai database (bukan 'id_pemesanan')
        'paket_id',      // ✅ Sesuai database (bukan 'id_paket')
        'subtotal',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    public function getJumlahAttribute()
    {
        if ($this->paket && $this->paket->harga > 0) {
            return $this->subtotal / $this->paket->harga;
        }
        return 1;
    }
}
