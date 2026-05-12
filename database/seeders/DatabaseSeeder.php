<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            JenisPembayaranSeeder::class,
            PaketSeeder::class,
        ]);

        $this->command->info('✅ All seeders completed successfully!');
        $this->command->info('📋 Data yang di-seed:');
        $this->command->info('  - Users: admin@fakhrikitchen.com, owner@fakhrikitchen.com, kurir@fakhrikitchen.com');
        $this->command->info('  - Password semua user: 12345678');
        $this->command->info('  - Jenis Pembayaran: 5 metode');
        $this->command->info('  - Paket Catering: 5 paket');
    }
}
