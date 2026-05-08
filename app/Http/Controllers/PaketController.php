<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // ✅ WAJIB: Import base Controller
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pakets = Paket::latest()->paginate(10);
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
            'deskripsi' => 'required|string',
            'harga_paket' => 'required|numeric|min:0',
            'jumlah_pax' => 'required|integer|min:1',
            'jenis' => 'required|string|max:50',
            'kategori' => 'nullable|string|max:255',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'harga_paket.required' => 'Harga paket harus diisi',
            'harga_paket.numeric' => 'Harga harus berupa angka',
            'harga_paket.min' => 'Harga tidak boleh negatif',
        ]);

        // Handle file uploads
        $foto1 = $request->file('foto1') ? $request->file('foto1')->store('pakets', 'public') : null;
        $foto2 = $request->file('foto2') ? $request->file('foto2')->store('pakets', 'public') : null;
        $foto3 = $request->file('foto3') ? $request->file('foto3')->store('pakets', 'public') : null;

        // ✅ CAST TO INTEGER FOR POSTGRESQL COMPATIBILITY
        Paket::create([
            'nama_paket' => $validated['nama_paket'],
            'deskripsi' => $validated['deskripsi'],
            'harga_paket' => (int) $validated['harga_paket'],
            'jumlah_pax' => (int) $validated['jumlah_pax'],
            'jenis' => $validated['jenis'],
            'kategori' => $validated['kategori'],
            'foto1' => $foto1,
            'foto2' => $foto2,
            'foto3' => $foto3,
        ]);

        return redirect()->route('pakets.index')
            ->with('success', 'Paket catering berhasil ditambahkan!');
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
    public function edit(Paket $paket)
    {
        return view('pakets.edit', compact('paket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paket $paket)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_paket' => 'required|numeric|min:0',
            'jumlah_pax' => 'required|integer|min:1',
            'jenis' => 'required|string|max:50',
            'kategori' => 'nullable|string|max:255',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'harga_paket.required' => 'Harga paket harus diisi',
            'harga_paket.numeric' => 'Harga harus berupa angka',
        ]);

        // Handle file uploads
        $foto1 = $paket->foto1;
        $foto2 = $paket->foto2;
        $foto3 = $paket->foto3;

        if ($request->hasFile('foto1')) {
            if ($paket->foto1) Storage::disk('public')->delete($paket->foto1);
            $foto1 = $request->file('foto1')->store('pakets', 'public');
        }
        if ($request->hasFile('foto2')) {
            if ($paket->foto2) Storage::disk('public')->delete($paket->foto2);
            $foto2 = $request->file('foto2')->store('pakets', 'public');
        }
        if ($request->hasFile('foto3')) {
            if ($paket->foto3) Storage::disk('public')->delete($paket->foto3);
            $foto3 = $request->file('foto3')->store('pakets', 'public');
        }

        // ✅ CAST TO INTEGER FOR POSTGRESQL COMPATIBILITY
        $paket->update([
            'nama_paket' => $validated['nama_paket'],
            'deskripsi' => $validated['deskripsi'],
            'harga_paket' => (int) $validated['harga_paket'],
            'jumlah_pax' => (int) $validated['jumlah_pax'],
            'jenis' => $validated['jenis'],
            'kategori' => $validated['kategori'],
            'foto1' => $foto1,
            'foto2' => $foto2,
            'foto3' => $foto3,
        ]);

        return redirect()->route('pakets.index')
            ->with('success', 'Paket catering berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paket $paket)
    {
        if ($paket->foto1) Storage::disk('public')->delete($paket->foto1);
        if ($paket->foto2) Storage::disk('public')->delete($paket->foto2);
        if ($paket->foto3) Storage::disk('public')->delete($paket->foto3);

        $paket->delete();

        return redirect()->route('pakets.index')
            ->with('success', 'Paket catering berhasil dihapus!');
    }
}