<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah nilai 'Tiba Ditujuan' ke ENUM status_kirim
        DB::statement("
            ALTER TABLE `pengirimans`
            CHANGE `status_kirim` `status_kirim`
            ENUM('Sedang Dikirim', 'Tiba Ditujuan')
            NOT NULL
            DEFAULT 'Sedang Dikirim'
        ");
    }

    public function down(): void
    {
        // Rollback
        DB::statement("
            ALTER TABLE `pengirimans`
            CHANGE `status_kirim` `status_kirim`
            ENUM('Sedang Dikirim')
            NOT NULL
            DEFAULT 'Sedang Dikirim'
        ");
    }
};
