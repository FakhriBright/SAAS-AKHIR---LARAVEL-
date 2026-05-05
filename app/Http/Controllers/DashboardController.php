<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Pendapatan (Hanya yang Selesai)
        $totalPendapatan = Pemesanan::where('status_pesan', 'Selesai')->sum('total_bayar');

        // 2. Total Pesanan Keseluruhan
        $totalPesanan = Pemesanan::count();

        // 3. Pesanan Bulan Ini
        $pesananBulanIni = Pemesanan::whereYear('tgl_pesan', now()->year)
                            ->whereMonth('tgl_pesan', now()->month)
                            ->count();

        // 4. Pesanan Bulan Lalu (untuk hitung pertumbuhan)
        $pesananBulanLalu = Pemesanan::whereYear('tgl_pesan', now()->year)
                             ->whereMonth('tgl_pesan', now()->month - 1)
                             ->count();

        $pertumbuhanPesanan = $pesananBulanLalu > 0
            ? round((($pesananBulanIni - $pesananBulanLalu) / $pesananBulanLalu) * 100)
            : ($pesananBulanIni > 0 ? 100 : 0);

        // 5. Pesanan Pending (Menunggu Konfirmasi / Sedang Diproses)
        $pesananPending = Pemesanan::whereIn('status_pesan', ['Menunggu Konfirmasi', 'Sedang Diproses'])->count();

        // 6. Total Pelanggan
        $totalPelanggan = Pelanggan::count();

        // 7. 5 Pesanan Terbaru
        $recentPemesanan = Pemesanan::with(['pelanggan'])
                            ->latest()
                            ->take(5)
                            ->get();

        // 8. Top 5 Paket Terlaris
        // ✅ PERBAIKAN: Gunakan 'paket_id' bukan 'id_paket'
        $topPakets = DB::table('detail_pemesanans')
                    ->join('pakets', 'detail_pemesanans.paket_id', '=', 'pakets.id') // ✅ FIX DI SINI
                    ->select(
                        'pakets.id',
                        'pakets.nama_paket',
                        DB::raw('SUM(detail_pemesanans.subtotal) as total_pendapatan'),
                        DB::raw('SUM(COALESCE(detail_pemesanans.subtotal / NULLIF(pakets.harga, 0), 1)) as total_terjual')
                    )
                    ->groupBy('pakets.id', 'pakets.nama_paket')
                    ->orderBy('total_pendapatan', 'desc')
                    ->take(5)
                    ->get();

        // 9. Chart Data - 6 Bulan Terakhir
        $chartLabels = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabel = $date->format('M');

            $count = Pemesanan::whereYear('tgl_pesan', $date->year)
                        ->whereMonth('tgl_pesan', $date->month)
                        ->count();

            $chartLabels[] = $monthLabel;
            $chartData[] = $count;
        }

        return view('dashboard', compact(
            'totalPendapatan',
            'totalPesanan',
            'pesananBulanIni',
            'pertumbuhanPesanan',
            'pesananPending',
            'totalPelanggan',
            'recentPemesanan',
            'topPakets',
            'chartLabels',
            'chartData'
        ));
    }
}
