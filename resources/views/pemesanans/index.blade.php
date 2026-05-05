@extends('layouts.app')

@section('title', 'Data Pemesanan')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-cart"></i> Data Pemesanan</h2>
            <p class="text-muted mb-0">Kelola pemesanan catering</p>
        </div>
        <a href="{{ route('pemesanans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pemesanan
        </a>
    </div>

    {{-- Notifikasi Success --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Notifikasi Error --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Tabel Data --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="12%">No. Resi</th>
                            <th width="20%">Pelanggan</th>
                            <th width="18%">Paket</th>
                            <th width="12%">Tgl Pesan</th>
                            <th width="13%">Total Bayar</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemesanan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td><strong>{{ $p->no_resi ?? '-' }}</strong></td>

                            <td>
                                <div class="fw-semibold">{{ $p->pelanggan->nama_pelanggan ?? '-' }}</div>
                                <small class="text-muted">{{ $p->pelanggan->telepon ?? '' }}</small>
                            </td>

                            <td>
                                @forelse($p->detailPemesanans as $detail)
                                    <div>{{ $detail->paket->nama_paket ?? '-' }}</div>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </td>

                            <td>{{ $p->tgl_pesan?->format('d/m/Y') ?? '-' }}</td>

                            <td class="fw-bold text-primary">
                                Rp {{ number_format($p->total_bayar ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                @if($p->status_pesan == 'Menunggu Konfirmasi')
                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                @elseif($p->status_pesan == 'Sedang Diproses')
                                    <span class="badge bg-info text-dark">Sedang Diproses</span>
                                @elseif($p->status_pesan == 'Menunggu Kurir')
                                    <span class="badge bg-secondary">Menunggu Kurir</span>
                                @elseif($p->status_pesan == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-light text-dark">{{ $p->status_pesan ?? '-' }}</span>
                                @endif
                            </td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    {{-- ✅ Tombol Lihat Detail --}}
                                    <a href="{{ route('pemesanans.show', $p->id) }}"
                                       class="btn btn-info text-white"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('pemesanans.edit', $p->id) }}"
                                       class="btn btn-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Form Delete --}}
                                    <form action="{{ route('pemesanans.destroy', $p->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini?')">
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
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada data pemesanan</p>
                                <a href="{{ route('pemesanans.create') }}" class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-plus-circle"></i> Tambah Pemesanan
                                </a>
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
        background-color: #f8f9fa;
    }
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
    }
    .btn-group-sm .btn {
        padding: 0.25rem 0.4rem;
        font-size: 0.75rem;
    }
</style>
@endpush
