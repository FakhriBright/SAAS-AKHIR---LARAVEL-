<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;  // ✅ IMPORT INI!

class DetailPemesanan extends Model
{
    // ...

    public function pemesanan(): BelongsTo  // ✅ Return type sekarang valid
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}