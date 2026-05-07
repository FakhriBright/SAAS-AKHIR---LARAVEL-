<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_jenis_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jenis_pembayaran')->constrained('jenis_pembayarans')->onDelete('cascade');
            $table->string('no_rek', 50)->nullable();
            $table->text('tempat_bayar')->nullable();
            $table->string('logo', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_jenis_pembayarans');
    }
};