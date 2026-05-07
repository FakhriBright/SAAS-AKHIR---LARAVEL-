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
            $table->string('nama_paket', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2);
            $table->integer('jumlah_pax');
            $table->enum('jenis', ['Prasmanan', 'Box']);
            $table->text('kategori')->nullable(); // Pisahkan dengan koma
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