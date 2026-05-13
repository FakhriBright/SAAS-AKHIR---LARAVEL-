<?php

namespace Database\Seeders;

use App\Models\Paket;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        $pakets = [
            // SNACK BOX
            [
                'nama_paket' => 'Paket Jajan Pasar Hemat',
                'kategori' => 'Snack Box',
                'jenis_acara' => 'syukuran',
                'jenis_masakan' => 'nusantara',
                'deskripsi' => 'Paket hemat untuk acara kecil dan sederhana',
                'jumlah_pax' => 10,
                'harga_paket' => 70000,
                'jenis' => 'Snack Box',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Paket Snack Box Premium',
                'kategori' => 'Snack Box',
                'jenis_acara' => 'rapat',
                'jenis_masakan' => 'internasional',
                'deskripsi' => 'Snack box premium dengan variasi kue modern dan tradisional',
                'jumlah_pax' => 20,
                'harga_paket' => 150000,
                'jenis' => 'Snack Box',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Paket Snack Meeting',
                'kategori' => 'Snack Box',
                'jenis_acara' => 'rapat',
                'jenis_masakan' => 'nusantara',
                'deskripsi' => 'Cocok untuk meeting kantor dan seminar',
                'jumlah_pax' => 15,
                'harga_paket' => 100000,
                'jenis' => 'Snack Box',
                'status' => 'aktif',
            ],
            
            // MEAL BOX
            [
                'nama_paket' => 'Paket Bento Meal Box',
                'kategori' => 'Meal Box',
                'jenis_acara' => 'rapat',
                'jenis_masakan' => 'internasional',
                'deskripsi' => 'Nasi box praktis untuk meeting atau acara kantor',
                'jumlah_pax' => 1,
                'harga_paket' => 14500,
                'jenis' => 'Meal Box',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Paket Meal Box Nusantara',
                'kategori' => 'Meal Box',
                'jenis_acara' => 'syukuran',
                'jenis_masakan' => 'nusantara',
                'deskripsi' => 'Meal box dengan menu tradisional Indonesia',
                'jumlah_pax' => 1,
                'harga_paket' => 25000,
                'jenis' => 'Meal Box',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Paket Meal Box Vegan',
                'kategori' => 'Meal Box',
                'jenis_acara' => 'rapat',
                'jenis_masakan' => 'vegan',
                'deskripsi' => 'Meal box sehat dengan menu vegetarian/vegan',
                'jumlah_pax' => 1,
                'harga_paket' => 30000,
                'jenis' => 'Meal Box',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Paket Nasi Box Deluxe',
                'kategori' => 'Meal Box',
                'jenis_acara' => 'wedding',
                'jenis_masakan' => 'nusantara',
                'deskripsi' => 'Nasi box premium untuk acara spesial',
                'jumlah_pax' => 1,
                'harga_paket' => 35000,
                'jenis' => 'Meal Box',
                'status' => 'aktif',
            ],
            
            // PRASMANAN
            [
                'nama_paket' => 'Paket Wedding Prasmanan Premium',
                'kategori' => 'Prasmanan',
                'jenis_acara' => 'wedding',
                'jenis_masakan' => 'internasional',
                'deskripsi' => 'High Quality catering untuk acara spesial',
                'jumlah_pax' => 200,
                'harga_paket' => 8000000,
                'jenis' => 'Prasmanan',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Paket Prasmanan Syukuran',
                'kategori' => 'Prasmanan',
                'jenis_acara' => 'syukuran',
                'jenis_masakan' => 'nusantara',
                'deskripsi' => 'Prasmanan lengkap dengan menu tradisional',
                'jumlah_pax' => 100,
                'harga_paket' => 3500000,
                'jenis' => 'Prasmanan',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Paket Rapat Kantor',
                'kategori' => 'Prasmanan',
                'jenis_acara' => 'rapat',
                'jenis_masakan' => 'nusantara',
                'deskripsi' => 'Paket hemat untuk rapat dan meeting kantor',
                'jumlah_pax' => 50,
                'harga_paket' => 1750000,
                'jenis' => 'Prasmanan',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Arisan Buffet',
                'kategori' => 'Prasmanan',
                'jenis_acara' => 'rapat',
                'jenis_masakan' => 'internasional',
                'deskripsi' => 'Buffet prasmanan untuk arisan dan gathering',
                'jumlah_pax' => 30,
                'harga_paket' => 1500000,
                'jenis' => 'Prasmanan',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Paket Prasmanan Vegan',
                'kategori' => 'Prasmanan',
                'jenis_acara' => 'syukuran',
                'jenis_masakan' => 'vegan',
                'deskripsi' => 'Prasmanan sehat dengan menu vegetarian',
                'jumlah_pax' => 50,
                'harga_paket' => 2000000,
                'jenis' => 'Prasmanan',
                'status' => 'aktif',
            ],
            
            // TUMPENG
            [
                'nama_paket' => 'Paket Tumpeng Nusantara',
                'kategori' => 'Tumpeng',
                'jenis_acara' => 'syukuran',
                'jenis_masakan' => 'nusantara',
                'deskripsi' => 'Tumpeng lengkap dengan lauk pauk tradisional',
                'jumlah_pax' => 10,
                'harga_paket' => 500000,
                'jenis' => 'Tumpeng',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Paket Tumpeng Mini',
                'kategori' => 'Tumpeng',
                'jenis_acara' => 'syukuran',
                'jenis_masakan' => 'nusantara',
                'deskripsi' => 'Tumpeng mini untuk acara kecil',
                'jumlah_pax' => 5,
                'harga_paket' => 250000,
                'jenis' => 'Tumpeng',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Paket Tumpeng Deluxe',
                'kategori' => 'Tumpeng',
                'jenis_acara' => 'wedding',
                'jenis_masakan' => 'nusantara',
                'deskripsi' => 'Tumpeng besar dengan hiasan mewah',
                'jumlah_pax' => 20,
                'harga_paket' => 850000,
                'jenis' => 'Tumpeng',
                'status' => 'aktif',
            ],
            
            // RAPAT KANTOR
            [
                'nama_paket' => 'Paket Meeting Hemat',
                'kategori' => 'Rapat Kantor',
                'jenis_acara' => 'rapat',
                'jenis_masakan' => 'nusantara',
                'deskripsi' => 'Paket meeting hemat dengan snack dan makan siang',
                'jumlah_pax' => 20,
                'harga_paket' => 600000,
                'jenis' => 'Rapat Kantor',
                'status' => 'aktif',
            ],
            [
                'nama_paket' => 'Paket Meeting Premium',
                'kategori' => 'Rapat Kantor',
                'jenis_acara' => 'rapat',
                'jenis_masakan' => 'internasional',
                'deskripsi' => 'Paket meeting premium dengan menu lengkap',
                'jumlah_pax' => 30,
                'harga_paket' => 1200000,
                'jenis' => 'Rapat Kantor',
                'status' => 'aktif',
            ],
        ];

        foreach ($pakets as $paket) {
            Paket::create($paket);
        }
        
        $this->command->info('Paket seeder completed!');
    }
}