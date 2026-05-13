@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    /* --- LAYOUT FIX: Grafik Rapih & Penuh --- */
    .chart-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        padding: 24px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .chart-card h6 { 
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0f2f5;
    }
    .chart-wrapper {
        flex: 1;
        position: relative;
        min-height: 350px; /* Tinggi minimal biar gak gepeng */
    }
    
    /* --- TOP SELLING LIST --- */
    .top-selling-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .top-selling-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: white;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #f0f2f5;
        transition: 0.3s;
    }
    .top-selling-item:hover {
        border-color: #2d6a4f;
        background: #f9fbfd;
    }
    .rank-badge {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #e9ecef;
        color: #666;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        margin-right: 12px;
        flex-shrink: 0;
    }
    .rank-1 { background: #ffd700; color: #fff; box-shadow: 0 2px 8px rgba(255,215,0,0.3); }
    .rank-2 { background: #c0c0c0; color: #fff; }
    .rank-3 { background: #cd7f32; color: #fff; }
    
    .item-info { flex: 1; }
    .item-name { font-weight: 600; font-size: 0.95rem; color: #333; }
    .item-sold { font-size: 0.8rem; color: #888; }
    .item-qty { font-weight: 700; color: #2d6a4f; font-size: 0.95rem; }
    
    /* --- DOWNLOAD BUTTON STYLES --- */
    .btn-download {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-download:hover {
        background: #b02a37;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220,53,69,0.3);
    }
</style>

{{-- ROW 1: STATS CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card-modern p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small fw-bold">Total Pendapatan</p>
                    <h4 class="fw-bold mb-0 text-success">Rp {{ number_format($pendapatanTotal ?? 0, 0, ',', '.') }}</h4>
                    <small class="text-success"><i class="bi bi-arrow-up-short"></i> Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }} hari ini</small>
                </div>
                <div class="bg-success bg-opacity-10 rounded-3 p-2">
                    <i class="bi bi-wallet2 text-success fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-modern p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small fw-bold">Total Pesanan</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalPesanan ?? 0) }}</h4>
                    <small class="text-success"><i class="bi bi-arrow-up-short"></i> {{ $pesananHariIni ?? 0 }} hari ini</small>
                </div>
                <div class="bg-primary bg-opacity-10 rounded-3 p-2">
                    <i class="bi bi-cart-check text-primary fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-modern p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small fw-bold">Pelanggan</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalPelanggan ?? 0) }}</h4>
                    <small class="text-muted">Terdaftar</small>
                </div>
                <div class="bg-info bg-opacity-10 rounded-3 p-2">
                    <i class="bi bi-people text-info fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-modern p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small fw-bold">Total Paket</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalPaket ?? 0) }}</h4>
                    <small class="text-muted">Tersedia</small>
                </div>
                <div class="bg-warning bg-opacity-10 rounded-3 p-2">
                    <i class="bi bi-box-seam text-warning fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ROW 2: CHARTS & TOP SELLING --}}
<div class="row g-3 mb-4">
    {{-- LEFT: Line Chart --}}
    <div class="col-xl-8">
        <div class="chart-card">
            <h6 class="fw-bold mb-0"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>Jumlah Pesanan Bulan Ini</h6>
            <div class="chart-wrapper">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    {{-- RIGHT: Top 3 Selling & Donut --}}
    <div class="col-xl-4 d-flex flex-column gap-3">
        
        {{-- TOP 3 PAKET TERLARIS --}}
        <div class="card-modern p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-trophy me-2 text-warning"></i>Top 3 Paket Terlaris</h6>
            
            <div class="top-selling-list">
                @forelse($topPackages as $index => $item)
                @if($index < 3) {{-- Hanya tampilkan 3 teratas --}}
                <div class="top-selling-item">
                    <div class="d-flex align-items-center">
                        <span class="rank-badge {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : 'rank-3') }}">
                            {{ $index + 1 }}
                        </span>
                        <div class="item-info">
                            <div class="item-name">{{ $item->paket->nama_paket ?? 'Paket Dihapus' }}</div>
                            <div class="item-sold">Total terjual</div>
                        </div>
                    </div>
                    <div class="item-qty">{{ $item->total_terjual }} Pax</div>
                </div>
                @endif
                @empty
                <div class="text-center text-muted py-3">
                    <small>Belum ada data penjualan bulan ini.</small>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Donut Chart --}}
        <div class="card-modern p-3 flex-grow-1">
            <h6 class="fw-bold mb-3"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Status Pesanan</h6>
            <div style="position: relative; height: 160px; display: flex; justify-content: center;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ROW 3: DOWNLOAD BUTTON & TABLE --}}
<div class="row g-3">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-table me-2 text-primary"></i>Pesanan Terbaru</h6>
                <div class="d-flex gap-2">
                    {{-- TOMBOL DOWNLOAD DENGAN MODAL --}}
                    <button type="button" class="btn-download" data-bs-toggle="modal" data-bs-target="#downloadModal">
                        <i class="bi bi-file-earmark-pdf"></i> Download Laporan
                    </button>
                    <a href="{{ route('pemesanans.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
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
                            <td class="ps-4 fw-bold text-primary small">{{ $order->no_resi }}</td>
                            <td class="small">{{ $order->tgl_pesan->format('d/m/Y') }}</td>
                            <td class="small">{{ $order->pelanggan->nama_pelanggan ?? '-' }}</td>
                            <td class="fw-bold text-success small">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
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
                                <span class="badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} px-2 py-1 rounded-pill small">
                                    {{ $order->status_pesan }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('pemesanans.show', $order->id) }}" class="btn btn-sm btn-light text-primary rounded-3"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada pesanan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DOWNLOAD LAPORAN --}}
<div class="modal fade" id="downloadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>Download Laporan Bulanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{ route('report.download') }}" method="GET" id="downloadForm">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">Pilih Bulan</label>
                            <select name="bulan" class="form-select form-select-lg" style="border-radius: 12px; border: 2px solid #e8e8e8;">
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">Pilih Tahun</label>
                            <select name="tahun" class="form-select form-select-lg" style="border-radius: 12px; border: 2px solid #e8e8e8;">
                                @for($year = date('Y')-2; $year <= date('Y'); $year++)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal" style="font-weight: 600;">Batal</button>
                <button type="submit" form="downloadForm" class="btn-download rounded-pill px-4">
                    <i class="bi bi-download"></i> Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. LINE CHART (FIXED SYNTAX)
        const ordersCanvas = document.getElementById('ordersChart');
        if (ordersCanvas) {
            const ctx = ordersCanvas.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(45, 106, 79, 0.5)');
            gradient.addColorStop(1, 'rgba(45, 106, 79, 0.0)');
            
            // PERBAIKAN STRUKTUR: data: { ... }
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels ?? []) !!},
                    datasets: [{
                        label: 'Jumlah Pesanan',
                        data: {!! json_encode($chartData ?? []) !!}, // PERBAIKAN: data: [...]
                        borderColor: '#2d6a4f',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#2d6a4f',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // FIX: Biar menyesuaikan container
                    layout: {
                        padding: { top: 10, right: 10, bottom: 0, left: 0 }
                    },
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(255,255,255,0.95)',
                            titleColor: '#1a1a1a',
                            bodyColor: '#666',
                            borderColor: '#e0e0e0',
                            borderWidth: 1,
                            padding: 12
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            max: 5,
                            grid: { color: '#f0f2f5', borderDash: [5, 5], drawBorder: false },
                            ticks: { stepSize: 1, font: { size: 11 }, color: '#999', padding: 8 }
                        },
                        x: { 
                            grid: { display: false, drawBorder: false },
                            ticks: { maxTicksLimit: 10, font: { size: 11 }, color: '#999', padding: 8 }
                        }
                    }
                }
            });
        }

        // 2. DOUGHNUT CHART (FIXED SYNTAX)
        const statusCanvas = document.getElementById('statusChart');
        if (statusCanvas) {
            const ctx = statusCanvas.getContext('2d');
            
            // PERBAIKAN STRUKTUR: data: { ... }
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Konfirmasi', 'Diproses', 'Kurir', 'Selesai', 'Batal'],
                    datasets: [{
                        data: [
                            {{ $menungguKonfirmasi ?? 0 }},
                            {{ $sedangDiproses ?? 0 }},
                            {{ $menungguKurir ?? 0 }},
                            {{ $selesai ?? 0 }},
                            {{ $dibatalkan ?? 0 }}
                        ], // PERBAIKAN: data: [...]
                        backgroundColor: ['#ffc107', '#0dcaf0', '#6c757d', '#198754', '#dc3545'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 12, usePointStyle: true, boxWidth: 8, font: { size: 10 } }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush