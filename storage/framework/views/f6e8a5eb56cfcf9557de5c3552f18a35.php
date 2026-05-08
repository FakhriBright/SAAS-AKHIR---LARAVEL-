<?php $__env->startSection('title', 'Katalog Paket - Fakhri Kitchen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Paket Catering Kami</h2>
        <p class="text-muted">Pilih paket catering terbaik untuk acara Anda</p>
    </div>

    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-lg-4 col-md-6">
            <div class="card fk-card h-100 overflow-hidden">
                <img src="<?php echo e($paket->foto1 ? asset('storage/' . $paket->foto1) : 'https://via.placeholder.com/400x250?text=Fakhri+Kitchen'); ?>" class="card-img-top" alt="<?php echo e($paket->nama_paket); ?>" style="height: 220px; object-fit: cover;">
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0"><?php echo e($paket->nama_paket); ?></h5>
                        <span class="badge bg-success"><?php echo e($paket->jenis ?? 'Box'); ?></span>
                    </div>
                    <p class="text-muted small flex-grow-1"><?php echo e(Str::limit($paket->deskripsi, 80)); ?></p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted d-block">Mulai dari</small>
                            <h4 class="fw-bold text-success mb-0">Rp <?php echo e(number_format($paket->harga, 0, ',', '.')); ?></h4>
                        </div>
                        <a href="<?php echo e(route('customer.order.create')); ?>?paket=<?php echo e($paket->id); ?>" class="btn btn-fk-primary btn-sm">
                            <i class="bi bi-cart-plus me-1"></i> Pesan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5">
            <i class="bi bi-box-seam fs-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted">Belum ada paket tersedia.</h5>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR-LARAVEL\resources\views/customer/catalog.blade.php ENDPATH**/ ?>