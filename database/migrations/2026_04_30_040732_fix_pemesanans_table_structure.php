<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            // 1. Rename pelanggan_id → id_pelanggan
            if (Schema::hasColumn('pemesanans', 'pelanggan_id') && !Schema::hasColumn('pemesanans', 'id_pelanggan')) {
                $table->renameColumn('pelanggan_id', 'id_pelanggan');
            }

            // 2. Tambah id_jenis_bayar jika belum ada
            if (!Schema::hasColumn('pemesanans', 'id_jenis_bayar')) {
                $table->unsignedBigInteger('id_jenis_bayar')->after('id_pelanggan')->nullable();
                $table->foreign('id_jenis_bayar')->references('id')->on('jenis_pembayarans')->onDelete('set null');
            }

            // 3. Tambah no_resi jika belum ada
            if (!Schema::hasColumn('pemesanans', 'no_resi')) {
                $table->string('no_resi', 30)->after('id_jenis_bayar')->nullable();
            }

            // 4. Rename tanggal_acara → tgl_pesan
            if (Schema::hasColumn('pemesanans', 'tanggal_acara') && !Schema::hasColumn('pemesanans', 'tgl_pesan')) {
                $table->renameColumn('tanggal_acara', 'tgl_pesan');
            }

            // 5. Ubah status → status_pesan dengan enum
            if (Schema::hasColumn('pemesanans', 'status') && !Schema::hasColumn('pemesanans', 'status_pesan')) {
                $table->dropColumn('status');
            }
            if (!Schema::hasColumn('pemesanans', 'status_pesan')) {
                $table->enum('status_pesan', ['Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir'])
                      ->default('Menunggu Konfirmasi')
                      ->after('tgl_pesan');
            }

            // 6. Hapus kolom yang seharusnya di detail_pemesanans
            if (Schema::hasColumn('pemesanans', 'paket_id')) {
                $table->dropForeign(['paket_id']);
                $table->dropColumn('paket_id');
            }
            if (Schema::hasColumn('pemesanans', 'jumlah')) {
                $table->dropColumn('jumlah');
            }
            if (Schema::hasColumn('pemesanans', 'lokasi_acara')) {
                $table->dropColumn('lokasi_acara');
            }
            if (Schema::hasColumn('pemesanans', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            // Rollback changes
            if (Schema::hasColumn('pemesanans', 'id_pelanggan')) {
                $table->renameColumn('id_pelanggan', 'pelanggan_id');
            }

            $table->dropForeign(['id_jenis_bayar']);
            $table->dropColumn(['id_jenis_bayar', 'no_resi', 'status_pesan']);

            if (!Schema::hasColumn('pemesanans', 'tgl_pesan')) {
                $table->renameColumn('tgl_pesan', 'tanggal_acara');
            }

            $table->unsignedBigInteger('paket_id')->nullable();
            $table->integer('jumlah')->default(1);
            $table->string('lokasi_acara')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['Diproses', 'Dikirim', 'Selesai'])->default('Diproses');
        });
    }
};
