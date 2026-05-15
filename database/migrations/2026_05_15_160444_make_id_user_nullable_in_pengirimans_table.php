<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengirimans', function (Blueprint $table) {
            // 1. Drop Foreign Key constraint dulu biar bisa diubah
            $table->dropForeign(['id_user']);

            // 2. Ubah tipe jadi 'unsignedBigInteger' (biar sama kayak users.id) dan 'nullable'
            $table->unsignedBigInteger('id_user')->nullable()->change();
        });

        // 3. Pasang lagi Foreign Key-nya (opsional tapi bagus)
        Schema::table('pengirimans', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pengirimans', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->unsignedBigInteger('id_user')->nullable(false)->change();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }
};