@extends('layouts.app')

@section('content')
<h3>Edit Paket</h3>

<form method="POST" action="{{ route('pakets.update',$data->id) }}">
@csrf
@method('PUT')

<div class="mb-2">
    <label>Nama Paket</label>
    <input name="nama_paket" value="{{ $data->nama_paket }}" class="form-control">
</div>

<div class="mb-2">
    <label>Jenis</label>
    <select name="jenis" class="form-control">
        <option {{ $data->jenis=='Prasmanan'?'selected':'' }}>Prasmanan</option>
        <option {{ $data->jenis=='Box'?'selected':'' }}>Box</option>
    </select>
</div>

<div class="mb-2">
    <label>Kategori</label>
    <select name="kategori" class="form-control">
        <option {{ $data->kategori=='Pernikahan'?'selected':'' }}>Pernikahan</option>
        <option {{ $data->kategori=='Selamatan'?'selected':'' }}>Selamatan</option>
        <option {{ $data->kategori=='Ulang Tahun'?'selected':'' }}>Ulang Tahun</option>
        <option {{ $data->kategori=='Rapat'?'selected':'' }}>Rapat</option>
    </select>
</div>

<div class="mb-2">
    <label>Jumlah Pax</label>
    <input type="number" name="jumlah_pax" value="{{ $data->jumlah_pax }}" class="form-control">
</div>

<div class="mb-2">
    <label>Harga Paket</label>
    <input type="number" name="harga_paket" value="{{ $data->harga_paket }}" class="form-control">
</div>

<button class="btn btn-primary">Update</button>
<a href="{{ route('pakets.index') }}" class="btn btn-secondary">Kembali</a>

</form>
@endsection
