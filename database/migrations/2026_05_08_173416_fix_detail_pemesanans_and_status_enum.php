<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom 'jumlah' di detail_pemesanans (jika belum ada)
        if (!Schema::hasColumn('detail_pemesanans', 'jumlah')) {
            Schema::table('detail_pemesanans', function (Blueprint $table) {
                $table->unsignedInteger('jumlah')->default(1)->after('paket_id');
            });
        }

        // 2. Update ENUM status_pesan di pemesanans (tambah 'Dibatalkan')
        DB::statement("ALTER TABLE pemesanans MODIFY COLUMN status_pesan ENUM('Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir', 'Selesai', 'Dibatalkan') DEFAULT 'Menunggu Konfirmasi'");
    }

    public function down(): void
    {
        // Rollback kolom jumlah
        if (Schema::hasColumn('detail_pemesanans', 'jumlah')) {
            Schema::table('detail_pemesanans', function (Blueprint $table) {
                $table->dropColumn('jumlah');
            });
        }

        // Rollback ENUM status
        DB::statement("ALTER TABLE pemesanans MODIFY COLUMN status_pesan ENUM('Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir', 'Selesai') DEFAULT 'Menunggu Konfirmasi'");
    }
};