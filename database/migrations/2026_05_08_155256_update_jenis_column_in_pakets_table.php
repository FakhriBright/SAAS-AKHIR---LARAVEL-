<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek apakah kolom jenis menggunakan ENUM
        $columnType = DB::select("SHOW COLUMNS FROM pakets WHERE Field = 'jenis'")[0]->Type;

        if (strpos($columnType, 'enum') !== false) {
            // Ubah dari ENUM ke VARCHAR(50)
            DB::statement("ALTER TABLE pakets MODIFY COLUMN jenis VARCHAR(50) NOT NULL");
        } else {
            // Pastikan kolom jenis adalah VARCHAR(50)
            Schema::table('pakets', function (Blueprint $table) {
                $table->string('jenis', 50)->change();
            });
        }

        // Update data lama jika ada
        DB::table('pakets')->where('jenis', 'Box')->update(['jenis' => 'Meal Box']);
        DB::table('pakets')->where('jenis', 'prasmanan')->update(['jenis' => 'Prasmanan']);
        DB::table('pakets')->where('jenis', 'snack box')->update(['jenis' => 'Snack Box']);
        DB::table('pakets')->where('jenis', 'tumpeng')->update(['jenis' => 'Tumpeng']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke ENUM lama (jika perlu rollback)
        DB::statement("ALTER TABLE pakets MODIFY COLUMN jenis ENUM('Prasmanan', 'Box') DEFAULT 'Prasmanan'");

        // Kembalikan data Meal Box ke Box
        DB::table('pakets')->where('jenis', 'Meal Box')->update(['jenis' => 'Box']);
    }
};
