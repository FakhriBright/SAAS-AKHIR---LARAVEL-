
<?php $__env->startSection('title', 'Keranjang Belanja'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>Keranjang Belanja</h2>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <?php if($carts->count() > 0): ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card fk-card">
                <div class="card-body p-4">
                    <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            <input type="checkbox" class="form-check-input cart-check" value="<?php echo e($cart->id); ?>" data-subtotal="<?php echo e($cart->subtotal); ?>">
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1"><?php echo e($cart->paket->nama_paket); ?></h6>
                                <p class="text-muted small mb-0">Rp <?php echo e(number_format($cart->paket->harga_paket, 0, ',', '.')); ?> / porsi</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <form action="<?php echo e(route('customer.cart.update', $cart->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="jumlah" value="<?php echo e(max(1, $cart->jumlah - 1)); ?>">
                                <button type="submit" class="btn btn-sm btn-outline-secondary px-2"><i class="bi bi-dash"></i></button>
                            </form>
                            <span class="fw-bold px-2"><?php echo e($cart->jumlah); ?></span>
                            <form action="<?php echo e(route('customer.cart.update', $cart->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="jumlah" value="<?php echo e($cart->jumlah + 1); ?>">
                                <button type="submit" class="btn btn-sm btn-outline-secondary px-2"><i class="bi bi-plus"></i></button>
                            </form>
                        </div>
                        <div class="text-end" style="min-width: 100px;">
                            <span class="fw-bold text-success">Rp <?php echo e(number_format($cart->subtotal, 0, ',', '.')); ?></span>
                        </div>
                        <form action="<?php echo e(route('customer.cart.remove', $cart->id)); ?>" method="POST" class="ms-3">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <a href="<?php echo e(route('customer.catalog')); ?>" class="btn btn-fk-outline mt-3"><i class="bi bi-arrow-left me-2"></i>Lanjut Belanja</a>
        </div>

        <div class="col-lg-4">
            <div class="card fk-card sticky-top" style="top: 90px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Ringkasan Belanja</h5>
                    <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><span id="summary-subtotal">Rp 0</span></div>
                    <div class="d-flex justify-content-between mb-3 text-muted small"><span>Pajak & Ongkir</span><span>Gratis</span></div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4"><span class="fw-bold fs-5">Total</span><span class="fw-bold fs-5 text-primary" id="summary-total">Rp 0</span></div>
                    <button class="btn btn-fk-primary w-100 btn-lg" id="btn-checkout" disabled onclick="window.location.href='<?php echo e(route('customer.checkout')); ?>?cart_ids=' + getSelectedIds()">
                        <i class="bi bi-bag-check me-2"></i>Checkout
                    </button>
                    <small class="text-muted d-block text-center mt-2">Pilih item untuk checkout</small>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="text-center py-5">
        <i class="bi bi-cart-x fs-1 text-muted d-block mb-3"></i>
        <h4 class="fw-bold">Keranjang Masih Kosong</h4>
        <p class="text-muted mb-4">Yuk, pilih paket catering favoritmu!</p>
        <a href="<?php echo e(route('customer.catalog')); ?>" class="btn btn-fk-primary btn-lg px-4">Belanja Sekarang</a>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function getSelectedIds() { return Array.from(document.querySelectorAll('.cart-check:checked')).map(c => c.value).join(','); }
function updateSummary() {
    let total = 0; let count = 0;
    document.querySelectorAll('.cart-check:checked').forEach(c => { total += parseInt(c.dataset.subtotal); count++; });
    document.getElementById('summary-subtotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('summary-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('btn-checkout').disabled = count === 0;
}
document.querySelectorAll('.cart-check').forEach(c => c.addEventListener('change', updateSummary));
updateSummary();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/customer/cart/index.blade.php ENDPATH**/ ?>