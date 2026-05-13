

<?php $__env->startSection('title', 'Keranjang Belanja'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0"><i class="bi bi-cart3 me-2"></i>Keranjang Belanja</h2>
        <a href="<?php echo e(route('customer.catalog')); ?>" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
        </a>
    </div>

    <?php if($carts->count() > 0): ?>
    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="card-modern p-4">
                <h5 class="fw-bold mb-3">Item Pesanan</h5>
                
                <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="cart-item-row mb-3 pb-3 border-bottom">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0" style="width: 100px; height: 100px; overflow: hidden; border-radius: 12px;">
                            <?php if($cart->paket->foto1 && file_exists(public_path('storage/' . $cart->paket->foto1))): ?>
                                <img src="<?php echo e(asset('storage/' . $cart->paket->foto1)); ?>" class="w-100 h-100" style="object-fit: cover;" alt="<?php echo e($cart->paket->nama_paket); ?>">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=200&h=200&fit=crop" class="w-100 h-100" style="object-fit: cover;" alt="<?php echo e($cart->paket->nama_paket); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1"><?php echo e($cart->paket->nama_paket); ?></h6>
                            <p class="text-muted small mb-2"><?php echo e(Str::limit($cart->paket->deskripsi, 60)); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Harga: Rp <?php echo e(number_format($cart->paket->harga_paket, 0, ',', '.')); ?></small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <form action="<?php echo e(route('customer.cart.update', $cart->id)); ?>" method="POST" class="d-flex align-items-center gap-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" name="jumlah" value="<?php echo e($cart->jumlah - 1); ?>" class="btn btn-sm btn-outline-secondary" <?php echo e($cart->jumlah <= 1 ? 'disabled' : ''); ?>>−</button>
                                        <span class="fw-bold px-2"><?php echo e($cart->jumlah); ?></span>
                                        <button type="submit" name="jumlah" value="<?php echo e($cart->jumlah + 1); ?>" class="btn btn-sm btn-outline-secondary">+</button>
                                    </form>
                                    <form action="<?php echo e(route('customer.cart.remove', $cart->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm text-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success">Rp <?php echo e(number_format($cart->subtotal, 0, ',', '.')); ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="card-modern p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-3">Ringkasan Pesanan</h5>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Item</span>
                    <span class="fw-bold"><?php echo e($totalItems); ?> paket</span>
                </div>
                
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-bold">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-between mb-4">
                    <span class="fs-5 fw-bold">Total</span>
                    <span class="fs-4 fw-bold text-success">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                </div>
                
                <a href="<?php echo e(route('customer.checkout')); ?>" class="btn btn-success w-100 rounded-pill py-2 mb-2">
                    <i class="bi bi-bag-check me-2"></i>Checkout Sekarang
                </a>
                
                <a href="<?php echo e(route('customer.catalog')); ?>" class="btn btn-outline-secondary w-100 rounded-pill py-2">
                    <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                </a>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-cart-x display-1 text-muted"></i>
        </div>
        <h4 class="text-muted mb-3">Keranjang Belanja Kosong</h4>
        <p class="text-muted mb-4">Yuk mulai belanja paket catering untuk acara Anda!</p>
        <a href="<?php echo e(route('customer.catalog')); ?>" class="btn btn-success btn-lg rounded-pill px-5">
            <i class="bi bi-grid me-2"></i>Lihat Katalog
        </a>
    </div>
    <?php endif; ?>
</div>

<style>
    .card-modern {
        background: white;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }
    .cart-item-row:last-child {
        border-bottom: none !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/customer/cart/index.blade.php ENDPATH**/ ?>