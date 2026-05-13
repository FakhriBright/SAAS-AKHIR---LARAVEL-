<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Models\Paket;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalPesanan = Pemesanan::count();
        $pesananHariIni = Pemesanan::whereDate('created_at', today())->count();
        $pendapatanTotal = Pemesanan::sum('total_bayar');
        $pendapatanHariIni = Pemesanan::whereDate('created_at', today())->sum('total_bayar');
        $totalPelanggan = Pelanggan::count();
        $totalPaket = Paket::count();
        
        // Status
        $menungguKonfirmasi = Pemesanan::where('status_pesan', 'Menunggu Konfirmasi')->count();
        $sedangDiproses = Pemesanan::where('status_pesan', 'Sedang Diproses')->count();
        $menungguKurir = Pemesanan::where('status_pesan', 'Menunggu Kurir')->count();
        $selesai = Pemesanan::where('status_pesan', 'Selesai')->count();
        $dibatalkan = Pemesanan::where('status_pesan', 'Dibatalkan')->count();
        
        // Chart Data - Jumlah pesanan per hari bulan ini
        $daysInMonth = Carbon::now()->daysInMonth;
        $chartLabels = [];
        $chartData = [];
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $chartLabels[] = $day;
            $count = Pemesanan::whereYear('created_at', now()->year)
                            ->whereMonth('created_at', now()->month)
                            ->whereDay('created_at', $day)
                            ->count();
            $chartData[] = $count;
        }
        
        // Recent Orders
        $recentOrders = Pemesanan::with(['pelanggan'])->latest()->take(10)->get();
        
        return view('dashboard', compact(
            'totalPesanan', 'pesananHariIni', 'pendapatanTotal', 'pendapatanHariIni',
            'totalPelanggan', 'totalPaket',
            'menungguKonfirmasi', 'sedangDiproses', 'menungguKurir', 'selesai', 'dibatalkan',
            'chartLabels', 'chartData', 'recentOrders'
        ));
    }
}