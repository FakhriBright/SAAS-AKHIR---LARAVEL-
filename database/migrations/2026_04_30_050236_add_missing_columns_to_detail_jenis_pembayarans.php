<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_jenis_pembayarans', function (Blueprint $table) {
            // Tambah kolom no_rek jika belum ada
            if (!Schema::hasColumn('detail_jenis_pembayarans', 'no_rek')) {
                $table->string('no_rek', 25)->nullable()->after('id_jenis_pembayaran');
            }

            // Tambah kolom tempat_bayar jika belum ada
            if (!Schema::hasColumn('detail_jenis_pembayarans', 'tempat_bayar')) {
                $table->string('tempat_bayar', 50)->nullable()->after('no_rek');
            }

            // Tambah kolom logo jika belum ada
            if (!Schema::hasColumn('detail_jenis_pembayarans', 'logo')) {
                $table->string('logo', 255)->nullable()->after('tempat_bayar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('detail_jenis_pembayarans', function (Blueprint $table) {
            $table->dropColumn(['no_rek', 'tempat_bayar', 'logo']);
        });
    }
};
