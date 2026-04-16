@extends('layouts.app')

@section('content')
<h3>Tambah Paket</h3>

<form method="POST" action="{{ route('pakets.store') }}">
@csrf

<div class="mb-2">
    <label>Nama Paket</label>
    <input name="nama_paket" class="form-control" required>
</div>

<div class="mb-2">
    <label>Jenis</label>
    <select name="jenis" class="form-control">
        <option>Prasmanan</option>
        <option>Box</option>
    </select>
</div>

<div class="mb-2">
    <label>Kategori</label>
    <select name="kategori" class="form-control">
        <option>Pernikahan</option>
        <option>Selamatan</option>
        <option>Ulang Tahun</option>
        <option>Rapat</option>
    </select>
</div>

<div class="mb-2">
    <label>Jumlah Pax</label>
    <input type="number" name="jumlah_pax" class="form-control">
</div>

<div class="mb-2">
    <label>Harga Paket</label>
    <input type="number" name="harga_paket" class="form-control">
</div>

<button class="btn btn-success">Simpan</button>
<a href="{{ route('pakets.index') }}" class="btn btn-secondary">Kembali</a>

</form>
@endsection
