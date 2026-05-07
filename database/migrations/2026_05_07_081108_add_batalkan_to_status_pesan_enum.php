<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE pemesanans MODIFY COLUMN status_pesan ENUM('Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir', 'Selesai', 'Dibatalkan') DEFAULT 'Menunggu Konfirmasi'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE pemesanans MODIFY COLUMN status_pesan ENUM('Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir', 'Selesai') DEFAULT 'Menunggu Konfirmasi'");
    }
};
