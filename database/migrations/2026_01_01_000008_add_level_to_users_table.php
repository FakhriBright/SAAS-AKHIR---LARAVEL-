<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ✅ HAPUS ->after('password') 
            // ✅ Ganti enum ke string agar 100% kompatibel dengan PostgreSQL
            $table->string('level')->default('kurir');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
};