<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Models\Paket;
use App\Models\DetailPemesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // AMBIL DATA REAL DARI DATABASE
        $totalPesanan = Pemesanan::count();
        $pesananHariIni = Pemesanan::whereDate('created_at', today())->count();
        
        $pendapatanTotal = Pemesanan::sum('total_bayar');
        $pendapatanHariIni = Pemesanan::whereDate('created_at', today())->sum('total_bayar');
        
        $totalPelanggan = Pelanggan::count();
        
        // ✅ INI YANG PENTING - Ambil dari database
        $totalPaket = Paket::count(); 

        // Status
        $menungguKonfirmasi = Pemesanan::where('status_pesan', 'Menunggu Konfirmasi')->count();
        $sedangDiproses = Pemesanan::where('status_pesan', 'Sedang Diproses')->count();
        $menungguKurir = Pemesanan::where('status_pesan', 'Menunggu Kurir')->count();
        $selesai = Pemesanan::where('status_pesan', 'Selesai')->count();
        $dibatalkan = Pemesanan::where('status_pesan', 'Dibatalkan')->count();

        // Chart
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

        // Top Packages
        $topPackages = DetailPemesanan::select('paket_id', DB::raw('sum(jumlah) as total_terjual'))
            ->whereHas('pemesanan', function($query) {
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
            })
            ->groupBy('paket_id')
            ->orderByDesc('total_terjual')
            ->with('paket')
            ->limit(5)
            ->get();

        // Recent Orders
        $recentOrders = Pemesanan::with(['pelanggan'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalPesanan', 'pesananHariIni', 
            'pendapatanTotal', 'pendapatanHariIni',
            'totalPelanggan', 'totalPaket',
            'menungguKonfirmasi', 'sedangDiproses', 'menungguKurir', 'selesai', 'dibatalkan',
            'chartLabels', 'chartData',
            'recentOrders', 'topPackages'
        ));
    }
}