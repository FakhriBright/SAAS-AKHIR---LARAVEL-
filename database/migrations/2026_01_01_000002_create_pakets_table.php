<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket', 50);
            
            // ✅ UBAH ENUM JADI STRING AGAR AMAN DI POSTGRES (NEON)
            // Validasi nilai tetap bisa kita atur di Controller/Model
            $table->string('jenis', 50); 
            
            // Enum kategori aman karena jarang diubah strukturnya
            $table->enum('kategori', ['Pernikahan', 'Selamatan', 'Ulang Tahun', 'Studi Tour', 'Rapat'])->nullable(); 
            
            $table->integer('jumlah_pax');
            $table->integer('harga_paket'); // Sesuaikan dengan gambar tugas (int)
            $table->text('deskripsi')->nullable();
            $table->string('foto1', 255)->nullable();
            $table->string('foto2', 255)->nullable();
            $table->string('foto3', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};