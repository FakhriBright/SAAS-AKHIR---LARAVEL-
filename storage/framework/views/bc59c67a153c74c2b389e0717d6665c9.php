<?php $__env->startSection('title', 'Dashboard Pelanggan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-1">Selamat Datang, <?php echo e(auth()->guard('pelanggan')->user()->nama_pelanggan); ?>! 👋</h2>
            <p class="text-muted mb-0">Kelola pesanan catering Anda dengan mudah</p>
        </div>
    </div>

    
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card-modern p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-bold">Total Pesanan</p>
                        <h3 class="fw-bold mb-0"><?php echo e($totalPesanan); ?></h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                        <i class="bi bi-cart-check text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-modern p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-bold">Pesanan Aktif</p>
                        <h3 class="fw-bold mb-0"><?php echo e($pesananAktif); ?></h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                        <i class="bi bi-clock text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-modern p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-bold">Pesanan Selesai</p>
                        <h3 class="fw-bold mb-0"><?php echo e($pesananSelesai); ?></h3>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-3 p-3">
                        <i class="bi bi-check-circle text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-modern p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-bold">Total Belanja</p>
                        <h3 class="fw-bold mb-0 text-success">Rp <?php echo e(number_format($totalBelanja, 0, ',', '.')); ?></h3>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-3 p-3">
                        <i class="bi bi-wallet text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="card-modern p-4 h-100">
                <h5 class="fw-bold mb-3">Menu Cepat</h5>
                <div class="d-grid gap-2">
                    <a href="<?php echo e(route('customer.catalog')); ?>" class="btn btn-primary rounded-pill">
                        <i class="bi bi-grid me-2"></i>Lihat Katalog
                    </a>
                    <a href="<?php echo e(route('customer.cart.index')); ?>" class="btn btn-outline-primary rounded-pill">
                        <i class="bi bi-cart3 me-2"></i>Keranjang
                    </a>
                    <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-receipt me-2"></i>Riwayat Pesanan
                    </a>
                    <a href="<?php echo e(route('customer.profile')); ?>" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-person me-2"></i>Profil Saya
                    </a>
                </div>
            </div>
        </div>

        
        <div class="col-md-8">
            <div class="card-modern p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">5 Pesanan Terakhir</h5>
                    <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-sm btn-primary rounded-pill">Lihat Semua</a>
                </div>
                
                <?php if($recentOrders->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th>No. Resi</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="fw-bold text-primary small"><?php echo e($order->no_resi); ?></td>
                                <td class="small"><?php echo e($order->tgl_pesan->format('d/m/Y')); ?></td>
                                <td class="fw-bold text-success small">Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></td>
                                <td>
                                    <?php
                                    $badgeClass = match($order->status_pesan) {
                                        'Menunggu Konfirmasi' => 'warning',
                                        'Sedang Diproses' => 'info',
                                        'Menunggu Kurir' => 'secondary',
                                        'Selesai' => 'success',
                                        'Dibatalkan' => 'danger',
                                        default => 'secondary'
                                    };
                                    ?>
                                    <span class="badge bg-<?php echo e($badgeClass); ?> bg-opacity-10 text-<?php echo e($badgeClass); ?> px-3 py-1 rounded-pill small">
                                        <?php echo e($order->status_pesan); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                    <p class="text-muted mb-3">Belum ada pesanan</p>
                    <a href="<?php echo e(route('customer.catalog')); ?>" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-cart-plus me-2"></i>Pesan Sekarang
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('styles'); ?>
<style>
    .card-modern { background: white; border: none; border-radius: 20px; box-shadow: 0 5px 20px rgba(112, 144, 176, 0.08); transition: 0.3s; }
    .card-modern:hover { transform: translateY(-2px); }
    .table-modern { margin-bottom: 0; }
    .table-modern thead th { background: #f8f9fa; color: #a3aed0; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; padding: 1rem; border: none; }
    .table-modern tbody td { padding: 1rem; vertical-align: middle; color: #2b3674; font-weight: 500; border-bottom: 1px solid #f0f2f5; }
    .table-modern tbody tr:last-child td { border-bottom: none; }
    .table-modern tbody tr:hover { background: #f9fbfd; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>