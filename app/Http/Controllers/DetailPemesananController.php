<?php

namespace App\Http\Controllers;

use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use App\Models\Paket;
use Illuminate\Http\Request;

class DetailPemesananController extends Controller
{
    public function index()
    {
        $data = DetailPemesanan::with('paket')->get();
        return view('detail_pemesanans.index', compact('data'));
    }

    public function create()
    {
        $pemesanan = Pemesanan::all();
        $paket = Paket::all();

        return view('detail_pemesanans.create', compact('pemesanan','paket'));
    }

    public function store(Request $r)
    {
        DetailPemesanan::create($r->all());
        return redirect('/detail-pemesanans');
    }

    public function edit($id)
    {
        $data = DetailPemesanan::find($id);
        $pemesanan = Pemesanan::all();
        $paket = Paket::all();

        return view('detail_pemesanans.edit', compact('data','pemesanan','paket'));
    }

    public function update(Request $r, $id)
    {
        DetailPemesanan::find($id)->update($r->all());
        return redirect('/detail-pemesanans');
    }

    public function destroy($id)
    {
        DetailPemesanan::destroy($id);
        return back();
    }
}
