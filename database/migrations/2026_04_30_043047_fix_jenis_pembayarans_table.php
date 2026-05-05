<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_pembayarans', function (Blueprint $table) {
            // Tambah kolom metode_pembayaran jika belum ada
            if (!Schema::hasColumn('jenis_pembayarans', 'metode_pembayaran')) {
                $table->string('metode_pembayaran', 30)->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jenis_pembayarans', function (Blueprint $table) {
            if (Schema::hasColumn('jenis_pembayarans', 'metode_pembayaran')) {
                $table->dropColumn('metode_pembayaran');
            }
        });
    }
};
