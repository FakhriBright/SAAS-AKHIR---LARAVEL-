@extends('layouts.admin')

@section('title', 'Pengiriman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Pengiriman</h4>
        <p class="text-muted mb-0">Monitoring status pengiriman kurir.</p>
    </div>
    <a href="{{ route('pengirimans.create') }}" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-circle me-2"></i>Tambah Pengiriman
    </a>
</div>

<div class="card-modern p-4">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Kurir</th>
                    <th>No. Resi</th>
                    <th>Tgl Kirim</th>
                    <th>Tgl Tiba</th>
                    <th>Status</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengirimans as $pengiriman)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-light rounded-circle p-2">
                                <i class="bi bi-person text-dark"></i>
                            </div>
                            {{-- ✅ FIX: Pakai relasi 'user' --}}
                            <span class="fw-bold">{{ $pengiriman->user->name ?? $pengiriman->user->nama_pelanggan ?? '-' }}</span>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('pemesanans.show', $pengiriman->pemesanan->id) }}" class="text-primary fw-bold text-decoration-none">
                            {{ $pengiriman->pemesanan->no_resi ?? '-' }}
                        </a>
                    </td>
                    {{-- ✅ FIX: Pakai field 'tgl_kirim' dan 'tgl_tiba' --}}
                    <td>{{ $pengiriman->tgl_kirim ? $pengiriman->tgl_kirim->format('d/m/Y') : '-' }}</td>
                    <td>{{ $pengiriman->tgl_tiba ? $pengiriman->tgl_tiba->format('d/m/Y') : '-' }}</td>
                    <td>
                        {{-- ✅ FIX: Pakai field 'status_kirim' --}}
                        @php
                            $statusClass = match($pengiriman->status_kirim) {
                                'Menunggu Kurir' => 'secondary',
                                'Sedang Dikirim' => 'primary',
                                'Tiba Ditujuan' => 'success',
                                default => 'light'
                            };
                        @endphp
                        <span class="badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} px-2 py-1 rounded-pill small">
                            {{ $pengiriman->status_kirim }}
                        </span>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="btn-group">
                            <a href="{{ route('pengirimans.edit', $pengiriman->id) }}" class="btn btn-sm btn-light text-warning"><i class="bi bi-pencil-fill"></i></a>
                            <a href="{{ route('pengirimans.show', $pengiriman->id) }}" class="btn btn-sm btn-light text-primary"><i class="bi bi-eye"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data pengiriman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection