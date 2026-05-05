@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
{{-- Alert Khusus Owner --}}
@if(Auth::user()->level === 'owner')
<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="bi bi-info-circle-fill me-2 fs-4"></i>
    <div>
        <strong>Mode Owner (Read-Only)</strong><br>
        <small>Anda memiliki akses monitoring dashboard. Untuk perubahan data, hubungi Admin.</small>
    </div>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Dashboard Overview</h3>
        <p class="text-muted mb-0">Selamat datang kembali, {{ Auth::user()->name }}!</p>
    </div>
    <div class="text-end">
        <p class="text-muted mb-0 small">{{ now()->format('l') }}</p>
        <p class="fw-bold mb-0">{{ now()->format('d F Y') }}</p>
    </div>
</div>

{{-- Stats Cards with Animations --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75">Total Pendapatan</p>
                        <h3 class="fw-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                        <small class="opacity-75">{{ $totalPesanan }} transaksi selesai</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-cash-coin display-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75">Pesanan Bulan Ini</p>
                        <h3 class="fw-bold mb-0">{{ $pesananBulanIni }}</h3>
                        <small class="opacity-75">{{ $pertumbuhanPesanan > 0 ? '+' : '' }}{{ $pertumbuhanPesanan }}% dari bulan lalu</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-cart-check display-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75">Perlu Diproses</p>
                        <h3 class="fw-bold mb-0">{{ $pesananPending }}</h3>
                        <small class="opacity-75">{{ $totalPelanggan }} pelanggan aktif</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-hourglass-split display-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Chart Section --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 fw-bold">Statistik Pemesanan</h5>
                    <p class="text-muted small mb-0">Grafik pesanan 6 bulan terakhir</p>
                </div>
                <select class="form-select form-select-sm" style="width: auto;" id="chartPeriod">
                    <option value="6">6 Bulan</option>
                    <option value="12">12 Bulan</option>
                </select>
            </div>
            <div class="card-body px-4">
                <canvas id="ordersChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Orders & Top Products --}}
    <div class="col-lg-4">
        {{-- Latest Orders --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Pesanan Terbaru</h5>
                <a href="{{ route('pemesanans.index') }}" class="small text-decoration-none">Lihat Semua</a>
            </div>
            <div class="list-group list-group-flush">
                @forelse($recentPemesanan as $p)
                <a href="{{ route('pemesanans.show', $p->id) }}" class="list-group-item list-group-item-action border-0 px-4 py-3 hover-light">
                    <div class="d-flex w-100 justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold text-dark small">{{ $p->no_resi }}</h6>
                            <p class="mb-1 small text-muted">{{ Str::limit($p->pelanggan->nama_pelanggan, 20) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="fw-bold text-primary small">Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</span>
                                <span class="badge bg-{{ $p->status_pesan == 'Selesai' ? 'success' : ($p->status_pesan == 'Menunggu Konfirmasi' ? 'warning' : 'info') }} rounded-pill small">
                                    {{ $p->status_pesan }}
                                </span>
                            </div>
                        </div>
                        <small class="text-muted ms-2">{{ $p->tgl_pesan->format('d/m') }}</small>
                    </div>
                </a>
                @empty
                <div class="p-4 text-center text-muted small">
                    <i class="bi bi-inbox display-6 d-block mb-2"></i>
                    Belum ada pesanan
                </div>
                @endforelse
            </div>
        </div>

        {{-- Top Packages --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold">Paket Terlaris</h5>
            </div>
            <div class="card-body px-4">
                @forelse($topPakets as $index => $paket)
                <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                    <div class="bg-{{ $index == 0 ? 'warning' : ($index == 1 ? 'secondary' : 'bronze') }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width: 32px; height: 32px;">
                        <span class="fw-bold small">{{ $index + 1 }}</span>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 small fw-bold">{{ Str::limit($paket->nama_paket, 25) }}</h6>
                        <small class="text-muted">{{ number_format($paket->total_terjual) }}x terjual</small>
                    </div>
                    <span class="fw-bold text-primary small">Rp {{ number_format($paket->total_pendapatan, 0, ',', '.') }}</span>
                </div>
                @empty
                <p class="text-muted small text-center mb-0">Belum ada data paket</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions (Hanya untuk Admin) --}}
@if(Auth::user()->level === 'admin')
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Aksi Cepat</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('pemesanans.create') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-plus-circle d-block mb-2 fs-4"></i>
                            <span class="small">Pesanan Baru</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('pengirimans.index') }}" class="btn btn-outline-success w-100 py-3">
                            <i class="bi bi-truck d-block mb-2 fs-4"></i>
                            <span class="small">Kelola Pengiriman</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('pelanggans.index') }}" class="btn btn-outline-info w-100 py-3">
                            <i class="bi bi-people d-block mb-2 fs-4"></i>
                            <span class="small">Data Pelanggan</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('pakets.index') }}" class="btn btn-outline-warning w-100 py-3">
                            <i class="bi bi-box-seam d-block mb-2 fs-4"></i>
                            <span class="small">Kelola Paket</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari Controller (REAL DATA)
    const chartData = @json($chartData);
    const chartLabels = @json($chartLabels);

    // Initialize Chart
    const ctx = document.getElementById('ordersChart').getContext('2d');

    // Gradient untuk chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(102, 126, 234, 0.5)');
    gradient.addColorStop(1, 'rgba(102, 126, 234, 0.0)');

    const ordersChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Pesanan',
                data: chartData,
                borderColor: '#667eea',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return 'Pesanan: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1,
                        padding: 10
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Hover effect untuk list items
    document.querySelectorAll('.hover-light').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(102, 126, 234, 0.05)';
        });
        item.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
</script>
@endpush

@push('styles')
<style>
    .hover-light:hover {
        background-color: rgba(102, 126, 234, 0.05) !important;
        transition: all 0.2s;
    }
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    .btn-outline-primary:hover,
    .btn-outline-success:hover,
    .btn-outline-info:hover,
    .btn-outline-warning:hover {
        transform: translateY(-2px);
        transition: all 0.2s;
    }
</style>
@endpush
