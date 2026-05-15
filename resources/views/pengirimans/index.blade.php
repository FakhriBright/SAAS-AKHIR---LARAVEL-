@extends('layouts.admin')

@section('title', 'Pengiriman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Pengiriman</h4>
        <p class="text-muted mb-0">Monitoring status pengiriman kurir.</p>
    </div>
    {{-- HANYA ADMIN YANG BISA TAMBAH PENGIRIMAN --}}
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('pengirimans.create') }}" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-circle me-2"></i>Tambah Pengiriman
    </a>
    @endif
</div>

@if(auth()->user()->role === 'kurir')
<div class="alert alert-info">
    <i class="bi bi-info-circle me-2"></i>
    Tampilkan pesanan dengan status <strong>"Sedang Dikirim"</strong> yang siap diambil
</div>
@endif

<div class="card-modern p-4">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th class="ps-4">No. Resi</th>
                    <th>Pelanggan</th>
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
                        <a href="{{ route('pengirimans.show', $pengiriman->id) }}" class="text-primary fw-bold text-decoration-none">
                            {{ $pengiriman->pemesanan->no_resi ?? '-' }}
                        </a>
                    </td>
                    <td>{{ $pengiriman->pemesanan->pelanggan->nama_pelanggan ?? '-' }}</td>
                    <td>{{ $pengiriman->tgl_kirim ? $pengiriman->tgl_kirim->format('d/m/Y') : '-' }}</td>
                    <td>{{ $pengiriman->tgl_tiba ? $pengiriman->tgl_tiba->format('d/m/Y') : '-' }}</td>
                    <td>
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
                        @if(auth()->user()->role === 'kurir')
                            {{-- KURIR: Cuma bisa lihat detail & konfirmasi kalau status "Sedang Dikirim" --}}
                            @if($pengiriman->status_kirim === 'Sedang Dikirim')
                                <a href="{{ route('kurir.pengirimans.edit', $pengiriman->id) }}" class="btn btn-sm btn-success" title="Ambil & Konfirmasi">
                                    <i class="bi bi-check-circle"></i>
                                </a>
                            @endif
                            <a href="{{ route('kurir.pengirimans.show', $pengiriman->id) }}" class="btn btn-sm btn-light" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                        @else
                            {{-- ADMIN: Full akses --}}
                            <a href="{{ route('pengirimans.edit', $pengiriman->id) }}" class="btn btn-sm btn-light text-warning" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="{{ route('pengirimans.show', $pengiriman->id) }}" class="btn btn-sm btn-light text-primary" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                        @endif
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