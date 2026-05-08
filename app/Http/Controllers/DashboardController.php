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
    /**
     * Admin Dashboard dengan Statistik Lengkap
     */
    public function index()
    {
        $user = auth()->user();

        // 📊 STATISTIK UTAMA
        $totalPesanan = Pemesanan::count();
        $pesananHariIni = Pemesanan::whereDate('created_at', today())->count();
        $pesananBulanIni = Pemesanan::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

        // 💰 PENDAPATAN
        $pendapatanTotal = Pemesanan::where('status_pesan', 'Selesai')->sum('total_bayar');
        $pendapatanBulanIni = Pemesanan::where('status_pesan', 'Selesai')
                                ->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->sum('total_bayar');
        $pendapatanHariIni = Pemesanan::where('status_pesan', 'Selesai')
                                ->whereDate('created_at', today())
                                ->sum('total_bayar');

        // 📈 STATUS PESANAN
        $menungguKonfirmasi = Pemesanan::where('status_pesan', 'Menunggu Konfirmasi')->count();
        $sedangDiproses = Pemesanan::where('status_pesan', 'Sedang Diproses')->count();
        $menungguKurir = Pemesanan::where('status_pesan', 'Menunggu Kurir')->count();
        $selesai = Pemesanan::where('status_pesan', 'Selesai')->count();
        $dibatalkan = Pemesanan::where('status_pesan', 'Dibatalkan')->count();

        // 👥 PELANGGAN & PRODUK
        $totalPelanggan = Pelanggan::count();
        $totalPaket = Paket::count();

        // 📦 PESANAN TERBARU (10 terakhir)
        $recentOrders = Pemesanan::with(['pelanggan', 'jenisPembayaran'])
                        ->latest()
                        ->take(10)
                        ->get();

        // 📅 GRAFIK: Pesanan 7 Hari Terakhir
        $last7Days = collect(range(6, 0))->map(function ($days) {
            $date = Carbon::today()->subDays($days);
            return [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('D'), // Sen, Sel, Rab...
                'count' => Pemesanan::whereDate('created_at', $date)->count(),
                'revenue' => Pemesanan::whereDate('created_at', $date)
                            ->where('status_pesan', 'Selesai')
                            ->sum('total_bayar')
            ];
        });

        // 📊 GRAFIK: Status Pesanan (untuk chart pie/doughnut)
        $statusData = [
            'labels' => ['Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir', 'Selesai', 'Dibatalkan'],
            'data' => [$menungguKonfirmasi, $sedangDiproses, $menungguKurir, $selesai, $dibatalkan],
            'colors' => ['#ffc107', '#17a2b8', '#6c757d', '#28a745', '#dc3545']
        ];

        return view('dashboard', compact(
            'totalPesanan',
            'pesananHariIni',
            'pesananBulanIni',
            'pendapatanTotal',
            'pendapatanBulanIni',
            'pendapatanHariIni',
            'menungguKonfirmasi',
            'sedangDiproses',
            'menungguKurir',
            'selesai',
            'dibatalkan',
            'totalPelanggan',
            'totalPaket',
            'recentOrders',
            'last7Days',
            'statusData',
            'user'
        ));
    }
}
