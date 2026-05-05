<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('pengirimans', function (Blueprint $table) {
        if (!Schema::hasColumn('pengirimans', 'status')) {
            $table->enum('status', ['Sedang Dikirim', 'Tiba Ditujuan'])
                  ->default('Sedang Dikirim')
                  ->after('tgl_kirim');
        }
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengirimans', function (Blueprint $table) {
            //
        });
    }
};
