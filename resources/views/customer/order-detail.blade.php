@extends('layouts.app')

@section('title', 'Detail Pesanan #{{ $order->no_resi }}')

@section('content')
<div class="container py-5">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Pesanan</h2>
            <p class="text-muted mb-0">No. Resi: <span class="fw-bold text-primary">{{ $order->no_resi }}</span></p>
        </div>
        <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    {{-- Status Banner --}}
    @php
    $statusConfig = [
        'Menunggu Konfirmasi' => ['class' => 'warning', 'icon' => 'bi-hourglass-split', 'desc' => 'Pesanan sedang menunggu konfirmasi admin'],
        'Sedang Diproses' => ['class' => 'info', 'icon' => 'bi-gear', 'desc' => 'Pesanan sedang disiapkan oleh dapur kami'],
        'Menunggu Kurir' => ['class' => 'primary', 'icon' => 'bi-truck', 'desc' => 'Pesanan siap diantar, menunggu kurir'],
        'Selesai' => ['class' => 'success', 'icon' => 'bi-check-circle', 'desc' => 'Pesanan telah selesai dan diterima'],
        'Dibatalkan' => ['class' => 'danger', 'icon' => 'bi-x-circle', 'desc' => 'Pesanan telah dibatalkan'],
    ];
    $config = $statusConfig[$order->status_pesan] ?? $statusConfig['Menunggu Konfirmasi'];
    @endphp
    <div class="alert alert-{{ $config['class'] }} d-flex align-items-center mb-4" role="alert">
        <i class="bi {{ $config['icon'] }} fs-4 me-3"></i>
        <div>
            <h6 class="alert-heading fw-bold mb-0">{{ $order->status_pesan }}</h6>
            <small>{{ $config['desc'] }}</small>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left: Order Details --}}
        <div class="col-lg-8">
            {{-- Order Info Card --}}
            <div class="card-modern p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Pesanan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Tanggal Pesan</small>
                        <span class="fw-bold">{{ $order->tgl_pesan->format('d F Y') }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Metode Pembayaran</small>
                        <span class="fw-bold">{{ $order->jenisPembayaran->metode_pembayaran ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Catatan</small>
                        <span>{{ $order->catatan ?? 'Tidak ada' }}</span>
                    </div>
                </div>
            </div>

            {{-- Items Card --}}
            <div class="card-modern p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-cart3 me-2"></i>Item Pesanan</h5>
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th>Paket</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->detailPemesanans as $detail)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $detail->paket->nama_paket ?? 'Paket Tidak Ditemukan' }}</div>
                                    <small class="text-muted">{{ $detail->paket->kategori ?? '-' }}</small>
                                </td>
                                <td class="text-center">{{ $detail->jumlah }}</td>
                                <td class="text-end">Rp {{ number_format($detail->paket->harga_paket ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Delivery Info (if exists) --}}
            @if($order->pengiriman)
            <div class="card-modern p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-truck me-2"></i>Informasi Pengiriman</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Kurir</small>
                        <span class="fw-bold">{{ $order->pengiriman->user->name ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Tanggal Kirim</small>
                        <span>{{ $order->pengiriman->tgl_kirim?->format('d/m/Y H:i') ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Estimasi Tiba</small>
                        <span>{{ $order->pengiriman->tgl_tiba?->format('d/m/Y H:i') ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Status Kirim</small>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">
                            {{ $order->pengiriman->status_kirim }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Right: Summary --}}
        <div class="col-lg-4">
            <div class="card-modern p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-3">Ringkasan Pembayaran</h5>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Pajak & Ongkir</span>
                    <span class="text-success">Gratis</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fs-5 fw-bold">Total</span>
                    <span class="fs-4 fw-bold text-primary">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                </div>

                {{-- Action Buttons --}}
                <div class="d-grid gap-2">
                    @if($order->status_pesan == 'Menunggu Konfirmasi')
                    <form action="{{ route('customer.order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger w-100 rounded-pill">
                            <i class="bi bi-x-circle me-2"></i>Batalkan Pesanan
                        </button>
                    </form>
                    @endif
                    
                    @if($order->status_pesan == 'Selesai')
                    <button class="btn btn-success w-100 rounded-pill" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i>Cetak Struk
                    </button>
                    @endif
                    
                    <a href="https://wa.me/6285842517974?text=Halo%20Fakhri%20Kitchen,%20saya%20mau%20tanya%20tentang%20pesanan%20{{ $order->no_resi }}" 
                       class="btn btn-outline-success w-100 rounded-pill" target="_blank">
                        <i class="bi bi-whatsapp me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSS Tambahan --}}
@push('styles')
<style>
    .card-modern { background: white; border: none; border-radius: 20px; box-shadow: 0 5px 20px rgba(112, 144, 176, 0.08); }
    .table-modern { margin-bottom: 0; }
    .table-modern thead th { background: #f8f9fa; color: #a3aed0; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; padding: 1rem; border: none; }
    .table-modern tbody td { padding: 1rem; vertical-align: middle; color: #2b3674; font-weight: 500; border-bottom: 1px solid #f0f2f5; }
    .table-modern tbody tr:last-child td { border-bottom: none; }
    @media print {
        .no-print { display: none !important; }
        .card-modern { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>
@endpush
@endsection