<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pelanggan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'selaluli0123@gmail.com'],
            ['name' => 'Admin Catering', 'password' => bcrypt('12345678'), 'level' => 'admin']
        );

        // Owner
        User::updateOrCreate(
            ['email' => 'fakhri341@smk.belajar.id'],
            ['name' => 'Fakhri Owner', 'password' => bcrypt('12345678'), 'level' => 'owner']
        );

        // Kurir
        User::updateOrCreate(
            ['email' => 'royhan@gmail.com'],
            ['name' => 'Royhan Kurir', 'password' => bcrypt('12345678'), 'level' => 'kurir']
        );

        // Customer
        Pelanggan::updateOrCreate(
            ['email' => 'regan@gmail.com'],
            [
                'nama_pelanggan' => 'Regan Customer',
                'password' => bcrypt('12345678'),
                'telepon' => '081234567890',
                'alamat1' => 'Jl. Contoh No. 123, Bogor',
            ]
        );
    }
}