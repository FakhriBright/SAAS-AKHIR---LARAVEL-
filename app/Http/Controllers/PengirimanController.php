<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index()
    {
        $data = Pengiriman::with('pemesanan')->get();
        return view('pengirimans.index', compact('data'));
    }

    public function create()
    {
        $pemesanan = Pemesanan::all();
        return view('pengirimans.create', compact('pemesanan'));
    }

    public function store(Request $r)
    {
        Pengiriman::create($r->all());
        return redirect('/pengirimans');
    }

    public function edit($id)
    {
        $data = Pengiriman::find($id);
        $pemesanan = Pemesanan::all();

        return view('pengirimans.edit', compact('data','pemesanan'));
    }

    public function update(Request $r, $id)
    {
        Pengiriman::find($id)->update($r->all());
        return redirect('/pengirimans');
    }

    public function destroy($id)
    {
        Pengiriman::destroy($id);
        return back();
    }
}
