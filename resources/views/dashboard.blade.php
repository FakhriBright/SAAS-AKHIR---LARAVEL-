@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid py-4">
    {{-- Welcome Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Dashboard Admin 📊</h2>
                    <p class="text-muted mb-0">Selamat datang, {{ $user->name }}! Berikut ringkasan bisnis catering Anda.</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">{{ now()->format('l, d F Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards Row 1 --}}
    <div class="row g-4 mb-4">
        {{-- Total Pesanan --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Pesanan</p>
                            <h3 class="fw-bold mb-0">{{ number_format($totalPesanan) }}</h3>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> {{ $pesananHariIni }} hari ini</small>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-cart-check text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pendapatan Total --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Pendapatan Total</p>
                            <h3 class="fw-bold mb-0 text-success">Rp {{ number_format($pendapatanTotal, 0, ',', '.') }}</h3>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }} hari ini</small>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-cash-coin text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Pelanggan --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Pelanggan</p>
                            <h3 class="fw-bold mb-0">{{ number_format($totalPelanggan) }}</h3>
                            <small class="text-muted">Terdaftar</small>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Paket --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Paket</p>
                            <h3 class="fw-bold mb-0">{{ number_format($totalPaket) }}</h3>
                            <small class="text-muted">Tersedia</small>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-box-seam text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards Row 2 - Status Pesanan --}}
    <div class="row g-4 mb-4">
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-3">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-2 d-inline-block mb-2">
                        <i class="bi bi-hourglass-split text-warning fs-5"></i>
                    </div>
                    <h4 class="fw-bold mb-0">{{ $menungguKonfirmasi }}</h4>
                    <small class="text-muted d-block">Menunggu Konfirmasi</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-3">
                    <div class="bg-info bg-opacity-10 rounded-circle p-2 d-inline-block mb-2">
                        <i class="bi bi-gear text-info fs-5"></i>
                    </div>
                    <h4 class="fw-bold mb-0">{{ $sedangDiproses }}</h4>
                    <small class="text-muted d-block">Sedang Diproses</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-3">
                    <div class="bg-secondary bg-opacity-10 rounded-circle p-2 d-inline-block mb-2">
                        <i class="bi bi-truck text-secondary fs-5"></i>
                    </div>
                    <h4 class="fw-bold mb-0">{{ $menungguKurir }}</h4>
                    <small class="text-muted d-block">Menunggu Kurir</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-3">
                    <div class="bg-success bg-opacity-10 rounded-circle p-2 d-inline-block mb-2">
                        <i class="bi bi-check-circle text-success fs-5"></i>
                    </div>
                    <h4 class="fw-bold mb-0">{{ $selesai }}</h4>
                    <small class="text-muted d-block">Selesai</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-3">
                    <div class="bg-danger bg-opacity-10 rounded-circle p-2 d-inline-block mb-2">
                        <i class="bi bi-x-circle text-danger fs-5"></i>
                    </div>
                    <h4 class="fw-bold mb-0">{{ $dibatalkan }}</h4>
                    <small class="text-muted d-block">Dibatalkan</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 d-inline-block mb-2">
                        <i class="bi bi-calendar-check text-primary fs-5"></i>
                    </div>
                    <h4 class="fw-bold mb-0">{{ $pesananBulanIni }}</h4>
                    <small class="text-muted d-block">Bulan Ini</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts & Recent Orders Row --}}
    <div class="row g-4">
        {{-- Chart: Pesanan 7 Hari Terakhir --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-graph-up"></i> Grafik Pesanan 7 Hari Terakhir</h5>
                </div>
                <div class="card-body px-4">
                    <canvas id="ordersChart" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- Chart: Status Pesanan (Pie) --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pie-chart"></i> Distribusi Status</h5>
                </div>
                <div class="card-body px-4">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders Table --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history"></i> 10 Pesanan Terbaru</h5>
                    <a href="{{ route('pemesanans.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">No. Resi</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $order->no_resi }}</td>
                                    <td>{{ $order->tgl_pesan->format('d/m/Y') }}</td>
                                    <td>
                                        <strong>{{ $order->pelanggan->nama_pelanggan ?? '-' }}</strong><br>
                                        <small class="text-muted">{{ $order->pelanggan->telepon ?? '' }}</small>
                                    </td>
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
                                        @elseif($order->status_pesan == 'Dibatalkan')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('pemesanans.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                        Belum ada pesanan
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
</div>
@endsection

@push('scripts')
{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Chart: Pesanan 7 Hari Terakhir
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($last7Days->pluck('label')) !!},
            datasets: [{
                label: 'Jumlah Pesanan',
                data: {!! json_encode($last7Days->pluck('count')) !!},
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#0d6efd',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Chart: Status Pesanan (Pie)
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusData['labels']) !!},
            datasets: [{
                data: {!! json_encode($statusData['data']) !!},
                backgroundColor: {!! json_encode($statusData['colors']) !!},
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                }
            }
        }
    });
</script>
@endpush

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
