<?php

namespace Database\Seeders;

use App\Models\Paket;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        $pakets = [
            [
                'nama_paket' => 'Paket Hemat',
                'deskripsi' => 'Paket hemat untuk acara kecil dan sederhana',
                'harga_paket' => 70000,
                'jumlah_pax' => 10,
                'jenis' => 'Snack Box',
                'kategori' => 'Syukuran',
            ],
            [
                'nama_paket' => 'Paket Meal Box',
                'deskripsi' => 'Nasi box praktis untuk meeting atau acara kantor',
                'harga_paket' => 14500,
                'jumlah_pax' => 1,
                'jenis' => 'Meal Box',
                'kategori' => 'Fleksible Event',
            ],
            [
                'nama_paket' => 'Paket Premium',
                'deskripsi' => 'High Quality catering untuk acara spesial',
                'harga_paket' => 8000000,
                'jumlah_pax' => 200,
                'jenis' => 'Prasmanan',
                'kategori' => 'Prewedding',
            ],
            [
                'nama_paket' => 'Paket Tumpeng Nusantara',
                'deskripsi' => 'Tumpeng lengkap dengan lauk pauk tradisional',
                'harga_paket' => 500000,
                'jumlah_pax' => 10,
                'jenis' => 'Tumpeng',
                'kategori' => 'Syukuran',
            ],
            [
                'nama_paket' => 'Paket Rapat Kantor',
                'deskripsi' => 'Paket hemat untuk rapat dan meeting kantor',
                'harga_paket' => 35000,
                'jumlah_pax' => 50,
                'jenis' => 'Prasmanan',
                'kategori' => 'Rapat',
            ],
        ];

        foreach ($pakets as $paket) {
            Paket::firstOrCreate(
                ['nama_paket' => $paket['nama_paket']],
                $paket
            );
        }
    }
}
