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
     * Helper: Ambil list kurir (users dengan role kurir atau semua users)
     */
    private function getKurirs()
    {
        // Kalau ada tabel 'kursors' pakai itu, kalau nggak pakai users
        if (Schema::hasTable('kursors')) {
            return \App\Models\Kurir::all();
        }
        // Ambil semua users (admin bisa filter manual siapa kurir)
        return User::all();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ✅ FIX: Pakai relasi 'user' bukan 'kurir'
        $pengirimans = Pengiriman::with(['pemesanan.pelanggan', 'user'])->latest()->get();
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
        // ✅ FIX: Pakai nama field sesuai database
        $validated = $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'id_user' => 'required|exists:users,id', // ✅ Ganti dari 'kurir_id'
            'tgl_kirim' => 'required|date', // ✅ Ganti dari 'tanggal_kirim'
            'tgl_tiba' => 'nullable|date|after_or_equal:tgl_kirim',
            'status_kirim' => 'required|in:Menunggu Kurir,Sedang Dikirim,Tiba Ditujuan', // ✅ Ganti dari 'status_pengiriman'
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Handle upload bukti foto
            if ($request->hasFile('bukti_foto')) {
                $validated['bukti_foto'] = $request->file('bukti_foto')->store('bukti_pengiriman', 'public');
            }

            // ✅ FIX: Pakai nama field yang sesuai model
            $pengiriman = Pengiriman::create([
                'pemesanan_id' => $validated['pemesanan_id'],
                'id_user' => $validated['id_user'],
                'tgl_kirim' => $validated['tgl_kirim'],
                'tgl_tiba' => $validated['tgl_tiba'] ?? null,
                'status_kirim' => $validated['status_kirim'],
                'bukti_foto' => $validated['bukti_foto'] ?? null,
            ]);

            // Update status pesanan
            $pemesanan = Pemesanan::findOrFail($validated['pemesanan_id']);
            $pemesanan->update([
                'status_pesan' => $validated['status_kirim'] === 'Tiba Ditujuan' ? 'Selesai' : 'Sedang Dikirim'
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
        $pengiriman->load(['pemesanan.pelanggan', 'pemesanan.detailPemesanans.paket', 'user']);
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
            'id_user' => 'required|exists:users,id',
            'tgl_kirim' => 'required|date',
            'tgl_tiba' => 'nullable|date|after_or_equal:tgl_kirim',
            'status_kirim' => 'required|in:Menunggu Kurir,Sedang Dikirim,Tiba Ditujuan',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Handle upload bukti foto
            if ($request->hasFile('bukti_foto')) {
                if ($pengiriman->bukti_foto) {
                    \Storage::disk('public')->delete($pengiriman->bukti_foto);
                }
                $validated['bukti_foto'] = $request->file('bukti_foto')->store('bukti_pengiriman', 'public');
            }

            $pengiriman->update([
                'pemesanan_id' => $validated['pemesanan_id'],
                'id_user' => $validated['id_user'],
                'tgl_kirim' => $validated['tgl_kirim'],
                'tgl_tiba' => $validated['tgl_tiba'] ?? null,
                'status_kirim' => $validated['status_kirim'],
                'bukti_foto' => $validated['bukti_foto'] ?? $pengiriman->bukti_foto,
            ]);

            // Sinkronisasi status pesanan
            $pemesanan = Pemesanan::find($validated['pemesanan_id']);
            if ($pemesanan) {
                $newOrderStatus = match($validated['status_kirim']) {
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
            if ($pengiriman->bukti_foto) {
                \Storage::disk('public')->delete($pengiriman->bukti_foto);
            }
            $pengiriman->delete();
            return redirect()->route('pengirimans.index')
                ->with('success', '✅ Data pengiriman berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Gagal menghapus: ' . $e->getMessage());
        }
    }
}