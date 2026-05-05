<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            // Tambah kolom tgl_lahir jika belum ada
            if (!Schema::hasColumn('pelanggans', 'tgl_lahir')) {
                $table->date('tgl_lahir')->nullable()->after('password');
            }

            // Rename kolom 'alamat' menjadi 'alamat1' jika 'alamat1' belum ada
            if (!Schema::hasColumn('pelanggans', 'alamat1') && Schema::hasColumn('pelanggans', 'alamat')) {
                // Hapus kolom alamat lama
                $table->dropColumn('alamat');
            }

            // Tambah kolom alamat1, alamat2, alamat3
            if (!Schema::hasColumn('pelanggans', 'alamat1')) {
                $table->text('alamat1')->after('telepon');
            }
            if (!Schema::hasColumn('pelanggans', 'alamat2')) {
                $table->text('alamat2')->nullable()->after('alamat1');
            }
            if (!Schema::hasColumn('pelanggans', 'alamat3')) {
                $table->text('alamat3')->nullable()->after('alamat2');
            }

            // Tambah kolom kartu_id
            if (!Schema::hasColumn('pelanggans', 'kartu_id')) {
                $table->string('kartu_id', 50)->nullable()->after('alamat3');
            }

            // Tambah kolom foto
            if (!Schema::hasColumn('pelanggans', 'foto')) {
                $table->string('foto', 255)->nullable()->after('kartu_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->dropColumn(['tgl_lahir', 'alamat1', 'alamat2', 'alamat3', 'kartu_id', 'foto']);
        });
    }
};
