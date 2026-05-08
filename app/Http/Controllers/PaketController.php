<?php

namespace App\Http\Controllers;

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
            'harga' => 'required|numeric|min:0',
            'jumlah_pax' => 'required|integer|min:1',
            'jenis' => 'required|in:Prasmanan,Meal Box,Snack Box,Tumpeng',
            'kategori' => 'nullable|string|max:255',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'jenis.in' => 'Jenis paket harus salah satu dari: Prasmanan, Meal Box, Snack Box, atau Tumpeng',
            'nama_paket.required' => 'Nama paket harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'harga.required' => 'Harga harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'jumlah_pax.required' => 'Jumlah pax harus diisi',
            'jumlah_pax.integer' => 'Jumlah pax harus berupa angka',
            'jumlah_pax.min' => 'Jumlah pax minimal 1',
        ]);

        // Handle file uploads
        $foto1 = $request->file('foto1') ? $request->file('foto1')->store('pakets', 'public') : null;
        $foto2 = $request->file('foto2') ? $request->file('foto2')->store('pakets', 'public') : null;
        $foto3 = $request->file('foto3') ? $request->file('foto3')->store('pakets', 'public') : null;

        Paket::create([
            'nama_paket' => $validated['nama_paket'],
            'deskripsi' => $validated['deskripsi'],
            'harga' => $validated['harga'],
            'jumlah_pax' => $validated['jumlah_pax'],
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
            'harga' => 'required|numeric|min:0',
            'jumlah_pax' => 'required|integer|min:1',
            'jenis' => 'required|in:Prasmanan,Meal Box,Snack Box,Tumpeng',
            'kategori' => 'nullable|string|max:255',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'jenis.in' => 'Jenis paket harus salah satu dari: Prasmanan, Meal Box, Snack Box, atau Tumpeng',
            'nama_paket.required' => 'Nama paket harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'harga.required' => 'Harga harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'jumlah_pax.required' => 'Jumlah pax harus diisi',
            'jumlah_pax.integer' => 'Jumlah pax harus berupa angka',
            'jumlah_pax.min' => 'Jumlah pax minimal 1',
        ]);

        // Handle file uploads - keep old files if no new upload
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

        $paket->update([
            'nama_paket' => $validated['nama_paket'],
            'deskripsi' => $validated['deskripsi'],
            'harga' => $validated['harga'],
            'jumlah_pax' => $validated['jumlah_pax'],
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
        // Delete photos
        if ($paket->foto1) Storage::disk('public')->delete($paket->foto1);
        if ($paket->foto2) Storage::disk('public')->delete($paket->foto2);
        if ($paket->foto3) Storage::disk('public')->delete($paket->foto3);

        $paket->delete();

        return redirect()->route('pakets.index')
            ->with('success', 'Paket catering berhasil dihapus!');
    }
}
