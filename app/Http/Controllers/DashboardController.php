<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pelanggan;
use App\Models\Pemesanan;
use App\Models\Pengiriman;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'paket' => Paket::count(),
            'pelanggan' => Pelanggan::count(),
            'pemesanan' => Pemesanan::count(),
            'pengiriman' => Pengiriman::count(),
        ]);
    }
}
