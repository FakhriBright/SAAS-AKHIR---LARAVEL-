<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'kurir') {
            $pengirimans = Pengiriman::with(['pemesanan.pelanggan'])
                ->where('status_kirim', 'Sedang Dikirim')
                ->latest()
                ->get();
        } else {
            $pengirimans = Pengiriman::with(['pemesanan.pelanggan'])->latest()->get();
        }
        
        return view('pengirimans.index', compact('pengirimans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pemesanans = Pemesanan::whereIn('status_pesan', ['Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir'])
            ->with('pelanggan')
            ->get();
        
        return view('pengirimans.create', compact('pemesanans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id|unique:pengirimans,pemesanan_id',
            'tgl_kirim' => 'required|date',
            'tgl_tiba' => 'nullable|date|after_or_equal:tgl_kirim',
            'status_kirim' => 'required|in:Menunggu Kurir,Sedang Dikirim',
        ]);

        DB::beginTransaction();
        try {
            $pengiriman = Pengiriman::create([
                'pemesanan_id' => $validated['pemesanan_id'],
                'id_user' => null,
                'tgl_kirim' => $validated['tgl_kirim'],
                'tgl_tiba' => $validated['tgl_tiba'] ?? null,
                'status_kirim' => $validated['status_kirim'],
            ]);

            $pemesanan = Pemesanan::findOrFail($validated['pemesanan_id']);
            $pemesanan->update(['status_pesan' => 'Sedang Diproses']);

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
     * Show the form for editing the specified resource (ADMIN).
     */
    public function edit(Pengiriman $pengiriman)
    {
        $pemesanans = Pemesanan::with('pelanggan')->get();
        return view('pengirimans.edit', compact('pengiriman', 'pemesanans'));
    }

    /**
     * Show the form for editing the specified resource (KURIR).
     */
    public function editKurir(Pengiriman $pengiriman)
    {
        return view('pengirimans.edit-kurir', compact('pengiriman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengiriman $pengiriman)
    {
        // KURIR UPDATE (Konfirmasi Selesai)
        if (auth()->user()->role === 'kurir') {
            $validated = $request->validate([
                'status_kirim' => 'required|in:Tiba Ditujuan',
                'bukti_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            
            DB::beginTransaction();
            try {
                if ($request->hasFile('bukti_foto')) {
                    if ($pengiriman->bukti_foto) {
                        Storage::disk('public')->delete($pengiriman->bukti_foto);
                    }
                    $validated['bukti_foto'] = $request->file('bukti_foto')->store('bukti_pengiriman', 'public');
                }
                
                $pengiriman->update([
                    'id_user' => auth()->id(),
                    'status_kirim' => 'Tiba Ditujuan',
                    'bukti_foto' => $validated['bukti_foto'] ?? $pengiriman->bukti_foto,
                    'tgl_tiba' => now(),
                ]);
                
                $pengiriman->pemesanan->update(['status_pesan' => 'Selesai']);
                
                DB::commit();
                return redirect()->route('kurir.pengirimans.index')
                    ->with('success', '✅ Pengiriman berhasil diselesaikan!');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', '❌ Gagal: ' . $e->getMessage());
            }
        }
        
        // ADMIN UPDATE
        $validated = $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id|unique:pengirimans,pemesanan_id,' . $pengiriman->id,
            'tgl_kirim' => 'required|date',
            'tgl_tiba' => 'nullable|date|after_or_equal:tgl_kirim',
            'status_kirim' => 'required|in:Menunggu Kurir,Sedang Dikirim',
        ]);

        DB::beginTransaction();
        try {
            $pengiriman->update([
                'pemesanan_id' => $validated['pemesanan_id'],
                'tgl_kirim' => $validated['tgl_kirim'],
                'tgl_tiba' => $validated['tgl_tiba'] ?? null,
                'status_kirim' => $validated['status_kirim'],
            ]);

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
                Storage::disk('public')->delete($pengiriman->bukti_foto);
            }
            $pengiriman->delete();
            return redirect()->route('pengirimans.index')
                ->with('success', '✅ Data pengiriman berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Gagal menghapus: ' . $e->getMessage());
        }
    }
}