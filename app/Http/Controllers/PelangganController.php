<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;  // ✅ TAMBAHKAN INI!

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('pelanggans.index', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pelanggans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // ✅ TAMBAHKAN VALIDASI FOTO
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'telepon.required' => 'Nomor telepon harus diisi',
            'alamat1.required' => 'Alamat harus diisi',
        ]);

        // Handle upload foto
        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('pelanggans', 'public');
        }

        // Handle password
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            $validated['password'] = Hash::make('pelanggan123'); // Default password
        }

        // Tambahkan foto ke data yang akan di-insert
        $validated['foto'] = $foto;

        Pelanggan::create($validated);

        return redirect()->route('pelanggans.index')
            ->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        return view('pelanggans.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggans.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'email' => 'required|email|unique:pelanggans,email,' . $pelanggan->id,
            'password' => 'nullable|min:6|confirmed',
            'telepon' => 'required|string|max:15',
            'alamat1' => 'required|string',
            'alamat2' => 'nullable|string|max:255',
            'alamat3' => 'nullable|string|max:100',
            'kartu_id' => 'nullable|string|max:16',
            'tgl_lahir' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload foto
        $foto = $pelanggan->foto;
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pelanggan->foto && Storage::disk('public')->exists($pelanggan->foto)) {
                Storage::disk('public')->delete($pelanggan->foto);
            }
            $foto = $request->file('foto')->store('pelanggans', 'public');
        }

        // Prepare data update
        $data = [
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'],
            'alamat1' => $validated['alamat1'],
            'alamat2' => $validated['alamat2'],
            'alamat3' => $validated['alamat3'],
            'kartu_id' => $validated['kartu_id'],
            'tgl_lahir' => $validated['tgl_lahir'],
            'foto' => $foto,
        ];

        // Update password hanya jika diisi
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $pelanggan->update($data);

        return redirect()->route('pelanggans.index')
            ->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        // Hapus foto dari storage jika ada
        if ($pelanggan->foto && Storage::disk('public')->exists($pelanggan->foto)) {
            Storage::disk('public')->delete($pelanggan->foto);
        }

        $pelanggan->delete();

        return redirect()->route('pelanggans.index')
            ->with('success', 'Pelanggan berhasil dihapus!');
    }
}
