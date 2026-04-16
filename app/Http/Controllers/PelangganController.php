<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index()
    {
        $data = Pelanggan::all();
        return view('pelanggans.index', compact('data'));
    }

    public function create()
    {
        return view('pelanggans.create');
    }

    public function store(Request $r)
    {
        $data = $r->all();
        $data['password'] = Hash::make($r->password);

        Pelanggan::create($data);
        return redirect('/pelanggans');
    }

    public function edit($id)
    {
        $data = Pelanggan::find($id);
        return view('pelanggans.edit', compact('data'));
    }

    public function update(Request $r, $id)
    {
        $data = $r->all();

        if ($r->password) {
            $data['password'] = Hash::make($r->password);
        } else {
            unset($data['password']);
        }

        Pelanggan::find($id)->update($data);
        return redirect('/pelanggans');
    }

    public function destroy($id)
    {
        Pelanggan::destroy($id);
        return back();
    }
}
