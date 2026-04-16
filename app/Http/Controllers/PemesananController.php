<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index()
    {
        $data = Pemesanan::with('pelanggan')->get();
        return view('pemesanans.index', compact('data'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        return view('pemesanans.create', compact('pelanggan'));
    }

    public function store(Request $r)
    {
        Pemesanan::create([
            'pelanggan_id' => $r->pelanggan_id,
            'tgl_pesan' => now(),
            'status' => 'Menunggu',
            'total_bayar' => $r->total_bayar
        ]);

        return redirect('/pemesanans');
    }

    public function edit($id)
    {
        $data = Pemesanan::find($id);
        $pelanggan = Pelanggan::all();

        return view('pemesanans.edit', compact('data','pelanggan'));
    }

    public function update(Request $r, $id)
    {
        Pemesanan::find($id)->update($r->all());
        return redirect('/pemesanans');
    }

    public function destroy($id)
    {
        Pemesanan::destroy($id);
        return back();
    }
}
