<?php $__env->startSection('title', 'Katalog Paket - Fakhri Kitchen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">    
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2" style="color: var(--primary-dark); font-size: 2.5rem;">
            Paket Catering Kami
        </h2>
        <p class="text-muted lead">Pilih paket catering terbaik untuk acara Anda</p>
        
        
        <div class="d-flex justify-content-center gap-2 mt-4 flex-wrap">
            <button class="btn btn-fk-primary rounded-pill px-4" onclick="filterPaket('all')">
                <i class="bi bi-grid me-2"></i>Semua Paket
            </button>
            <button class="btn btn-fk-outline rounded-pill px-4" onclick="filterPaket('Prasmanan')">
                Prasmanan
            </button>
            <button class="btn btn-fk-outline rounded-pill px-4" onclick="filterPaket('Meal Box')">
                Meal Box
            </button>
            <button class="btn btn-fk-outline rounded-pill px-4" onclick="filterPaket('Snack Box')">
                Snack Box
            </button>
            <button class="btn btn-fk-outline rounded-pill px-4" onclick="filterPaket('Tumpeng')">
                Tumpeng
            </button>
        </div>
    </div>

    
    <div class="row g-4" id="paket-grid">
        <?php $__empty_1 = true; $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-lg-4 col-md-6 paket-item" data-jenis="<?php echo e($paket->jenis); ?>">
            <div class="card fk-card h-100 border-0 shadow-sm overflow-hidden">
                
                <div class="position-relative overflow-hidden" style="height: 250px;">
                    <img src="<?php echo e($paket->foto1 ? asset('storage/' . $paket->foto1) : 'https://via.placeholder.com/400x250?text=' . urlencode($paket->nama_paket)); ?>" 
                         class="card-img-top h-100 w-100" 
                         alt="<?php echo e($paket->nama_paket); ?>"
                         style="object-fit: cover; transition: transform 0.5s;">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-tag me-1"></i><?php echo e($paket->jenis); ?>

                        </span>
                    </div>
                    
                    <div class="position-absolute w-100 h-100 top-0 start-0 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center opacity-0 hover-opacity-100 transition-opacity" style="transition: all 0.3s;">
                        <button class="btn btn-light rounded-pill px-4" onclick="window.location.href='<?php echo e(route('customer.order.create')); ?>?paket=<?php echo e($paket->id); ?>'">
                            <i class="bi bi-cart-plus me-2"></i>Pesan Sekarang
                        </button>
                    </div>
                </div>
                
                
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0" style="color: var(--primary-dark); font-size: 1.25rem;">
                            <?php echo e($paket->nama_paket); ?>

                        </h5>
                    </div>
                    
                    <p class="text-muted mb-3 flex-grow-1" style="font-size: 0.9rem; line-height: 1.6;">
                        <?php echo e(Str::limit($paket->deskripsi, 100)); ?>

                    </p>
                    
                    
                    <div class="d-flex gap-3 mb-3 small">
                        <span class="text-muted">
                            <i class="bi bi-people me-1 text-primary"></i>
                            <?php echo e($paket->jumlah_pax); ?> Pax
                        </span>
                        <?php if($paket->kategori): ?>
                        <span class="text-muted">
                            <i class="bi bi-tag me-1 text-primary"></i>
                            <?php echo e($paket->kategori); ?>

                        </span>
                        <?php endif; ?>
                    </div>
                    
                    
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Mulai dari</small>
                            <h4 class="fw-bold text-success mb-0" style="font-size: 1.5rem;">
                                Rp <?php echo e(number_format($paket->harga, 0, ',', '.')); ?>

                            </h4>
                        </div>
                        <a href="<?php echo e(route('customer.order.create')); ?>?paket=<?php echo e($paket->id); ?>" class="btn btn-fk-primary rounded-pill px-4">
                            <i class="bi bi-cart-plus me-1"></i> Pesan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5">
            <div class="bg-light rounded-circle d-inline-flex p-5 mb-3">
                <i class="bi bi-box-seam fs-1 text-muted"></i>
            </div>
            <h5 class="text-muted mb-2">Belum ada paket tersedia</h5>
            <p class="text-muted">Silakan hubungi admin untuk informasi lebih lanjut</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .hover-opacity-100:hover { opacity: 1 !important; }
    .transition-opacity { transition: opacity 0.3s ease; }
    .card-img-top:hover { transform: scale(1.1); }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function filterPaket(jenis) {
        const items = document.querySelectorAll('.paket-item');
        const buttons = document.querySelectorAll('.btn-outline-cta, .btn-fk-primary');
        
        // Update active button
        buttons.forEach(btn => {
            if (btn.textContent.toLowerCase().includes(jenis.toLowerCase()) || (jenis === 'all' && btn.textContent.includes('Semua'))) {
                btn.classList.remove('btn-fk-outline');
                btn.classList.add('btn-fk-primary');
            } else {
                btn.classList.remove('btn-fk-primary');
                btn.classList.add('btn-fk-outline');
            }
        });
        
        // Filter items
        items.forEach(item => {
            if (jenis === 'all' || item.dataset.jenis === jenis) {
                item.style.display = 'block';
                item.classList.add('animate__animated', 'animate__fadeIn');
            } else {
                item.style.display = 'none';
                item.classList.remove('animate__animated', 'animate__fadeIn');
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/customer/catalog.blade.php ENDPATH**/ ?>