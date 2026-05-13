@extends('layouts.admin')

@section('title', 'Kelola Paket')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Kelola Paket</h4>
        <p class="text-muted mb-0">Manajemen katalog paket catering.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('pakets.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i>Tambah Paket
        </a>
    </div>
</div>

<div class="card-modern p-4">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Nama Paket</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Jumlah Pax</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pakets as $paket)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-2 text-primary">
                                <i class="bi bi-box-seam fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold">{{ $paket->nama_paket }}</div>
                                <small class="text-muted">{{ Str::limit($paket->deskripsi, 30) }}</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border px-3 py-2 rounded-pill">{{ $paket->kategori }}</span></td>
                    <td class="fw-bold text-success">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</td>
                    <td>{{ $paket->jumlah_pax }} Pax</td>
                    <td class="text-end pe-4">
                        <div class="btn-group">
                            <a href="{{ route('pakets.edit', $paket->id) }}" class="btn btn-sm btn-light text-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('pakets.destroy', $paket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data paket.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection