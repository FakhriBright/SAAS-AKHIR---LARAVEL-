<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Kalau kolom 'role' belum ada, tambahin
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('admin')->after('email');
            });
        }
        
        // Copy data dari 'level' ke 'role'
        DB::statement("UPDATE users SET role = level WHERE role IS NULL OR role = ''");
        
        // (Opsional) Hapus kolom 'level' kalau nggak dipakai lagi
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('level');
        // });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};