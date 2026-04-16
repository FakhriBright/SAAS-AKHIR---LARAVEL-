<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $data = Paket::all();
        return view('pakets.index', compact('data'));
    }

    public function create()
    {
        return view('pakets.create');
    }

    public function store(Request $r)
    {
        Paket::create($r->all());
        return redirect('/pakets');
    }

    public function edit($id)
    {
        $data = Paket::find($id);
        return view('pakets.edit', compact('data'));
    }

    public function update(Request $r, $id)
    {
        Paket::find($id)->update($r->all());
        return redirect('/pakets');
    }

    public function destroy($id)
    {
        Paket::destroy($id);
        return back();
    }
}
