<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Generate PDF Laporan Bulanan
     */
    public function downloadMonthlyReport(Request $request)
    {
        // ✅ FIX: Cast bulan dan tahun ke integer
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));
        
        // Ambil data pemesanan bulan ini
        $pemesanans = Pemesanan::with(['pelanggan', 'detailPemesanans.paket'])
            ->whereYear('tgl_pesan', $tahun)
            ->whereMonth('tgl_pesan', $bulan)
            ->orderBy('tgl_pesan', 'asc')
            ->get();
        
        // Hitung statistik
        $totalPesanan = $pemesanans->count();
        $totalPendapatan = $pemesanans->sum('total_bayar');
        $totalPelanggan = $pemesanans->unique('id_pelanggan')->count();
        
        // Group by status
        $statusData = [
            'Menunggu Konfirmasi' => $pemesanans->where('status_pesan', 'Menunggu Konfirmasi')->count(),
            'Sedang Diproses' => $pemesanans->where('status_pesan', 'Sedang Diproses')->count(),
            'Menunggu Kurir' => $pemesanans->where('status_pesan', 'Menunggu Kurir')->count(),
            'Selesai' => $pemesanans->where('status_pesan', 'Selesai')->count(),
            'Dibatalkan' => $pemesanans->where('status_pesan', 'Dibatalkan')->count(),
        ];
        
        // ✅ FIX: Gunakan createFromDate untuk nama bulan (lebih aman)
        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F');
        
        // Generate PDF
        $pdf = Pdf::loadView('reports.monthly-report', compact(
            'pemesanans',
            'totalPesanan',
            'totalPendapatan',
            'totalPelanggan',
            'statusData',
            'bulan',
            'tahun',
            'namaBulan'
        ));
        
        // Set paper size dan orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Download dengan nama file
        $filename = "Laporan_Bulan_{$namaBulan}_{$tahun}.pdf";
        return $pdf->download($filename);
    }
    
    /**
     * Preview Laporan (opsional)
     */
    public function previewMonthlyReport(Request $request)
    {
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));
        
        $pemesanans = Pemesanan::with(['pelanggan', 'detailPemesanans.paket'])
            ->whereYear('tgl_pesan', $tahun)
            ->whereMonth('tgl_pesan', $bulan)
            ->orderBy('tgl_pesan', 'asc')
            ->get();
        
        $totalPesanan = $pemesanans->count();
        $totalPendapatan = $pemesanans->sum('total_bayar');
        $totalPelanggan = $pemesanans->unique('id_pelanggan')->count();
        
        $statusData = [
            'Menunggu Konfirmasi' => $pemesanans->where('status_pesan', 'Menunggu Konfirmasi')->count(),
            'Sedang Diproses' => $pemesanans->where('status_pesan', 'Sedang Diproses')->count(),
            'Menunggu Kurir' => $pemesanans->where('status_pesan', 'Menunggu Kurir')->count(),
            'Selesai' => $pemesanans->where('status_pesan', 'Selesai')->count(),
            'Dibatalkan' => $pemesanans->where('status_pesan', 'Dibatalkan')->count(),
        ];
        
        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F');
        
        return view('reports.monthly-report', compact(
            'pemesanans',
            'totalPesanan',
            'totalPendapatan',
            'totalPelanggan',
            'statusData',
            'bulan',
            'tahun',
            'namaBulan'
        ));
    }
}