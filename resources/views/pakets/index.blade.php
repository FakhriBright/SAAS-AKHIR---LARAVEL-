@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Data Paket</h3>
    <a href="{{ route('pakets.create') }}" class="btn btn-primary">Tambah Paket</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Kategori</th>
            <th>Pax</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $d)
        <tr>
            <td>{{ $d->nama_paket }}</td>
            <td>{{ $d->jenis }}</td>
            <td>{{ $d->kategori }}</td>
            <td>{{ $d->jumlah_pax }}</td>
            <td>Rp {{ number_format($d->harga_paket,0,',','.') }}</td>
            <td>
                <a href="{{ route('pakets.edit',$d->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('pakets.destroy',$d->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
