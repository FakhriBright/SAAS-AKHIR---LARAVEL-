<?php $__env->startSection('title', 'Riwayat Pesanan - Fakhri Kitchen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
        
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--primary-dark);">
                <i class="bi bi-clock-history me-2"></i>Riwayat Pesanan
            </h2>
            <p class="text-muted mb-0">Lihat semua pesanan yang pernah Anda buat</p>
        </div>
        <a href="<?php echo e(route('customer.order.create')); ?>" class="btn btn-fk-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-2"></i>Buat Pesanan Baru
        </a>
    </div>

    
    <div class="card fk-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchOrder" 
                               placeholder="Cari no. resi...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select form-select-lg" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Konfirmasi">⏳ Menunggu Konfirmasi</option>
                        <option value="Sedang Diproses">⚙️ Sedang Diproses</option>
                        <option value="Menunggu Kurir">🚚 Menunggu Kurir</option>
                        <option value="Selesai">✅ Selesai</option>
                        <option value="Dibatalkan">❌ Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-fk-outline w-100 btn-lg" onclick="resetFilter()">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card fk-card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);">
                        <tr>
                            <th class="ps-4 py-3 small text-uppercase text-muted fw-semibold">No. Resi</th>
                            <th class="py-3 small text-uppercase text-muted fw-semibold">Tanggal</th>
                            <th class="py-3 small text-uppercase text-muted fw-semibold">Paket</th>
                            <th class="py-3 small text-uppercase text-muted fw-semibold">Metode Bayar</th>
                            <th class="py-3 small text-uppercase text-muted fw-semibold">Total</th>
                            <th class="py-3 small text-uppercase text-muted fw-semibold">Status</th>
                            <th class="pe-4 text-end py-3 small text-uppercase text-muted fw-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="order-row border-bottom-light" data-status="<?php echo e($order->status_pesan); ?>">
                            <td class="ps-4 py-3">
                                <span class="fw-bold" style="color: var(--primary);"><?php echo e($order->no_resi); ?></span>
                            </td>
                            <td class="py-3">
                                <div>
                                    <div class="fw-medium"><?php echo e(\Carbon\Carbon::parse($order->tgl_pesan)->format('d/m/Y')); ?></div>
                                    <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($order->tgl_pesan)->diffForHumans()); ?></small>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="fw-medium"><?php echo e($order->detailPemesanans->first()->paket->nama_paket ?? '-'); ?></div>
                                <?php if($order->detailPemesanans->count() > 1): ?>
                                    <small class="text-muted">+<?php echo e($order->detailPemesanans->count() - 1); ?> paket lain</small>
                                <?php endif; ?>
                            </td>
                            <td class="py-3">
                                <small class="text-muted"><?php echo e($order->jenisPembayaran->metode_pembayaran ?? '-'); ?></small>
                            </td>
                            <td class="py-3">
                                <span class="fw-bold text-success" style="font-size: 1.1rem;">
                                    Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?>

                                </span>
                            </td>
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
                                        <i class="bi bi-x-circle me-1"></i>Dibatalkan
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end py-3">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="<?php echo e(route('customer.order.detail', $order->id)); ?>" class="btn btn-sm btn-fk-outline rounded-pill px-3">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                    <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?>
                                    <form action="<?php echo e(route('customer.order.cancel', $order->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" 
                                                onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                            <i class="bi bi-x-circle me-1"></i>Batal
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex p-5 mb-3">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                </div>
                                <h5 class="text-muted mb-2">Belum ada pesanan</h5>
                                <p class="text-muted mb-4">Mulai pesan catering favorit Anda sekarang!</p>
                                <a href="<?php echo e(route('customer.order.create')); ?>" class="btn btn-fk-primary btn-lg rounded-pill px-4">
                                    <i class="bi bi-plus-circle me-2"></i>Pesan Sekarang
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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
        document.querySelectorAll('.order-row').forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(val) ? '' : 'none';
        });
    });
    
    document.getElementById('filterStatus')?.addEventListener('change', function() {
        let st = this.value;
        document.querySelectorAll('.order-row').forEach(r => {
            r.style.display = (!st || r.dataset.status === st) ? '' : 'none';
        });
    });
    
    function resetFilter() {
        document.getElementById('searchOrder').value = '';
        document.getElementById('filterStatus').value = '';
        document.querySelectorAll('.order-row').forEach(r => r.style.display = '');
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/customer/orders.blade.php ENDPATH**/ ?>