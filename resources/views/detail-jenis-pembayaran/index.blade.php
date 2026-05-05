@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-credit-card-2-front"></i> Detail Pembayaran</h2>
            <p class="text-muted mb-0">Kelola detail metode pembayaran</p>
        </div>
        <a href="{{ route('detail-jenis-pembayaran.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Detail
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
                            <th width="25%">Jenis Pembayaran</th>
                            <th width="20%">No. Rekening / Kode</th>
                            <th width="30%">Tempat / Instruksi</th>
                            <th width="10%">Logo</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($details as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $d->jenisPembayaran->metode_pembayaran ?? '-' }}</td>
                            <td>{{ $d->no_rek ?? '-' }}</td>
                            <td>{{ Str::limit($d->tempat_bayar, 40) ?? '-' }}</td>
                            <td>
                                @if($d->logo)
                                    <img src="{{ Storage::url($d->logo) }}" alt="Logo"
                                         class="img-thumbnail" style="max-width: 60px; max-height: 40px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('detail-jenis-pembayaran.edit', $d->id) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('detail-jenis-pembayaran.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada detail pembayaran</p>
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
