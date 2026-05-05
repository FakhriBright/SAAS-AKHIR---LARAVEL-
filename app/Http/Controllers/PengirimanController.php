<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengirimans = Pengiriman::with(['pemesanan.pelanggan', 'user'])
                        ->latest()
                        ->get();

        return view('pengirimans.index', compact('pengirimans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan pesanan yang siap dikirim & belum punya data pengiriman
        $pemesanan = Pemesanan::with('pelanggan')
                    ->whereIn('status_pesan', ['Sedang Diproses', 'Menunggu Kurir'])
                    ->whereDoesntHave('pengiriman')
                    ->get();

        return view('pengirimans.create', compact('pemesanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id|unique:pengirimans,pemesanan_id',
            'tgl_kirim'    => 'required|date',
            'status_kirim' => 'required|in:Sedang Dikirim,Tiba Ditujuan',
            // Wajib foto jika status = Tiba Ditujuan, opsional jika Sedang Dikirim
            'bukti_foto'   => 'required_if:status_kirim,Tiba Ditujuan|image|max:2048',
        ], [
            'pemesanan_id.unique'  => 'Pesanan ini sudah memiliki data pengiriman.',
            'bukti_foto.required_if' => 'Foto bukti wajib diupload saat status "Tiba Ditujuan".',
            'bukti_foto.image'     => 'File harus berupa gambar (JPG, PNG, JPEG, GIF).',
            'bukti_foto.max'       => 'Ukuran foto maksimal 2MB.',
        ]);

        DB::beginTransaction();
        try {
            // Handle upload foto
            if ($request->hasFile('bukti_foto')) {
                $validated['bukti_foto'] = $request->file('bukti_foto')->store('bukti_pengiriman', 'public');
            }

            // Catat siapa yang input data
            $validated['id_user'] = Auth::id();

            // Simpan data pengiriman
            $pengiriman = Pengiriman::create($validated);

            // Update status pemesanan sesuai status kirim
            $newStatusPesan = $validated['status_kirim'] == 'Tiba Ditujuan' ? 'Selesai' : 'Menunggu Kurir';
            $pengiriman->pemesanan->update(['status_pesan' => $newStatusPesan]);

            DB::commit();

            return redirect()->route('pengirimans.index')
                ->with('success', 'Data pengiriman berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Pengiriman Store Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
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
        $pengiriman->load('pemesanan.pelanggan');
        $pemesanan = Pemesanan::with('pelanggan')->get();
        return view('pengirimans.edit', compact('pengiriman', 'pemesanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengiriman $pengiriman)
    {
        $validated = $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id|unique:pengirimans,pemesanan_id,' . $pengiriman->id,
            'tgl_kirim'    => 'required|date',
            'status_kirim' => 'required|in:Sedang Dikirim,Tiba Ditujuan',
            'bukti_foto'   => 'required_if:status_kirim,Tiba Ditujuan|image|max:2048',
        ], [
            'bukti_foto.required_if' => 'Foto bukti wajib diupload saat status "Tiba Ditujuan".',
            'bukti_foto.image'       => 'File harus berupa gambar (JPG, PNG, JPEG, GIF).',
            'bukti_foto.max'         => 'Ukuran foto maksimal 2MB.',
        ]);

        DB::beginTransaction();
        try {
            // Handle upload foto baru & hapus foto lama
            if ($request->hasFile('bukti_foto')) {
                if ($pengiriman->bukti_foto) {
                    Storage::disk('public')->delete($pengiriman->bukti_foto);
                }
                $validated['bukti_foto'] = $request->file('bukti_foto')->store('bukti_pengiriman', 'public');
            }

            // Catat siapa yang update data
            $validated['id_user'] = Auth::id();

            $pengiriman->update($validated);

            // Jika status berubah jadi Tiba Ditujuan, tutup pemesanan
            if ($validated['status_kirim'] == 'Tiba Ditujuan') {
                $pengiriman->pemesanan->update(['status_pesan' => 'Selesai']);
            }

            DB::commit();

            return redirect()->route('pengirimans.index')
                ->with('success', 'Data pengiriman berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Pengiriman Update Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengiriman $pengiriman)
    {
        try {
            DB::beginTransaction();

            // Hapus file foto jika ada
            if ($pengiriman->bukti_foto) {
                Storage::disk('public')->delete($pengiriman->bukti_foto);
            }

            $pengiriman->delete();
            DB::commit();

            return redirect()->route('pengirimans.index')
                ->with('success', 'Data pengiriman berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
