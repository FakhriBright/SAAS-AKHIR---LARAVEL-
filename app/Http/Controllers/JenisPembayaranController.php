<?php

namespace App\Http\Controllers;

use App\Models\JenisPembayaran;
use Illuminate\Http\Request;

class JenisPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisPembayarans = JenisPembayaran::with('detailJenisPembayarans')->latest()->get();
        return view('jenis-pembayaran.index', compact('jenisPembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ✅ FIX: Ambil semua data dan kirim ke view
        $jenisPembayarans = JenisPembayaran::all();
        return view('jenis-pembayaran.create', compact('jenisPembayarans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|string|max:50|unique:jenis_pembayarans,metode_pembayaran',
        ]);

        JenisPembayaran::create($validated);

        return redirect()->route('jenis-pembayaran.index')
            ->with('success', 'Jenis pembayaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisPembayaran $jenisPembayaran)
    {
        return view('jenis-pembayaran.show', compact('jenisPembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPembayaran $jenisPembayaran)
    {
        return view('jenis-pembayaran.edit', compact('jenisPembayaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisPembayaran $jenisPembayaran)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|string|max:50|unique:jenis_pembayarans,metode_pembayaran,' . $jenisPembayaran->id,
        ]);

        $jenisPembayaran->update($validated);

        return redirect()->route('jenis-pembayaran.index')
            ->with('success', 'Jenis pembayaran berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisPembayaran $jenisPembayaran)
    {
        $jenisPembayaran->delete();
        return redirect()->route('jenis-pembayaran.index')
            ->with('success', 'Jenis pembayaran berhasil dihapus!');
    }
}
