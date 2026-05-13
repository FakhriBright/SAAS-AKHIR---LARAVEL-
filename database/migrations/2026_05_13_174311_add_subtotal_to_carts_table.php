<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom subtotal jika belum ada
        if (!Schema::hasColumn('carts', 'subtotal')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->decimal('subtotal', 15, 2)->nullable()->after('jumlah');
            });
            
            // Update subtotal untuk data yang sudah ada
            DB::statement('
                UPDATE carts 
                SET subtotal = jumlah * (
                    SELECT harga_paket 
                    FROM pakets 
                    WHERE pakets.id = carts.paket_id
                )
            ');
        }
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('subtotal');
        });
    }
};