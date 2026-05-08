<?php $__env->startSection('title', 'Detail Pesanan - Fakhri Kitchen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex align-items-center mb-4">
                <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-fk-outline me-3"><i class="bi bi-arrow-left"></i></a>
                <div>
                    <h2 class="fw-bold mb-1">Detail Pesanan</h2>
                    <p class="text-muted mb-0">No. Resi: <strong class="text-primary"><?php echo e($order->no_resi); ?></strong></p>
                </div>
            </div>

            
            <div class="card fk-card mb-4">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-block mb-2"><i class="bi bi-calendar-check fs-4 text-success"></i></div>
                            <p class="text-muted small mb-0">Tanggal</p>
                            <p class="fw-bold mb-0"><?php echo e($order->tgl_pesan->format('d/m/Y')); ?></p>
                        </div>
                        <div class="col-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-inline-block mb-2"><i class="bi bi-clock-history fs-4 text-warning"></i></div>
                            <p class="text-muted small mb-0">Status</p>
                            <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?> <span class="fk-badge bg-warning text-dark">Menunggu</span>
                            <?php elseif($order->status_pesan == 'Sedang Diproses'): ?> <span class="fk-badge bg-info text-dark">Diproses</span>
                            <?php elseif($order->status_pesan == 'Selesai'): ?> <span class="fk-badge bg-success">Selesai</span>
                            <?php else: ?> <span class="fk-badge bg-danger">Dibatalkan</span>
                            <?php endif; ?>
                        </div>
                        <div class="col-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-block mb-2"><i class="bi bi-cash-coin fs-4 text-success"></i></div>
                            <p class="text-muted small mb-0">Total</p>
                            <p class="fw-bold text-success mb-0">Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></p>
                        </div>
                        <div class="col-3">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 d-inline-block mb-2"><i class="bi bi-credit-card fs-4 text-info"></i></div>
                            <p class="text-muted small mb-0">Pembayaran</p>
                            <p class="fw-bold mb-0"><?php echo e($order->jenisPembayaran->metode_pembayaran ?? '-'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card fk-card mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4"><h5 class="mb-0 fw-bold"><i class="bi bi-box-seam text-primary me-2"></i>Rincian Paket</h5></div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light"><tr><th class="ps-4">Paket</th><th class="text-center">Jumlah</th><th class="text-end">Harga</th><th class="text-end">Subtotal</th></tr></thead>
                        <tbody>
                            <?php $__currentLoopData = $order->detailPemesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="ps-4"><strong><?php echo e($d->paket->nama_paket ?? '-'); ?></strong></td>
                                <td class="text-center"><span class="fk-badge bg-primary"><?php echo e($d->jumlah); ?></span></td>
                                <td class="text-end">Rp <?php echo e(number_format($d->paket->harga ?? 0, 0, ',', '.')); ?></td>
                                <td class="text-end fw-bold text-success">Rp <?php echo e(number_format($d->subtotal, 0, ',', '.')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot class="bg-light"><tr><th colspan="3" class="text-end ps-4">Total:</th><th class="text-end pe-4 fs-5 fw-bold text-success">Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></th></tr></tfoot>
                    </table>
                </div>
            </div>

            <?php if($order->catatan): ?>
            <div class="card fk-card mb-4">
                <div class="card-body p-4"><h6 class="fw-bold mb-2"><i class="bi bi-chat-left-text me-2 text-primary"></i>Catatan Pelanggan</h6><p class="mb-0 text-muted"><?php echo e($order->catatan); ?></p></div>
            </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between">
                <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-fk-outline">Kembali</a>
                <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?>
                <form action="<?php echo e(route('customer.order.cancel', $order->id)); ?>" method="POST" onsubmit="return confirm('Yakin batalkan pesanan ini?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle me-1"></i> Batalkan Pesanan</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR-LARAVEL\resources\views/customer/order/detail.blade.php ENDPATH**/ ?>