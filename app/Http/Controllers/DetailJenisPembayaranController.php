<?php

namespace App\Http\Controllers;

use App\Models\DetailJenisPembayaran;
use App\Models\JenisPembayaran;
use Illuminate\Http\Request;

class DetailJenisPembayaranController extends Controller
{
    public function index()
    {
        $detailPembayarans = DetailJenisPembayaran::with('jenisPembayaran')->latest()->get();
        return view('detail-jenis-pembayaran.index', compact('detailPembayarans'));
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
            'nomor_rekening' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:255',
            'bank' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle file upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }
        
        // ✅ Map field name dari form ke database
        DetailJenisPembayaran::create([
            'id_jenis_pembayaran' => $validated['id_jenis_pembayaran'],
            'no_rek' => $validated['nomor_rekening'],      // Map ke no_rek
            'tempat_bayar' => $validated['nama_pemilik'],  // Map ke tempat_bayar
            'bank' => $validated['bank'] ?? null,
            'logo' => $validated['logo'] ?? null,
        ]);
        
        return redirect()->route('detail-jenis-pembayaran.index')
            ->with('success', 'Detail pembayaran berhasil ditambahkan.');
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
            'nomor_rekening' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:255',
            'bank' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle file upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($detailJenisPembayaran->logo) {
                \Storage::disk('public')->delete($detailJenisPembayaran->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }
        
        // ✅ Map field name dari form ke database
        $detailJenisPembayaran->update([
            'id_jenis_pembayaran' => $validated['id_jenis_pembayaran'],
            'no_rek' => $validated['nomor_rekening'],      // Map ke no_rek
            'tempat_bayar' => $validated['nama_pemilik'],  // Map ke tempat_bayar
            'bank' => $validated['bank'] ?? null,
            'logo' => $validated['logo'] ?? null,
        ]);
        
        return redirect()->route('detail-jenis-pembayaran.index')
            ->with('success', 'Detail pembayaran berhasil diperbarui.');
    }

    public function destroy(DetailJenisPembayaran $detailJenisPembayaran)
    {
        // Delete logo if exists
        if ($detailJenisPembayaran->logo) {
            \Storage::disk('public')->delete($detailJenisPembayaran->logo);
        }
        
        $detailJenisPembayaran->delete();
        
        return redirect()->route('detail-jenis-pembayaran.index')
            ->with('success', 'Detail pembayaran berhasil dihapus.');
    }
}