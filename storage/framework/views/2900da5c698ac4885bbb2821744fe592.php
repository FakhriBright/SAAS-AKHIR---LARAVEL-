<?php $__env->startSection('title', 'Dashboard - Fakhri Kitchen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Selamat Datang, <?php echo e(Auth::guard('pelanggan')->user()->nama_pelanggan); ?>! 👋</h2>
            <p class="text-muted mb-0">Kelola pesanan catering Anda dengan mudah.</p>
        </div>
        <a href="<?php echo e(route('customer.order.create')); ?>" class="btn btn-fk-primary">
            <i class="bi bi-plus-circle me-1"></i> Buat Pesanan Baru
        </a>
    </div>

    
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card fk-card p-4 h-100 border-start border-4 border-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small text-uppercase">Total Pesanan</p>
                        <h3 class="fw-bold mb-0"><?php echo e($totalPesanan ?? 0); ?></h3>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle"><i class="bi bi-cart-check fs-4 text-success"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card fk-card p-4 h-100 border-start border-4 border-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small text-uppercase">Pesanan Aktif</p>
                        <h3 class="fw-bold mb-0"><?php echo e($pesananAktif ?? 0); ?></h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle"><i class="bi bi-clock-history fs-4 text-warning"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card fk-card p-4 h-100 border-start border-4 border-info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small text-uppercase">Total Belanja</p>
                        <h3 class="fw-bold mb-0 text-success">Rp <?php echo e(number_format($totalBelanja ?? 0, 0, ',', '.')); ?></h3>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle"><i class="bi bi-wallet2 fs-4 text-info"></i></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card fk-card">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-badge me-2 text-primary"></i>Informasi Profil</h5>
                </div>
                <div class="card-body px-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">NAMA LENGKAP</p>
                            <p class="fw-semibold"><?php echo e($pelanggan->nama_pelanggan ?? '-'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">EMAIL</p>
                            <p class="fw-semibold"><?php echo e($pelanggan->email ?? '-'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">NOMOR TELEPON</p>
                            <p class="fw-semibold"><?php echo e($pelanggan->telepon ?? '-'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">ALAMAT</p>
                            <p class="fw-semibold">
                                <?php echo e($pelanggan->alamat1 ?? '-'); ?>

                                <?php if($pelanggan->alamat2): ?>, <?php echo e($pelanggan->alamat2); ?><?php endif; ?>
                                <?php if($pelanggan->alamat3): ?>, <?php echo e($pelanggan->alamat3); ?><?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card fk-card mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>5 Pesanan Terakhir</h5>
            <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-fk-outline btn-sm">Lihat Semua →</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
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
                        <?php $__empty_1 = true; $__currentLoopData = $recentOrders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 fw-bold"><?php echo e($order->no_resi); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($order->tgl_pesan)->format('d/m/Y')); ?></td>
                            <td class="fw-bold text-success">Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></td>
                            <td>
                                <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?> <span class="fk-badge bg-warning text-dark">Menunggu</span>
                                <?php elseif($order->status_pesan == 'Sedang Diproses'): ?> <span class="fk-badge bg-info text-dark">Diproses</span>
                                <?php elseif($order->status_pesan == 'Selesai'): ?> <span class="fk-badge bg-success">Selesai</span>
                                <?php elseif($order->status_pesan == 'Dibatalkan'): ?> <span class="fk-badge bg-danger">Batal</span>
                                <?php else: ?> <span class="fk-badge bg-secondary"><?php echo e($order->status_pesan); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="<?php echo e(route('customer.order.detail', $order->id)); ?>" class="btn btn-fk-outline btn-sm py-1 px-3">Detail</a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>Belum ada pesanan</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <a href="<?php echo e(route('customer.catalog')); ?>" class="card fk-card text-center p-4 text-decoration-none text-dark h-100">
                <i class="bi bi-grid fs-2 text-primary mb-2"></i>
                <h6 class="mb-0 fw-bold">Katalog Paket</h6>
            </a>
        </div>
        <div class="col-md-3">
            <a href="<?php echo e(route('customer.order.create')); ?>" class="card fk-card text-center p-4 text-decoration-none text-dark h-100">
                <i class="bi bi-cart-plus fs-2 text-success mb-2"></i>
                <h6 class="mb-0 fw-bold">Pesan Sekarang</h6>
            </a>
        </div>
        <div class="col-md-3">
            <a href="<?php echo e(route('customer.orders')); ?>" class="card fk-card text-center p-4 text-decoration-none text-dark h-100">
                <i class="bi bi-list-check fs-2 text-info mb-2"></i>
                <h6 class="mb-0 fw-bold">Riwayat</h6>
            </a>
        </div>
        <div class="col-md-3">
            <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="card fk-card text-center p-4 text-decoration-none text-dark h-100">
                <i class="bi bi-box-arrow-right fs-2 text-danger mb-2"></i>
                <h6 class="mb-0 fw-bold text-danger">Logout</h6>
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR-LARAVEL\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>