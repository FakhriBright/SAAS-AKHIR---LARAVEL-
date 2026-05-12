<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@fakhrikitchen.com'],
            [
                'name' => 'Admin Catering',
                'password' => Hash::make('12345678'),
                'level' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Owner
        User::updateOrCreate(
            ['email' => 'owner@fakhrikitchen.com'],
            [
                'name' => 'Fakhri Owner',
                'password' => Hash::make('12345678'),
                'level' => 'owner',
                'email_verified_at' => now(),
            ]
        );

        // Kurir
        User::updateOrCreate(
            ['email' => 'kurir@fakhrikitchen.com'],
            [
                'name' => 'Royhan Kurir',
                'password' => Hash::make('12345678'),
                'level' => 'kurir',
                'email_verified_at' => now(),
            ]
        );
    }
}
