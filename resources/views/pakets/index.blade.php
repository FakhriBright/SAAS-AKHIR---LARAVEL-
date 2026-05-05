@extends('layouts.app')

@section('title', 'Daftar Paket')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-gift"></i> Daftar Paket</h2>
            <p class="text-muted mb-0">Kelola paket catering</p>
        </div>
        <a href="{{ route('pakets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Paket
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Paket</th>
                            <th width="20%">Deskripsi</th>
                            <th width="15%">Harga</th>
                            <th width="10%">Jumlah Porsi</th>
                            <th width="15%">Kategori</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pakets as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $p->nama_paket }}</td>
                            <td>{{ Str::limit($p->deskripsi, 40) ?? '-' }}</td>
                            <td class="fw-bold text-primary">
                                Rp {{ number_format($p->harga, 0, ',', '.') }}
                            </td>
                            <td>{{ $p->jumlah_porsi }} porsi</td>
                            <td>
                                <span class="badge bg-info">{{ $p->kategori }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('pakets.edit', $p->id) }}"
                                       class="btn btn-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('pakets.destroy', $p->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada data paket</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
    }
</style>
@endpush
