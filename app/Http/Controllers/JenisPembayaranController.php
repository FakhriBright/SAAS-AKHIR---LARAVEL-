<?php

namespace App\Http\Controllers;

use App\Models\JenisPembayaran;
use Illuminate\Http\Request;

class JenisPembayaranController extends Controller
{
    public function index()
    {
        $jenisPembayarans = JenisPembayaran::latest()->get();
        return view('jenis-pembayaran.index', compact('jenisPembayarans'));
    }

    public function create()
    {
        return view('jenis-pembayaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|string|max:255|unique:jenis_pembayarans,metode_pembayaran',
            'deskripsi' => 'nullable|string|max:500',
            // ✅ Field status dihapus
        ]);
        
        JenisPembayaran::create($validated);
        
        return redirect()->route('jenis-pembayaran.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function show(JenisPembayaran $jenisPembayaran)
    {
        return view('jenis-pembayaran.show', compact('jenisPembayaran'));
    }

    public function edit(JenisPembayaran $jenisPembayaran)
    {
        return view('jenis-pembayaran.edit', compact('jenisPembayaran'));
    }

    public function update(Request $request, JenisPembayaran $jenisPembayaran)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|string|max:255|unique:jenis_pembayarans,metode_pembayaran,' . $jenisPembayaran->id,
            'deskripsi' => 'nullable|string|max:500',
            // ✅ Field status dihapus
        ]);
        
        $jenisPembayaran->update($validated);
        
        return redirect()->route('jenis-pembayaran.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(JenisPembayaran $jenisPembayaran)
    {
        $jenisPembayaran->delete();
        
        return redirect()->route('jenis-pembayaran.index')
            ->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}