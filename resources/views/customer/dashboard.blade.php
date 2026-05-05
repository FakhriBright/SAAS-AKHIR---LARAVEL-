@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container py-4">
    {{-- Welcome Message --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-muted mb-0">Kelola pesanan catering Anda dengan mudah</p>
                </div>
                <a href="{{ route('customer.order.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Pesanan Baru
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-cart-check text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Total Pesanan</p>
                            <h3 class="fw-bold mb-0">{{ $totalPesanan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-clock-history text-warning fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Pesanan Aktif</p>
                            <h3 class="fw-bold mb-0">{{ $pesananAktif }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-cash-coin text-success fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Total Belanja</p>
                            <h3 class="fw-bold mb-0">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile Info --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person"></i> Informasi Profil</h5>
                </div>
                <div class="card-body px-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong>Nama Lengkap:</strong></p>
                            <p class="text-muted">{{ $pelanggan->nama_pelanggan }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong>Email:</strong></p>
                            <p class="text-muted">{{ $pelanggan->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong>Nomor Telepon:</strong></p>
                            <p class="text-muted">{{ $pelanggan->telepon }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong>Alamat:</strong></p>
                            <p class="text-muted">
                                {{ $pelanggan->alamat1 }}
                                @if($pelanggan->alamat2), {{ $pelanggan->alamat2 }}@endif
                                @if($pelanggan->alamat3), {{ $pelanggan->alamat3 }}@endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history"></i> 5 Pesanan Terakhir</h5>
                    <a href="{{ route('customer.orders') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua Pesanan <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">No. Resi</th>
                                    <th>Tanggal Pesan</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $order->no_resi }}</td>
                                    <td>{{ $order->tgl_pesan->format('d/m/Y') }}</td>
                                    <td class="fw-bold text-primary">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->status_pesan == 'Menunggu Konfirmasi')
                                            <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                        @elseif($order->status_pesan == 'Sedang Diproses')
                                            <span class="badge bg-info text-dark">Sedang Diproses</span>
                                        @elseif($order->status_pesan == 'Menunggu Kurir')
                                            <span class="badge bg-secondary">Menunggu Kurir</span>
                                        @elseif($order->status_pesan == 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        @if($order && $order->id)
                                        <a href="{{ route('customer.order.detail', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        @else
                                        <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                        <p class="mb-0">Belum ada pesanan</p>
                                        <a href="{{ route('customer.order.create') }}" class="btn btn-sm btn-primary mt-3">
                                            <i class="bi bi-plus-circle"></i> Buat Pesanan Pertama
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
    </div>

    {{-- Quick Actions --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Menu Cepat</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('customer.catalog') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-grid d-block mb-2 fs-4"></i>
                                <span class="small">Lihat Katalog</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('customer.order.create') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="bi bi-cart-plus d-block mb-2 fs-4"></i>
                                <span class="small">Pesan Sekarang</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('customer.orders') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="bi bi-list-check d-block mb-2 fs-4"></i>
                                <span class="small">Riwayat Pesanan</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('logout') }}" class="btn btn-outline-danger w-100 py-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right d-block mb-2 fs-4"></i>
                                <span class="small">Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush
