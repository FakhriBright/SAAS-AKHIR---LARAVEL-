<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* CSS KHUSUS UNTUK PIPELINE */
    .pipeline-container {
        display: flex;
        height: 140px;
        gap: 10px;
    }
    .pipeline-bar {
        flex: 1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        writing-mode: vertical-rl;
        text-orientation: mixed;
        font-weight: 600;
        font-size: 0.8rem;
        transform: rotate(180deg);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .pipeline-bar span { font-size: 0.7rem; opacity: 0.9; margin-top: 4px; }
</style>


<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card-modern p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small fw-bold">Total Pendapatan</p>
                    <h4 class="fw-bold mb-0 text-success">Rp <?php echo e(number_format($pendapatanTotal ?? 0, 0, ',', '.')); ?></h4>
                    <small class="text-success"><i class="bi bi-arrow-up-short"></i> Rp <?php echo e(number_format($pendapatanHariIni ?? 0, 0, ',', '.')); ?> hari ini</small>
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
                    <h4 class="fw-bold mb-0 text-dark"><?php echo e(number_format($totalPesanan ?? 0)); ?></h4>
                    <small class="text-success"><i class="bi bi-arrow-up-short"></i> <?php echo e($pesananHariIni ?? 0); ?> hari ini</small>
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
                    <h4 class="fw-bold mb-0 text-dark"><?php echo e(number_format($totalPelanggan ?? 0)); ?></h4>
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
                    <h4 class="fw-bold mb-0 text-dark"><?php echo e(number_format($totalPaket ?? 0)); ?></h4>
                    <small class="text-muted">Tersedia</small>
                </div>
                <div class="bg-warning bg-opacity-10 rounded-3 p-2">
                    <i class="bi bi-box-seam text-warning fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row g-3 mb-4">
    
    <div class="col-xl-8">
        
        <div class="card-modern p-4" style="height: 500px;">
            <h6 class="fw-bold mb-4"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>Jumlah Pesanan Bulan Ini</h6>
            <div style="position: relative; height: 420px; width: 100%;">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    
    <div class="col-xl-4 d-flex flex-column gap-3">
        
        <div class="card-modern p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Pipeline</h6>
            <div class="pipeline-container">
                <div class="pipeline-bar" style="background: linear-gradient(135deg, #ffc107, #ff9800);">Konfirmasi<br><span>[<?php echo e($menungguKonfirmasi ?? 0); ?>]</span></div>
                <div class="pipeline-bar" style="background: linear-gradient(135deg, #0dcaf0, #0d6efd);">Diproses<br><span>[<?php echo e($sedangDiproses ?? 0); ?>]</span></div>
                <div class="pipeline-bar" style="background: linear-gradient(135deg, #6c757d, #495057);">Kurir<br><span>[<?php echo e($menungguKurir ?? 0); ?>]</span></div>
                <div class="pipeline-bar" style="background: linear-gradient(135deg, #198754, #146c43);">Selesai<br><span>[<?php echo e($selesai ?? 0); ?>]</span></div>
                <div class="pipeline-bar" style="background: linear-gradient(135deg, #dc3545, #b02a37);">Batal<br><span>[<?php echo e($dibatalkan ?? 0); ?>]</span></div>
            </div>
        </div>

        
        <div class="card-modern p-3 flex-grow-1">
            <h6 class="fw-bold mb-3"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Status</h6>
            <div style="position: relative; height: 180px; display: flex; justify-content: center;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<button type="button" class="btn btn-sm btn-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#reportModal">
    <i class="bi bi-file-earmark-pdf me-2"></i>Download Laporan
</button>

<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-file-earmark-pdf me-2"></i>Download Laporan Bulanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('report.download')); ?>" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Bulan</label>
                        <select name="bulan" class="form-select" required>
                            <?php for($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php echo e($i == date('m') ? 'selected' : ''); ?>>
                                <?php echo e(Carbon\Carbon::create()->month($i)->translatedFormat('F')); ?>

                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Tahun</label>
                        <select name="tahun" class="form-select" required>
                            <?php for($year = date('Y')-2; $year <= date('Y'); $year++): ?>
                            <option value="<?php echo e($year); ?>" <?php echo e($year == date('Y') ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-download me-2"></i>Download PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-table me-2 text-primary"></i>Pesanan Terbaru</h6>
                <a href="<?php echo e(route('pemesanans.index')); ?>" class="btn btn-sm btn-primary rounded-pill px-3">Lihat Semua</a>
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
                        <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 fw-bold text-primary small"><?php echo e($order->no_resi); ?></td>
                            <td class="small"><?php echo e($order->tgl_pesan->format('d/m/Y')); ?></td>
                            <td class="small"><?php echo e($order->pelanggan->nama_pelanggan ?? '-'); ?></td>
                            <td class="fw-bold text-success small">Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></td>
                            <td>
                                <?php
                                $statusClass = match($order->status_pesan) {
                                    'Menunggu Konfirmasi' => 'warning',
                                    'Sedang Diproses' => 'info',
                                    'Menunggu Kurir' => 'secondary',
                                    'Selesai' => 'success',
                                    'Dibatalkan' => 'danger',
                                    default => 'light'
                                };
                                ?>
                                <span class="badge bg-<?php echo e($statusClass); ?> bg-opacity-10 text-<?php echo e($statusClass); ?> px-3 py-2 rounded-pill">
                                    <?php echo e($order->status_pesan); ?>

                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="<?php echo e(route('pemesanans.show', $order->id)); ?>" class="btn btn-sm btn-light text-primary rounded-3"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada pesanan</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. LINE CHART
        const ordersCanvas = document.getElementById('ordersChart');
        if (ordersCanvas) {
            const ctx = ordersCanvas.getContext('2d');
            
            // Create gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 420); // Sesuaikan dengan height wrapper
            gradient.addColorStop(0, 'rgba(45, 106, 79, 0.6)');
            gradient.addColorStop(1, 'rgba(45, 106, 79, 0.0)');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($chartLabels ?? []); ?>,
                    datasets: [{
                        label: 'Jumlah Pesanan',
                        data: <?php echo json_encode($chartData ?? []); ?>,
                        borderColor: '#2d6a4f',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#2d6a4f',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // PENTING: Biar tinggi mengikuti container
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
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
                            max: 5, // KUNCI: Mentok di angka 5
                            grid: {
                                color: '#f0f2f5',
                                borderDash: [5, 5],
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 1, // Garis grid tiap 1 angka (1, 2, 3, 4, 5)
                                font: { size: 12 },
                                color: '#999',
                                padding: 10
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 15,
                                font: { size: 11 },
                                color: '#999',
                                padding: 5
                            }
                        }
                    }
                }
            });
        }

        // 2. DOUGHNUT CHART
        const statusCanvas = document.getElementById('statusChart');
        if (statusCanvas) {
            const ctx = statusCanvas.getContext('2d');
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Konfirmasi', 'Diproses', 'Kurir', 'Selesai', 'Batal'],
                    datasets: [{
                        data: [
                            <?php echo e($menungguKonfirmasi ?? 0); ?>,
                            <?php echo e($sedangDiproses ?? 0); ?>,
                            <?php echo e($menungguKurir ?? 0); ?>,
                            <?php echo e($selesai ?? 0); ?>,
                            <?php echo e($dibatalkan ?? 0); ?>

                        ],
                        backgroundColor: ['#ffc107', '#0dcaf0', '#6c757d', '#198754', '#dc3545'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 8,
                                font: { size: 10, family: 'Poppins' }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/dashboard.blade.php ENDPATH**/ ?>