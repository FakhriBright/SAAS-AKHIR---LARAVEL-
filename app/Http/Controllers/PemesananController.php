<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\Pelanggan;
use App\Models\Paket;
use App\Models\JenisPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::with(['pelanggan', 'jenisPembayaran'])
            ->latest()
            ->paginate(10);
        
        return view('pemesanans.index', compact('pemesanans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $pakets = Paket::all();
        $jenisPembayarans = JenisPembayaran::all();
        
        return view('pemesanans.create', compact('pelanggans', 'pakets', 'jenisPembayarans'));
    }

    public function store(Request $request)
    {
        // ✅ VALIDASI: Pastikan 'jumlah' ada dan valid
        $validated = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id',
            'id_jenis_bayar' => 'required|exists:jenis_pembayarans,id',
            'paket_id' => 'required|array|min:1',
            'paket_id.*' => 'exists:pakets,id',
            'jumlah' => 'required|array|min:1',      // ✅ WAJIB ADA
            'jumlah.*' => 'required|integer|min:1',   // ✅ WAJIB ADA
            'tgl_pesan' => 'required|date',
            'catatan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $totalBayar = 0;
            $details = [];

            // ✅ LOOP: Ambil paket DAN jumlah dengan index yang sama
            foreach ($validated['paket_id'] as $index => $paketId) {
                $paket = Paket::find($paketId);
                
                // ✅ AMBIL JUMLAH DARI ARRAY 'jumlah' DENGAN INDEX YANG SAMA
                $jumlah = $validated['jumlah'][$index] ?? 1;
                
                if ($paket) {
                    $subtotal = $paket->harga * $jumlah;
                    $totalBayar += $subtotal;
                    
                    // ✅ PASTIKAN 'jumlah' DIMASUKKAN KE ARRAY DETAIL
                    $details[] = [
                        'paket_id' => $paketId,
                        'jumlah' => $jumlah,    // ✅ INI YANG SERING TERLEWAT!
                        'subtotal' => $subtotal,
                    ];
                }
            }

            if ($totalBayar <= 0) {
                throw new \Exception("Total bayar tidak valid");
            }

            // Generate No. Resi
            $count = Pemesanan::count() + 1;
            $noResi = 'RESI-' . date('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            // Simpan Pemesanan
            $pemesanan = Pemesanan::create([
                'id_pelanggan' => $validated['id_pelanggan'],
                'id_jenis_bayar' => $validated['id_jenis_bayar'],
                'no_resi' => $noResi,
                'tgl_pesan' => $validated['tgl_pesan'],
                'status_pesan' => 'Menunggu Konfirmasi',
                'total_bayar' => $totalBayar,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            // ✅ SIMPAN DETAIL: Pastikan 'jumlah' ikut tersimpan
            foreach ($details as $detail) {
                $pemesanan->detailPemesanans()->create([
                    'paket_id' => $detail['paket_id'],
                    'jumlah' => $detail['jumlah'],  // ✅ PASTIKAN INI ADA
                    'subtotal' => $detail['subtotal'],
                ]);
            }

            DB::commit();

            return redirect()->route('pemesanans.index')
                ->with('success', 'Pesanan berhasil dibuat! No. Resi: ' . $noResi);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function show(Pemesanan $pemesanan)
    {
        $pemesanan->load(['pelanggan', 'jenisPembayaran', 'detailPemesanans.paket']);
        return view('pemesanans.show', compact('pemesanan'));
    }

    public function edit(Pemesanan $pemesanan)
    {
        $pelanggans = Pelanggan::all();
        $pakets = Paket::all();
        $jenisPembayarans = JenisPembayaran::all();
        $pemesanan->load('detailPemesanans');
        return view('pemesanans.edit', compact('pemesanan', 'pelanggans', 'pakets', 'jenisPembayarans'));
    }

    public function update(Request $request, Pemesanan $pemesanan)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id',
            'id_jenis_bayar' => 'required|exists:jenis_pembayarans,id',
            'paket_id' => 'required|array|min:1',
            'paket_id.*' => 'exists:pakets,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'tgl_pesan' => 'required|date',
            'catatan' => 'nullable|string|max:255',
            'status_pesan' => 'required|in:Menunggu Konfirmasi,Sedang Diproses,Menunggu Kurir,Selesai',
        ]);

        DB::beginTransaction();
        try {
            // Hapus detail lama
            $pemesanan->detailPemesanans()->delete();

            $totalBayar = 0;
            $details = [];

            foreach ($validated['paket_id'] as $index => $paketId) {
                $paket = Paket::find($paketId);
                $jumlah = $validated['jumlah'][$index] ?? 1;
                
                if ($paket) {
                    $subtotal = $paket->harga * $jumlah;
                    $totalBayar += $subtotal;
                    
                    $details[] = [
                        'paket_id' => $paketId,
                        'jumlah' => $jumlah,
                        'subtotal' => $subtotal,
                    ];
                }
            }

            if ($totalBayar <= 0) {
                throw new \Exception("Total bayar tidak valid");
            }

            $pemesanan->update([
                'id_pelanggan' => $validated['id_pelanggan'],
                'id_jenis_bayar' => $validated['id_jenis_bayar'],
                'tgl_pesan' => $validated['tgl_pesan'],
                'status_pesan' => $validated['status_pesan'],
                'total_bayar' => $totalBayar,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            foreach ($details as $detail) {
                $pemesanan->detailPemesanans()->create([
                    'paket_id' => $detail['paket_id'],
                    'jumlah' => $detail['jumlah'],
                    'subtotal' => $detail['subtotal'],
                ]);
            }

            DB::commit();
            return redirect()->route('pemesanans.index')->with('success', 'Pesanan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }

    public function destroy(Pemesanan $pemesanan)
    {
        $pemesanan->delete();
        return redirect()->route('pemesanans.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    public function downloadPDF(Pemesanan $pemesanan)
    {
        $pemesanan->load(['pelanggan', 'jenisPembayaran', 'detailPemesanans.paket']);
        $pdf = Pdf::loadView('pemesanans.pdf', compact('pemesanan'));
        return $pdf->download('Invoice-' . $pemesanan->no_resi . '.pdf');
    }
}