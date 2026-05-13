<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Models\JenisPembayaran;
use App\Models\Paket;
use App\Models\DetailPemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemesanans = Pemesanan::with(['pelanggan', 'jenisPembayaran', 'detailPemesanans.paket'])
            ->latest()
            ->paginate(10);

        return view('pemesanans.index', compact('pemesanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ✅ Ambil data untuk dropdown
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();
        $jenisPembayarans = JenisPembayaran::all();
        $pakets = Paket::where('jenis', '!=', '')->orderBy('nama_paket')->get();

        return view('pemesanans.create', compact('pelanggans', 'jenisPembayarans', 'pakets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pelanggan'     => 'required|exists:pelanggans,id',
            'id_jenis_bayar'   => 'required|exists:jenis_pembayarans,id',
            'tgl_pesan'        => 'required|date|after_or_equal:today',
            'catatan'          => 'nullable|string|max:1000',
            'paket_id'         => 'required|array|min:1',
            'paket_id.*'       => 'required|exists:pakets,id',
            'jumlah'           => 'required|array|min:1',
            'jumlah.*'         => 'required|integer|min:1',
        ], [
            'paket_id.required' => 'Pilih minimal satu paket',
            'jumlah.required'   => 'Isi jumlah untuk setiap paket',
            'jumlah.*.min'      => 'Jumlah minimal 1',
        ]);

        try {
            DB::beginTransaction();

            // Generate No. Resi Unik
            $noResi = 'RESI-' . date('Ymd') . '-' . str_pad(Pemesanan::count() + 1, 4, '0', STR_PAD_LEFT);

            $totalBayar = 0;
            $detailData = [];

            // Hitung total & siapkan detail
            foreach ($validated['paket_id'] as $index => $paketId) {
                $paket = Paket::findOrFail($paketId);
                $qty   = $validated['jumlah'][$index] ?? 1;
                $subtotal = $paket->harga_paket * $qty;

                $totalBayar += $subtotal;

                $detailData[] = [
                    'paket_id'   => $paketId,
                    'jumlah'     => $qty,
                    'subtotal'   => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Simpan data utama pemesanan
            $pemesanan = Pemesanan::create([
                'id_pelanggan'   => $validated['id_pelanggan'],
                'id_jenis_bayar' => $validated['id_jenis_bayar'],
                'no_resi'        => $noResi,
                'tgl_pesan'      => $validated['tgl_pesan'],
                'status_pesan'   => 'Menunggu Konfirmasi',
                'total_bayar'    => $totalBayar,
                'catatan'        => $validated['catatan'] ?? null,
            ]);

            // Simpan detail paket
            foreach ($detailData as $detail) {
                $detail['pemesanan_id'] = $pemesanan->id;
                DetailPemesanan::create($detail);
            }

            DB::commit();

            return redirect()->route('pemesanans.index')
                ->with('success', '✅ Pesanan berhasil dibuat! No. Resi: ' . $noResi);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Create Order Failed: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemesanan $pemesanan)
    {
        $pemesanan->load(['pelanggan', 'jenisPembayaran', 'detailPemesanans.paket']);
        return view('pemesanans.show', compact('pemesanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemesanan $pemesanan)
    {
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();
        $jenisPembayarans = JenisPembayaran::all();
        $pakets = Paket::where('jenis', '!=', '')->orderBy('nama_paket')->get();
        $pemesanan->load('detailPemesanans');

        return view('pemesanans.edit', compact('pemesanan', 'pelanggans', 'jenisPembayarans', 'pakets'));
    }

    /**
     * Update the specified resource in storage.
     */
/**
 * Update the specified resource in storage.
 */
public function update(Request $request, Pemesanan $pemesanan)
{
    $validated = $request->validate([
        'id_pelanggan'   => 'required|exists:pelanggans,id',
        'id_jenis_bayar' => 'required|exists:jenis_pembayarans,id',
        'tgl_pesan'      => 'required|date',
        'status_pesan'   => 'required|string',
        'catatan'        => 'nullable|string|max:1000',
        'paket_id'       => 'required|array|min:1',
        'paket_id.*'     => 'required|exists:pakets,id',
        'jumlah'         => 'required|array|min:1',
        'jumlah.*'       => 'required|integer|min:1',
    ]);

    DB::beginTransaction();
    try {
        // Hitung ulang total
        $totalBayar = 0;
        
        // Update detail pemesanan
        $pemesanan->detailPemesanans()->delete(); // Hapus detail lama
        
        foreach ($validated['paket_id'] as $index => $paketId) {
            $paket = Paket::findOrFail($paketId);
            $qty = $validated['jumlah'][$index];
            $subtotal = $paket->harga_paket * $qty;
            $totalBayar += $subtotal;
            
            DetailPemesanan::create([
                'pemesanan_id' => $pemesanan->id,
                'paket_id'     => $paketId,
                'jumlah'       => $qty,
                'subtotal'     => $subtotal,
            ]);
        }
        
        // Update data utama
        $pemesanan->update([
            'id_pelanggan'   => $validated['id_pelanggan'],
            'id_jenis_bayar' => $validated['id_jenis_bayar'],
            'tgl_pesan'      => $validated['tgl_pesan'],
            'status_pesan'   => $validated['status_pesan'],
            'total_bayar'    => $totalBayar,
            'catatan'        => $validated['catatan'] ?? null,
        ]);
        
        DB::commit();
        
        // ✅ REDIRECT KE INDEX DENGAN PESAN SUKSES
        return redirect()->route('pemesanans.index')
            ->with('success', '✅ Pesanan ' . $pemesanan->no_resi . ' berhasil diupdate!');
            
    } catch (\Exception $e) {
        DB::rollBack();
        
        // ❌ KEMBALI KE FORM EDIT DENGAN ERROR
        return back()
            ->withInput()
            ->with('error', '❌ Gagal update: ' . $e->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemesanan $pemesanan)
    {
        DB::beginTransaction();
        try {
            $pemesanan->detailPemesanans()->delete();
            $pemesanan->delete();
            DB::commit();
            return back()->with('success', '✅ Pesanan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '❌ Gagal menghapus pesanan.');
        }
    }

    /**
     * Download PDF Invoice.
     */
    public function downloadPDF(Pemesanan $pemesanan)
    {
        $pemesanan->load(['pelanggan', 'jenisPembayaran', 'detailPemesanans.paket']);
        $pdf = Pdf::loadView('pemesanans.pdf', compact('pemesanan'));
        return $pdf->download('Invoice-' . $pemesanan->no_resi . '.pdf');
    }
}
