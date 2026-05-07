<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;  // ✅ IMPORT INI!

class Pengiriman extends Model
{
    // ...

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}