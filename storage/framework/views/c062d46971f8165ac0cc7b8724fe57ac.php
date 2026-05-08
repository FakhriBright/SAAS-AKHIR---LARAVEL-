<?php $__env->startSection('title', 'Dashboard - Fakhri Kitchen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0"> 
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h2 class="fw-bold mb-1" style="color: var(--primary-dark);">
                        Selamat Datang, <?php echo e(explode(' ', Auth::guard('pelanggan')->user()->nama_pelanggan)[0]); ?>! 👋
                    </h2>
                    <p class="text-muted mb-0">Kelola pesanan catering Anda dengan mudah</p>
                </div>
                <a href="<?php echo e(route('customer.order.create')); ?>" class="btn btn-fk-primary btn-lg shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i>Buat Pesanan Baru
                </a>
            </div>
        </div>
    </div>

    
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card fk-card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-75 text-uppercase small fw-semibold">Total Pesanan</p>
                            <h2 class="fw-bold mb-0"><?php echo e($totalPesanan ?? 0); ?></h2>
                            <small class="opacity-75">Pesanan sepanjang waktu</small>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-cart-check fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card fk-card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-75 text-uppercase small fw-semibold">Pesanan Aktif</p>
                            <h2 class="fw-bold mb-0"><?php echo e($pesananAktif ?? 0); ?></h2>
                            <small class="opacity-75">Sedang diproses</small>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-clock-history fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card fk-card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-75 text-uppercase small fw-semibold">Total Belanja</p>
                            <h3 class="fw-bold mb-0">Rp <?php echo e(number_format($totalBelanja ?? 0, 0, ',', '.')); ?></h3>
                            <small class="opacity-75">Pesanan selesai</small>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-wallet2 fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-5">
            <div class="card fk-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold" style="color: var(--primary-dark);">
                        <i class="bi bi-person-badge me-2"></i>Informasi Profil
                    </h5>
                </div>
                <div class="card-body px-4">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                            <i class="bi bi-person fs-1" style="color: var(--primary);"></i>
                        </div>
                        <h5 class="fw-bold mb-1"><?php echo e($pelanggan->nama_pelanggan); ?></h5>
                        <small class="text-muted">Pelanggan Setia</small>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-start p-2 rounded" style="background: #f8f9fa;">
                                <i class="bi bi-envelope text-primary me-3 mt-1"></i>
                                <div>
                                    <small class="text-muted d-block">Email</small>
                                    <span class="fw-medium"><?php echo e($pelanggan->email); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start p-2 rounded" style="background: #f8f9fa;">
                                <i class="bi bi-telephone text-primary me-3 mt-1"></i>
                                <div>
                                    <small class="text-muted d-block">Telepon</small>
                                    <span class="fw-medium"><?php echo e($pelanggan->telepon); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start p-2 rounded" style="background: #f8f9fa;">
                                <i class="bi bi-geo-alt text-primary me-3 mt-1"></i>
                                <div>
                                    <small class="text-muted d-block">Alamat</small>
                                    <span class="fw-medium">
                                        <?php echo e($pelanggan->alamat1); ?>

                                        <?php if($pelanggan->alamat2): ?>, <?php echo e($pelanggan->alamat2); ?><?php endif; ?>
                                        <?php if($pelanggan->alamat3): ?>, <?php echo e($pelanggan->alamat3); ?><?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?php echo e(route('customer.profile')); ?>" class="btn btn-fk-outline w-100 mt-3">
                        <i class="bi bi-pencil me-2"></i>Edit Profil
                    </a>
                </div>
            </div>
        </div>

        
        <div class="col-lg-7">
            <div class="card fk-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold" style="color: var(--primary-dark);">
                        <i class="bi bi-clock-history me-2"></i>5 Pesanan Terakhir
                    </h5>
                    <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-sm btn-fk-outline">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);">
                                <tr>
                                    <th class="ps-4 py-3 small text-uppercase text-muted fw-semibold">No. Resi</th>
                                    <th class="py-3 small text-uppercase text-muted fw-semibold">Tanggal</th>
                                    <th class="py-3 small text-uppercase text-muted fw-semibold">Total</th>
                                    <th class="py-3 small text-uppercase text-muted fw-semibold">Status</th>
                                    <th class="pe-4 text-end py-3 small text-uppercase text-muted fw-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentOrders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="border-bottom-light">
                                    <td class="ps-4 py-3">
                                        <span class="fw-bold" style="color: var(--primary);"><?php echo e($order->no_resi); ?></span>
                                    </td>
                                    <td class="py-3"><?php echo e(\Carbon\Carbon::parse($order->tgl_pesan)->format('d/m/Y')); ?></td>
                                    <td class="py-3 fw-bold text-success">Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></td>
                                    <td class="py-3">
                                        <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?>
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                                <i class="bi bi-hourglass-split me-1"></i>Menunggu
                                            </span>
                                        <?php elseif($order->status_pesan == 'Sedang Diproses'): ?>
                                            <span class="badge bg-info text-dark px-3 py-2 rounded-pill">
                                                <i class="bi bi-gear me-1"></i>Diproses
                                            </span>
                                        <?php elseif($order->status_pesan == 'Menunggu Kurir'): ?>
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                                <i class="bi bi-truck me-1"></i>Kurir
                                            </span>
                                        <?php elseif($order->status_pesan == 'Selesai'): ?>
                                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                                <i class="bi bi-check-circle me-1"></i>Selesai
                                            </span>
                                        <?php elseif($order->status_pesan == 'Dibatalkan'): ?>
                                            <span class="badge bg-danger px-3 py-2 rounded-pill">
                                                <i class="bi bi-x-circle me-1"></i>Batal
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="pe-4 text-end py-3">
                                        <a href="<?php echo e(route('customer.order.detail', $order->id)); ?>" class="btn btn-sm btn-fk-outline py-1 px-3">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                            <i class="bi bi-inbox fs-1 text-muted"></i>
                                        </div>
                                        <p class="mb-3">Belum ada pesanan</p>
                                        <a href="<?php echo e(route('customer.order.create')); ?>" class="btn btn-fk-primary">
                                            <i class="bi bi-plus-circle me-2"></i>Buat Pesanan Pertama
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-3 mt-4 mb-5">
        <div class="col-12">
            <h5 class="fw-bold mb-3" style="color: var(--primary-dark);">
                <i class="bi bi-grid-3x3-gap me-2"></i>Menu Cepat
            </h5>
        </div>
        <div class="col-md-3 col-6">
            <a href="<?php echo e(route('customer.catalog')); ?>" class="card fk-card text-center text-decoration-none text-dark h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-grid fs-2" style="color: var(--primary);"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Katalog Paket</h6>
                    <small class="text-muted">Lihat semua menu</small>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="<?php echo e(route('customer.order.create')); ?>" class="card fk-card text-center text-decoration-none text-dark h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-cart-plus fs-2" style="color: var(--primary);"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Pesan Sekarang</h6>
                    <small class="text-muted">Buat pesanan baru</small>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="<?php echo e(route('customer.orders')); ?>" class="card fk-card text-center text-decoration-none text-dark h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-list-check fs-2" style="color: var(--primary);"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Riwayat</h6>
                    <small class="text-muted">Cek pesanan lama</small>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="card fk-card text-center text-decoration-none text-dark h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-box-arrow-right fs-2 text-danger"></i>
                    </div>
                    <h6 class="fw-bold mb-1 text-danger">Logout</h6>
                    <small class="text-muted">Keluar dari akun</small>
                </div>
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .border-bottom-light { border-bottom: 1px solid #f0f0f0 !important; }
    .card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card:hover { transform: translateY(-2px); }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>