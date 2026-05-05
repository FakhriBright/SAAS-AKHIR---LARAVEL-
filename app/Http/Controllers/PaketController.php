<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pakets = Paket::all();
        return view('pakets.index', compact('pakets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pakets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'jumlah_porsi' => 'required|integer|min:1',
            'kategori' => 'required|string|max:50',
        ], [
            'nama_paket.required' => 'Nama paket harus diisi',
            'harga.required' => 'Harga harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'jumlah_porsi.required' => 'Jumlah porsi harus diisi',
            'jumlah_porsi.integer' => 'Jumlah porsi harus angka',
            'kategori.required' => 'Kategori harus dipilih',
        ]);

        Paket::create($validated);

        return redirect()->route('pakets.index')
            ->with('success', 'Paket berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paket $paket)
    {
        return view('pakets.show', compact('paket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paket $paket)  // ✅ METHOD INI YANG MISSING!
    {
        return view('pakets.edit', compact('paket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paket $paket)  // ✅ METHOD INI JUGA!
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'jumlah_porsi' => 'required|integer|min:1',
            'kategori' => 'required|string|max:50',
        ]);

        $paket->update($validated);

        return redirect()->route('pakets.index')
            ->with('success', 'Paket berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paket $paket)
    {
        $paket->delete();
        return redirect()->route('pakets.index')
            ->with('success', 'Paket berhasil dihapus!');
    }
}
