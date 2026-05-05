<?php

namespace App\Http\Controllers;

use App\Models\DetailJenisPembayaran;
use App\Models\JenisPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailJenisPembayaranController extends Controller
{
    public function index()
    {
        $details = DetailJenisPembayaran::with('jenisPembayaran')->latest()->get();
        return view('detail-jenis-pembayaran.index', compact('details'));
    }

    public function create()
    {
        $jenisPembayarans = JenisPembayaran::all();
        return view('detail-jenis-pembayaran.create', compact('jenisPembayarans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_jenis_pembayaran' => 'required|exists:jenis_pembayarans,id',
            'no_rek' => 'nullable|string|max:30',
            'tempat_bayar' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle upload logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        DetailJenisPembayaran::create($validated);

        return redirect()->route('detail-jenis-pembayaran.index')
            ->with('success', 'Detail pembayaran berhasil ditambahkan!');
    }

    public function edit(DetailJenisPembayaran $detailJenisPembayaran)
    {
        $jenisPembayarans = JenisPembayaran::all();
        return view('detail-jenis-pembayaran.edit', compact('detailJenisPembayaran', 'jenisPembayarans'));
    }

    public function update(Request $request, DetailJenisPembayaran $detailJenisPembayaran)
    {
        $validated = $request->validate([
            'id_jenis_pembayaran' => 'required|exists:jenis_pembayarans,id',
            'no_rek' => 'nullable|string|max:30',
            'tempat_bayar' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle upload logo baru
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($detailJenisPembayaran->logo) {
                Storage::disk('public')->delete($detailJenisPembayaran->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $detailJenisPembayaran->update($validated);

        return redirect()->route('detail-jenis-pembayaran.index')
            ->with('success', 'Detail pembayaran berhasil diupdate!');
    }

    public function destroy(DetailJenisPembayaran $detailJenisPembayaran)
    {
        // Hapus file logo jika ada
        if ($detailJenisPembayaran->logo) {
            Storage::disk('public')->delete($detailJenisPembayaran->logo);
        }

        $detailJenisPembayaran->delete();
        return redirect()->route('detail-jenis-pembayaran.index')
            ->with('success', 'Detail pembayaran berhasil dihapus!');
    }
}
