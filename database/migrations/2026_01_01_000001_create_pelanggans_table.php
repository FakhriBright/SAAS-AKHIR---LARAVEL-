<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telepon', 15);
            $table->text('alamat1');
            $table->text('alamat2')->nullable();
            $table->text('alamat3')->nullable();
            $table->string('kartu_id', 50)->nullable();
            $table->string('foto', 255)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};