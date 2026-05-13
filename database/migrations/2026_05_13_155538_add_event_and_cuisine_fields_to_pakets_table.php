<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            $table->string('jenis_acara')->nullable()->after('kategori'); // wedding, syukuran, rapat, dll
            $table->string('jenis_masakan')->nullable()->after('jenis_acara'); // nusantara, internasional, vegan
        });
    }

    public function down(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            $table->dropColumn(['jenis_acara', 'jenis_masakan']);
        });
    }
};