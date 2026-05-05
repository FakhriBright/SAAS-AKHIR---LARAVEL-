@extends('layouts.app')

@section('title', 'Jenis Pembayaran')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-credit-card"></i> Jenis Pembayaran</h2>
            <p class="text-muted mb-0">Kelola metode pembayaran</p>
        </div>
        <a href="{{ route('jenis-pembayaran.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Jenis
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
                            <th width="40%">Metode Pembayaran</th>
                            <th width="25%">Jumlah Detail</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jenisPembayarans as $jp)  {{-- ✅ GUNAKAN $jenisPembayarans --}}
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $jp->metode_pembayaran }}</td>
                            <td>
                                {{-- ✅ AKSES RELASI detailJenisPembayarans --}}
                                <span class="badge bg-info">
                                    {{ $jp->detailJenisPembayarans->count() }} detail
                                </span>
                                @if($jp->detailJenisPembayarans->count() > 0)
                                    <small class="text-muted d-block mt-1">
                                        @foreach($jp->detailJenisPembayarans->take(2) as $detail)
                                            {{ $detail->no_rek ?: 'Tanpa No. Rek' }}@if(!$loop->last), @endif
                                        @endforeach
                                        @if($jp->detailJenisPembayarans->count() > 2)
                                            <span class="text-muted">+{{ $jp->detailJenisPembayarans->count() - 2 }} lainnya</span>
                                        @endif
                                    </small>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('jenis-pembayaran.edit', $jp->id) }}"
                                       class="btn btn-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="{{ route('detail-jenis-pembayaran.create') }}?jenis={{ $jp->id }}"
                                       class="btn btn-success"
                                       title="Tambah Detail">
                                        <i class="bi bi-plus-circle"></i>
                                    </a>
                                    <form action="{{ route('jenis-pembayaran.destroy', $jp->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
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
                            <td colspan="4" class="text-center py-4">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada data jenis pembayaran</p>
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
