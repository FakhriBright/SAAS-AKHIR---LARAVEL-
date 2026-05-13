<?php $__env->startSection('title', 'Katalog Paket Catering'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="btn btn-fk-outline me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Katalog Paket Catering</h2>
            <p class="text-muted mb-0">Pilih paket catering terbaik untuk acara Anda</p>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <?php if($pakets->count() > 0): ?>
    <div class="row g-4">
        <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-6 col-lg-4">
            <div class="card fk-card h-100">
                <div class="position-relative" style="height: 180px; overflow: hidden; background: #f8f9fa;">
                    <?php if($paket->foto1): ?>
                    <img src="<?php echo e(asset('storage/' . $paket->foto1)); ?>" class="w-100 h-100" style="object-fit: cover;" alt="<?php echo e($paket->nama_paket); ?>">
                    <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center h-100"><i class="bi bi-image fs-1 text-muted"></i></div>
                    <?php endif; ?>
                    <span class="position-absolute top-0 end-0 m-2 badge bg-primary"><?php echo e($paket->jenis); ?></span>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold mb-1"><?php echo e($paket->nama_paket); ?></h5>
                    <p class="text-muted small mb-2"><i class="bi bi-tag me-1"></i><?php echo e($paket->kategori); ?></p>
                    <p class="card-text text-muted small mb-3 flex-grow-1"><?php echo e(Str::limit($paket->deskripsi, 80)); ?></p>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-people text-primary me-2"></i><span class="fw-medium small"><?php echo e($paket->jumlah_pax); ?> Pax</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Harga per paket</small>
                        <h4 class="text-success fw-bold mb-0">Rp <?php echo e(number_format($paket->harga_paket, 0, ',', '.')); ?></h4>
                    </div>
                    <form action="<?php echo e(route('customer.cart.add', $paket->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="input-group input-group-sm">
                            <input type="number" name="jumlah" class="form-control" value="1" min="1" style="max-width: 70px;">
                            <button type="submit" class="btn btn-fk-primary"><i class="bi bi-cart-plus me-1"></i>Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <div class="text-center py-5">
        <i class="bi bi-box-seam fs-1 text-muted d-block mb-3"></i>
        <h5 class="text-muted">Belum ada paket tersedia</h5>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/customer/catalog.blade.php ENDPATH**/ ?>