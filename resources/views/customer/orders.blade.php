@extends('layouts.customer')

@section('title', 'Pemesanan')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pemesanan</h2>
            <p class="text-muted mb-0">Kelola semua pesanan catering Anda</p>
        </div>
        <a href="{{ route('customer.order.create') }}" class="btn btn-fk-primary">
            <i class="bi bi-plus-circle me-2"></i>Buat Pesanan Baru
        </a>
    </div>

    @if($orders->count() > 0)
    <div class="card fk-card">
        <div class="card-body p-0">
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
                                    'Menunggu Konfirmasi' => 'warning',
                                    'Sedang Diproses' => 'info',
                                    'Menunggu Kurir' => 'primary',
                                    'Selesai' => 'success',
                                    'Dibatalkan' => 'danger',
                                    default => 'secondary'
                                };
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ $order->status_pesan }}</span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group">
                                    <a href="{{ route('customer.order.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    @if(in_array($order->status_pesan, ['Menunggu Konfirmasi']))
                                    <form action="{{ route('customer.order.cancel', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-x-circle"></i> Batalkan
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
        <h5 class="text-muted">Belum ada pesanan</h5>
        <p class="text-muted mb-4">Mulai pesan paket catering favorit Anda</p>
        <a href="{{ route('customer.order.create') }}" class="btn btn-fk-primary btn-lg">
            <i class="bi bi-plus-circle me-2"></i>Buat Pesanan Pertama
        </a>
    </div>
    @endif
</div>
@endsection
