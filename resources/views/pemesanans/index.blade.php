@extends('layouts.admin')

@section('title', 'Pemesanan')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Pemesanan</h4>
        <p class="text-muted mb-0">Kelola semua transaksi pemesanan.</p>
    </div>
</div>

<div class="card-modern p-4">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th class="ps-4">No. Resi</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemesanans as $order)
                <tr>
                    <td class="ps-4 fw-bold text-primary">{{ $order->no_resi }}</td>
                    <td>
                        <div class="fw-bold">{{ $order->pelanggan->nama_pelanggan ?? '-' }}</div>
                        <small class="text-muted">{{ $order->pelanggan->telepon ?? '' }}</small>
                    </td>
                    <td>{{ $order->tgl_pesan->format('d/m/Y') }}</td>
                    <td class="fw-bold text-success">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        @php
                        $statusClass = match($order->status_pesan) {
                            'Menunggu Konfirmasi' => 'warning',
                            'Sedang Diproses' => 'info',
                            'Menunggu Kurir' => 'secondary',
                            'Selesai' => 'success',
                            'Dibatalkan' => 'danger',
                            default => 'light'
                        };
                        @endphp
                        <span class="badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} px-3 py-2 rounded-pill">
                            {{ $order->status_pesan }}
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <a href="{{ route('pemesanans.show', $order->id) }}" class="btn btn-sm btn-light text-primary">
                            <i class="bi bi-eye me-1"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada pemesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection