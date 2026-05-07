<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanans')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->dateTime('tgl_kirim')->nullable();
            $table->dateTime('tgl_tiba')->nullable();
            $table->enum('status_kirim', ['Sedang Dikirim', 'Tiba Ditujuan'])->default('Sedang Dikirim');
            $table->string('bukti_foto', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengirimans');
    }
};