<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengiriman extends Model
{
    protected $table = 'pengirimans';
    
    protected $fillable = [
        'pemesanan_id',
        'id_user',        // ✅ Pastikan ada
        'tgl_kirim',
        'tgl_tiba',
        'status_kirim',
        'bukti_foto',
    ];
    
    protected $casts = [
        'tgl_kirim' => 'datetime',
        'tgl_tiba' => 'datetime',
    ];
    
    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }
    
    public function kurir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}