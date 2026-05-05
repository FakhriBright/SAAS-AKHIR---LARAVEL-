<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah nilai 'Selesai' ke kolom ENUM status_pesan
        DB::statement("
            ALTER TABLE `pemesanans`
            CHANGE `status_pesan` `status_pesan`
            ENUM('Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir', 'Selesai')
            NOT NULL
            DEFAULT 'Menunggu Konfirmasi'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: hapus nilai 'Selesai' dari ENUM
        DB::statement("
            ALTER TABLE `pemesanans`
            CHANGE `status_pesan` `status_pesan`
            ENUM('Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir')
            NOT NULL
            DEFAULT 'Menunggu Konfirmasi'
        ");
    }
};
