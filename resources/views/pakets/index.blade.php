@extends('layouts.app')

@section('title', 'Data Paket Catering')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-box-seam me-2"></i>Data Paket Catering</h2>
            <p class="text-muted mb-0">Kelola semua paket catering yang tersedia</p>
        </div>
        <a href="{{ route('pakets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Paket
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Paket</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th>Pax</th>
                            <th>Kategori</th>
                            <th class="text-center">Foto</th>
                            <th class="pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pakets as $index => $paket)
                        <tr>
                            <td class="ps-4">{{ $pakets->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $paket->nama_paket }}</strong>
                                <br><small class="text-muted">{{ Str::limit($paket->deskripsi, 50) }}</small>
                            </td>
                            <td><span class="badge bg-info">{{ $paket->jenis }}</span></td>
                            <td class="fw-bold text-success">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</td>
                            <td>{{ $paket->jumlah_pax }} Pax</td>
                            <td>{{ $paket->kategori ?? '-' }}</td>
                            <td class="text-center">
                                @if($paket->foto1)
                                    <img src="{{ asset('storage/' . $paket->foto1) }}" alt="Foto" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group">
                                    <a href="{{ route('pakets.edit', $paket->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('pakets.destroy', $paket->id) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada data paket
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($pakets->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $pakets->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection