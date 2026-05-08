<?php $__env->startSection('title', 'Riwayat Pesanan - Fakhri Kitchen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-clock-history text-primary me-2"></i>Riwayat Pesanan</h2>
            <p class="text-muted mb-0">Lihat semua pesanan yang pernah Anda buat</p>
        </div>
        <a href="<?php echo e(route('customer.order.create')); ?>" class="btn btn-fk-primary">
            <i class="bi bi-plus-circle me-1"></i> Buat Pesanan Baru
        </a>
    </div>

    
    <div class="card fk-card mb-4">
        <div class="card-body py-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0" id="searchOrder" placeholder="Cari no. resi...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                        <option value="Sedang Diproses">Sedang Diproses</option>
                        <option value="Menunggu Kurir">Menunggu Kurir</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-fk-outline w-100" onclick="resetFilter()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card fk-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">NO. RESI</th>
                        <th>TANGGAL</th>
                        <th>PAKET</th>
                        <th>METODE BAYAR</th>
                        <th>TOTAL</th>
                        <th>STATUS</th>
                        <th class="pe-4 text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="order-row" data-status="<?php echo e($order->status_pesan); ?>">
                        <td class="ps-4 fw-bold text-primary"><?php echo e($order->no_resi); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($order->tgl_pesan)->format('d/m/Y')); ?></td>
                        <td>
                            <strong><?php echo e($order->detailPemesanans->first()->paket->nama_paket ?? '-'); ?></strong>
                            <?php if($order->detailPemesanans->count() > 1): ?>
                                <br><small class="text-muted">+<?php echo e($order->detailPemesanans->count() - 1); ?> lainnya</small>
                            <?php endif; ?>
                        </td>
                        <td><small><?php echo e($order->jenisPembayaran->metode_pembayaran ?? '-'); ?></small></td>
                        <td class="fw-bold text-success">Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></td>
                        <td>
                            <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?> <span class="fk-badge bg-warning text-dark">Menunggu</span>
                            <?php elseif($order->status_pesan == 'Sedang Diproses'): ?> <span class="fk-badge bg-info text-dark">Diproses</span>
                            <?php elseif($order->status_pesan == 'Menunggu Kurir'): ?> <span class="fk-badge bg-secondary">Kurir</span>
                            <?php elseif($order->status_pesan == 'Selesai'): ?> <span class="fk-badge bg-success">Selesai</span>
                            <?php elseif($order->status_pesan == 'Dibatalkan'): ?> <span class="fk-badge bg-danger">Dibatalkan</span>
                            <?php else: ?> <span class="fk-badge bg-secondary"><?php echo e($order->status_pesan); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="<?php echo e(route('customer.order.detail', $order->id)); ?>" class="btn btn-fk-outline btn-sm">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                                <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?>
                                <form action="<?php echo e(route('customer.order.cancel', $order->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm text-danger border-danger rounded-pill px-3" style="background:transparent;">
                                        <i class="bi bi-x-circle me-1"></i> Batal
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada pesanan. <a href="<?php echo e(route('customer.order.create')); ?>" class="fw-bold text-primary">Pesan sekarang!</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($orders->hasPages()): ?>
        <div class="card-footer bg-white border-0 py-3">
            <?php echo e($orders->links('pagination::bootstrap-5')); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('searchOrder')?.addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        document.querySelectorAll('.order-row').forEach(r => r.style.display = r.textContent.toLowerCase().includes(val) ? '' : 'none');
    });
    document.getElementById('filterStatus')?.addEventListener('change', function() {
        let st = this.value;
        document.querySelectorAll('.order-row').forEach(r => r.style.display = (!st || r.dataset.status === st) ? '' : 'none');
    });
    function resetFilter() {
        document.getElementById('searchOrder').value = '';
        document.getElementById('filterStatus').value = '';
        document.querySelectorAll('.order-row').forEach(r => r.style.display = '');
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR-LARAVEL\resources\views/customer/orders.blade.php ENDPATH**/ ?>