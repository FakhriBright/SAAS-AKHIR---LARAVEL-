<?php $__env->startSection('title', 'Riwayat Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-list-check"></i> Riwayat Pesanan</h2>
            <p class="text-muted mb-0">Lihat semua pesanan catering Anda</p>
        </div>
        <a href="<?php echo e(route('customer.order.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Pesan Sekarang
        </a>
    </div>

    
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="searchOrder" placeholder="Cari no. resi atau paket...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                        <option value="Sedang Diproses">Sedang Diproses</option>
                        <option value="Menunggu Kurir">Menunggu Kurir</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100" onclick="resetFilter()">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="ordersTable">
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
                            <td class="ps-4">
                                <span class="fw-bold"><?php echo e($order->no_resi); ?></span>
                            </td>
                            <td><?php echo e($order->tgl_pesan->format('d/m/Y')); ?></td>
                            <td>
                                <?php $__currentLoopData = $order->detailPemesanans->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="small"><?php echo e($detail->paket->nama_paket ?? '-'); ?></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($order->detailPemesanans->count() > 2): ?>
                                    <div class="small text-muted">+<?php echo e($order->detailPemesanans->count() - 2); ?> lainnya</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted"><?php echo e($order->jenisPembayaran->metode_pembayaran ?? '-'); ?></small>
                            </td>
                            <td class="fw-bold text-primary">
                                Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?>

                            </td>
                            <td>
                                <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?>
                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                <?php elseif($order->status_pesan == 'Sedang Diproses'): ?>
                                    <span class="badge bg-info text-dark">Sedang Diproses</span>
                                <?php elseif($order->status_pesan == 'Menunggu Kurir'): ?>
                                    <span class="badge bg-secondary">Menunggu Kurir</span>
                                <?php elseif($order->status_pesan == 'Selesai'): ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <?php if($order && $order->id): ?>
                                <a href="<?php echo e(route('customer.order.detail', $order->id)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <?php else: ?>
                                <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox display-4 text-muted d-block mb-3"></i>
                                <p class="text-muted mb-3">Belum ada pesanan</p>
                                <a href="<?php echo e(route('customer.order.create')); ?>" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Buat Pesanan Pertama
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
    // Custom search & filter
    document.getElementById('searchOrder').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        document.querySelectorAll('.order-row').forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });

    document.getElementById('filterStatus').addEventListener('change', function() {
        let status = this.value;
        document.querySelectorAll('.order-row').forEach(row => {
            if (status === '' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    function resetFilter() {
        document.getElementById('searchOrder').value = '';
        document.getElementById('filterStatus').value = '';
        document.querySelectorAll('.order-row').forEach(row => {
            row.style.display = '';
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        color: #666;
    }
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\catering-online\resources\views/customer/orders.blade.php ENDPATH**/ ?>