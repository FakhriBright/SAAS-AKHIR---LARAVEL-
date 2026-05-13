<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PengirimanController extends Controller
{
    /**
     * Helper: Ambil list kurir
     */
    private function getKurirs()
    {
        if (class_exists('App\Models\Kurir') || (Schema::hasTable('kursors'))) {
            return \App\Models\Kurir::all();
        }
        return User::all();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengirimans = Pengiriman::with(['pemesanan.pelanggan'])->latest()->get();
        return view('pengirimans.index', compact('pengirimans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pemesanans = Pemesanan::whereIn('status_pesan', ['Menunggu Kurir', 'Sedang Diproses', 'Menunggu Konfirmasi'])
            ->with('pelanggan')
            ->get();
        $kurirs = $this->getKurirs();
        
        return view('pengirimans.create', compact('pemesanans', 'kurirs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ FIX: Ganti 'id_pemesanan' jadi 'pemesanan_id' (sesuai kolom database)
        $validated = $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id', // ✅ Hapus unique kalau nggak perlu
            'kurir_id' => 'required|exists:users,id', // ✅ Ganti 'id_kurir' jadi 'kurir_id'
            'tanggal_kirim' => 'required|date',
            'status_pengiriman' => 'required|in:Menunggu Kurir,Sedang Dikirim,Tiba Ditujuan',
            'tanggal_tiba' => 'nullable|date|after_or_equal:tanggal_kirim',
        ]);

        DB::beginTransaction();
        try {
            // ✅ FIX: Pakai nama field yang sesuai database
            $pengiriman = Pengiriman::create([
                'pemesanan_id' => $validated['pemesanan_id'],
                'kurir_id' => $validated['kurir_id'],
                'tanggal_kirim' => $validated['tanggal_kirim'],
                'tanggal_tiba' => $validated['tanggal_tiba'] ?? null,
                'status_pengiriman' => $validated['status_pengiriman'],
            ]);

            // Update status pesanan
            $pemesanan = Pemesanan::findOrFail($validated['pemesanan_id']);
            $pemesanan->update([
                'status_pesan' => $validated['status_pengiriman'] === 'Tiba Ditujuan' ? 'Selesai' : 'Sedang Dikirim'
            ]);

            DB::commit();
            return redirect()->route('pengirimans.index')
                ->with('success', '✅ Data pengiriman berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', '❌ Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengiriman $pengiriman)
    {
        $pengiriman->load(['pemesanan.pelanggan', 'pemesanan.detailPemesanans.paket']);
        return view('pengirimans.show', compact('pengiriman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengiriman $pengiriman)
    {
        $pemesanans = Pemesanan::with('pelanggan')->get();
        $kurirs = $this->getKurirs();
        
        return view('pengirimans.edit', compact('pengiriman', 'pemesanans', 'kurirs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengiriman $pengiriman)
    {
        $validated = $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'kurir_id' => 'required|exists:users,id',
            'tanggal_kirim' => 'required|date',
            'tanggal_tiba' => 'nullable|date|after_or_equal:tanggal_kirim',
            'status_pengiriman' => 'required|in:Menunggu Kurir,Sedang Dikirim,Tiba Ditujuan',
        ]);

        DB::beginTransaction();
        try {
            $pengiriman->update([
                'pemesanan_id' => $validated['pemesanan_id'],
                'kurir_id' => $validated['kurir_id'],
                'tanggal_kirim' => $validated['tanggal_kirim'],
                'tanggal_tiba' => $validated['tanggal_tiba'] ?? null,
                'status_pengiriman' => $validated['status_pengiriman'],
            ]);

            // Sinkronisasi status pesanan
            $pemesanan = Pemesanan::find($validated['pemesanan_id']);
            if ($pemesanan) {
                $newOrderStatus = match($validated['status_pengiriman']) {
                    'Menunggu Kurir' => 'Menunggu Kurir',
                    'Sedang Dikirim' => 'Sedang Dikirim',
                    'Tiba Ditujuan' => 'Selesai',
                    default => $pemesanan->status_pesan
                };
                $pemesanan->update(['status_pesan' => $newOrderStatus]);
            }

            DB::commit();
            return redirect()->route('pengirimans.index')
                ->with('success', '✅ Data pengiriman berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', '❌ Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengiriman $pengiriman)
    {
        try {
            $pengiriman->delete();
            return redirect()->route('pengirimans.index')
                ->with('success', '✅ Data pengiriman berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Gagal menghapus: ' . $e->getMessage());
        }
    }
}