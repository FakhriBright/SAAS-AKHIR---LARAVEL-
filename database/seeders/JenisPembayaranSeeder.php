<?php

namespace Database\Seeders;

use App\Models\JenisPembayaran;
use Illuminate\Database\Seeder;

class JenisPembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $pembayarans = [
            ['metode_pembayaran' => 'Transfer Bank BCA'],
            ['metode_pembayaran' => 'Transfer Bank Mandiri'],
            ['metode_pembayaran' => 'Transfer Bank BNI'],
            ['metode_pembayaran' => 'COD (Bayar di Tempat)'],
            ['metode_pembayaran' => 'E-Wallet (GoPay/OVO/Dana)'],
        ];

        foreach ($pembayarans as $pembayaran) {
            JenisPembayaran::firstOrCreate($pembayaran);
        }
    }
}
