@extends('layouts.customer-nav')
@section('title', 'Pesanan Saya')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pesanan Saya</h2>
            <p class="text-muted mb-0">Kelola semua pesanan catering Anda</p>
        </div>
        <a href="{{ route('customer.catalog') }}" class="btn btn-fk-primary"><i class="bi bi-plus-circle me-2"></i>Pesan Baru</a>
    </div>

    @if($orders->count() > 0)
    <div class="card fk-card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">No. Resi</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="pe-4 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $order->no_resi }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->tgl_pesan)->format('d/m/Y') }}</td>
                        <td class="fw-bold text-success">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                        <td>
                            @php
                            $statusClass = match($order->status_pesan) {
                                'Menunggu Konfirmasi' => 'warning', 'Sedang Diproses' => 'info',
                                'Menunggu Kurir' => 'primary', 'Selesai' => 'success',
                                'Dibatalkan' => 'danger', default => 'secondary'
                            };
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">{{ $order->status_pesan }}</span>
                        </td>
                        <td class="pe-4 text-end">
                            <a href="{{ route('customer.order.show', $order->id) }}" class="btn btn-sm btn-fk-outline"><i class="bi bi-eye"></i> Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-0 py-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
        <h5 class="text-muted">Belum ada pesanan</h5>
        <p class="text-muted mb-4">Mulai pesan paket catering favorit Anda</p>
        <a href="{{ route('customer.catalog') }}" class="btn btn-fk-primary btn-lg"><i class="bi bi-plus-circle me-2"></i>Pesan Pertama</a>
    </div>
    @endif
</div>
@endsection