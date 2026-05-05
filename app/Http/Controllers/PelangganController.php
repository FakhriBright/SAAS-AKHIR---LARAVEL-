<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('pelanggans.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pelanggans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email',
            'telepon' => 'required|string|max:15',
            'tgl_lahir' => 'nullable|date',
            'alamat1' => 'required|string',
            'alamat2' => 'nullable|string',
            'alamat3' => 'nullable|string',
            'kartu_id' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'telepon.required' => 'Nomor telepon harus diisi',
            'alamat1.required' => 'Alamat harus diisi',
        ]);

        // Handle password
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            $validated['password'] = Hash::make('pelanggan123');
        }

        Pelanggan::create($validated);

        return redirect()->route('pelanggans.index')
            ->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggans.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email,' . $pelanggan->id,
            'telepon' => 'required|string|max:15',
            'tgl_lahir' => 'nullable|date',
            'alamat1' => 'required|string',
            'alamat2' => 'nullable|string',
            'alamat3' => 'nullable|string',
            'kartu_id' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8',
        ]);

        // Handle password
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $pelanggan->update($validated);

        return redirect()->route('pelanggans.index')
            ->with('success', 'Pelanggan berhasil diupdate!');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggans.index')
            ->with('success', 'Pelanggan berhasil dihapus!');
    }
}
