<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pemesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanans')->onDelete('cascade');
            $table->foreignId('paket_id')->constrained('pakets')->onDelete('cascade');
            $table->integer('jumlah');
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanans');
    }
};