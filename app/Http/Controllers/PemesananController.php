<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\Pelanggan;
use App\Models\Paket;
use App\Models\JenisPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf; // ✅ Import PDF Facade

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanan = Pemesanan::with(['pelanggan', 'jenisPembayaran', 'detailPemesanans.paket'])
                    ->latest()
                    ->get();

        return view('pemesanans.index', compact('pemesanan'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        $jenisPembayaran = JenisPembayaran::all();
        $paket = Paket::all();

        return view('pemesanans.create', compact('pelanggan', 'jenisPembayaran', 'paket'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id',
            'id_jenis_bayar' => 'required|exists:jenis_pembayarans,id',
            'paket_id' => 'required|array',
            'paket_id.*' => 'exists:pakets,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'tgl_pesan' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $count = Pemesanan::count() + 1;
            $noResi = 'RESI-' . date('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            $totalBayar = 0;
            $details = [];

            foreach ($validated['paket_id'] as $index => $paketId) {
                $paket = Paket::find($paketId);
                $jumlah = $validated['jumlah'][$index] ?? 1;

                if ($paket) {
                    $subtotal = $paket->harga * $jumlah;
                    $totalBayar += $subtotal;
                    $details[] = ['paket_id' => $paketId, 'subtotal' => $subtotal];
                }
            }

            if ($totalBayar <= 0) throw new \Exception("Total bayar tidak valid");

            $pemesanan = Pemesanan::create([
                'id_pelanggan' => $validated['id_pelanggan'],
                'id_jenis_bayar' => $validated['id_jenis_bayar'],
                'no_resi' => $noResi,
                'tgl_pesan' => $validated['tgl_pesan'],
                'status_pesan' => 'Menunggu Konfirmasi',
                'total_bayar' => $totalBayar,
            ]);

            foreach ($details as $detail) {
                $pemesanan->detailPemesanans()->create($detail);
            }

            DB::commit();
            return redirect()->route('pemesanans.index')
                ->with('success', 'Pemesanan berhasil dibuat! No. Resi: ' . $noResi);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Pemesanan Store Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function show(Pemesanan $pemesanan)
    {
        $pemesanan->load(['pelanggan', 'jenisPembayaran', 'detailPemesanans.paket']);
        return view('pemesanans.show', compact('pemesanan'));
    }

    public function edit(Pemesanan $pemesanan)
    {
        $pemesanan->load(['pelanggan', 'jenisPembayaran', 'detailPemesanans.paket']);
        $pelanggan = Pelanggan::all();
        $jenisPembayaran = JenisPembayaran::all();
        $paket = Paket::all();

        return view('pemesanans.edit', compact('pemesanan', 'pelanggan', 'jenisPembayaran', 'paket'));
    }

    public function update(Request $request, Pemesanan $pemesanan)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id',
            'id_jenis_bayar' => 'required|exists:jenis_pembayarans,id',
            'status_pesan' => 'required|in:Menunggu Konfirmasi,Sedang Diproses,Menunggu Kurir,Selesai',
        ]);

        $pemesanan->update($validated);
        return redirect()->route('pemesanans.index')
            ->with('success', 'Pemesanan berhasil diupdate!');
    }

    public function destroy(Pemesanan $pemesanan)
    {
        try {
            DB::beginTransaction();
            $pemesanan->detailPemesanans()->delete();
            $pemesanan->delete();
            DB::commit();
            return redirect()->route('pemesanans.index')
                ->with('success', 'Pemesanan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // ✅ METHOD BARU: Download PDF
    public function downloadPDF(Pemesanan $pemesanan)
    {
        $pemesanan->load(['pelanggan', 'jenisPembayaran', 'detailPemesanans.paket']);

        $pdf = Pdf::loadView('pemesanans.pdf', compact('pemesanan'))
                  ->setPaper('A4', 'portrait');

        return $pdf->download('Invoice-' . $pemesanan->no_resi . '.pdf');
    }
}
