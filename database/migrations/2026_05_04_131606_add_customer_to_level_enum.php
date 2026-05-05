<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah nilai 'customer' ke kolom ENUM level
        DB::statement("
            ALTER TABLE `users`
            CHANGE `level` `level`
            ENUM('admin', 'owner', 'kurir', 'customer')
            NOT NULL
            DEFAULT 'kurir'
        ");
    }

    public function down(): void
    {
        // Rollback: hapus nilai 'customer' (pastikan tidak ada data customer dulu)
        DB::statement("
            ALTER TABLE `users`
            CHANGE `level` `level`
            ENUM('admin', 'owner', 'kurir')
            NOT NULL
            DEFAULT 'kurir'
        ");
    }
};
