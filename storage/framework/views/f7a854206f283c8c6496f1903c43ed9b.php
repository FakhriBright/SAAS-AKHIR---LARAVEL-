<?php $__env->startSection('title', 'Katalog Paket Catering'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">Paket Catering Kami</h1>
        <p class="lead text-muted">Pilih paket catering terbaik untuk acara Anda</p>
        <?php if(auth()->guard()->guest()): ?>
        <div class="d-flex justify-content-center gap-2 mt-3">
            <a href="<?php echo e(route('customer.login')); ?>" class="btn btn-outline-primary">Login</a>
            <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Daftar Sekarang</a>
        </div>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <?php if($paket->foto1): ?>
                <img src="<?php echo e(asset('storage/' . $paket->foto1)); ?>" class="card-img-top" alt="<?php echo e($paket->nama_paket); ?>" style="height: 250px; object-fit: cover;">
                <?php else: ?>
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                    <i class="bi bi-image display-4 text-muted"></i>
                </div>
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <h5 class="card-title fw-bold mb-0"><?php echo e($paket->nama_paket); ?></h5>
                        <span class="badge bg-primary mt-1"><?php echo e(ucfirst($paket->jenis)); ?></span>
                    </div>
                    <p class="text-muted small mb-2"><i class="bi bi-people"></i> <?php echo e($paket->jumlah_pax); ?> Pax</p>
                    <p class="card-text text-muted small flex-grow-1"><?php echo e(Str::limit($paket->deskripsi, 80)); ?></p>

                    <h4 class="text-primary fw-bold mb-3">Rp <?php echo e(number_format($paket->harga, 0, ',', '.')); ?></h4>

                    
                    <a href="<?php echo e(route('customer.order.create')); ?>" class="btn btn-primary w-100 mt-auto">
                        <i class="bi bi-cart-plus"></i> Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <p class="mt-3">Belum ada paket tersedia</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .hover-card { transition: transform 0.3s, box-shadow 0.3s; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\catering-online\resources\views/customer/catalog.blade.php ENDPATH**/ ?>