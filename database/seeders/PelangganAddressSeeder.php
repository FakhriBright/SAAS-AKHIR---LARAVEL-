<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganAddressSeeder extends Seeder
{
    public function run(): void
    {
        // Update semua pelanggan yang alamatnya NULL
        $pelanggans = Pelanggan::whereNull('alamat')
            ->orWhere('alamat', '')
            ->get();

        $defaultAddress = 'Jl.Mbah Pengajengan Rt.06 Rw.01 No.04 Ds.Mangunsaren Kec.Tarub';

        foreach ($pelanggans as $index => $pelanggan) {
            $pelanggan->update([
                'alamat' => $defaultAddress
            ]);
            echo "Updated: {$pelanggan->nama_pelanggan}\n";
        }

        echo "Selesai! Total {$pelanggans->count()} data diupdate.\n";
    }
}
