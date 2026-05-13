<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    
    protected $fillable = [
        'id_pelanggan',
        'paket_id',
        'jumlah',
    ];
    
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
    
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
    
    public function getSubtotalAttribute()
    {
        return $this->paket->harga_paket * $this->jumlah;
    }
}