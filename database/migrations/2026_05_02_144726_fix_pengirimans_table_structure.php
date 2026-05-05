<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengirimans', function (Blueprint $table) {
            // 1. Rename kolom jika perlu (opsional - pilih salah satu)
            // Jika ingin pakai 'pemesanan_id' (standar Laravel), biarkan
            // Jika ingin pakai 'id_pesan' (sesuai gambar), uncomment baris bawah:
            // $table->renameColumn('pemesanan_id', 'id_pesan');

            // 2. Tambah kolom yang hilang
            if (!Schema::hasColumn('pengirimans', 'tgl_tiba')) {
                $table->dateTime('tgl_tiba')->nullable()->after('tgl_kirim');
            }

            if (!Schema::hasColumn('pengirimans', 'status_kirim')) {
                // Hapus kolom 'status' lama jika ada
                if (Schema::hasColumn('pengirimans', 'status')) {
                    $table->dropColumn('status');
                }
                // Tambah kolom baru dengan enum
                $table->enum('status_kirim', ['Sedang Dikirim', 'Tiba Ditujuan'])
                      ->default('Sedang Dikirim')
                      ->after('tgl_tiba');
            }

            if (!Schema::hasColumn('pengirimans', 'bukti_foto')) {
                $table->string('bukti_foto', 255)->nullable()->after('status_kirim');
            }

            if (!Schema::hasColumn('pengirimans', 'id_user')) {
                $table->unsignedBigInteger('id_user')->nullable()->after('bukti_foto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengirimans', function (Blueprint $table) {
            $table->dropColumn(['tgl_tiba', 'status_kirim', 'bukti_foto', 'id_user']);
        });
    }
};
