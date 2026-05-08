<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Mengubah kolom 'kategori' dari ENUM ke VARCHAR di PostgreSQL (Neon)
     * Karena PostgreSQL tidak support ALTER ENUM langsung.
     */
    public function up(): void
    {
        // PostgreSQL: Gunakan raw SQL untuk mengubah tipe kolom ENUM ke VARCHAR
        DB::statement("ALTER TABLE pakets ALTER COLUMN kategori TYPE VARCHAR(255) USING kategori::VARCHAR");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: Kembalikan ke VARCHAR (aman) atau ENUM jika mau
        // Untuk keamanan, kita biarkan tetap VARCHAR karena lebih fleksibel
        DB::statement("ALTER TABLE pakets ALTER COLUMN kategori TYPE VARCHAR(255)");
    }
};