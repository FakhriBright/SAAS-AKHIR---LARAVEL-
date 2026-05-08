<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelanggan')->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('id_jenis_bayar')->constrained('jenis_pembayarans')->onDelete('cascade');
            $table->string('no_resi', 30)->unique();
            $table->dateTime('tgl_pesan');
            
            // ✅ ENUM LENGKAP (Termasuk 'Dibatalkan')
            $table->enum('status_pesan', [
                'Menunggu Konfirmasi',
                'Sedang Diproses',
                'Menunggu Kurir',
                'Selesai',
                'Dibatalkan'
            ])->default('Menunggu Konfirmasi');
            
            $table->decimal('total_bayar', 15, 2);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};