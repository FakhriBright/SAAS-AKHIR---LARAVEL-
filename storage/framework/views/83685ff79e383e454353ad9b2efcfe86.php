<?php $__env->startSection('title', 'Pemesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Pemesanan</h4>
        <p class="text-muted mb-0">Kelola semua transaksi pemesanan.</p>
    </div>
</div>

<div class="card-modern p-4">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th class="ps-4">No. Resi</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pemesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4 fw-bold text-primary"><?php echo e($order->no_resi); ?></td>
                    <td>
                        <div class="fw-bold"><?php echo e($order->pelanggan->nama_pelanggan ?? '-'); ?></div>
                        <small class="text-muted"><?php echo e($order->pelanggan->telepon ?? ''); ?></small>
                    </td>
                    <td><?php echo e($order->tgl_pesan->format('d/m/Y')); ?></td>
                    <td class="fw-bold text-success">Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></td>
                    <td>
                        <?php
                        $statusClass = match($order->status_pesan) {
                            'Menunggu Konfirmasi' => 'warning',
                            'Sedang Diproses' => 'info',
                            'Menunggu Kurir' => 'secondary',
                            'Selesai' => 'success',
                            'Dibatalkan' => 'danger',
                            default => 'light'
                        };
                        ?>
                        <span class="badge bg-<?php echo e($statusClass); ?> bg-opacity-10 text-<?php echo e($statusClass); ?> px-3 py-2 rounded-pill">
                            <?php echo e($order->status_pesan); ?>

                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <a href="<?php echo e(route('pemesanans.show', $order->id)); ?>" class="btn btn-sm btn-light text-primary">
                            <i class="bi bi-eye me-1"></i> Detail
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada pemesanan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\saas-akhir\resources\views/pemesanans/index.blade.php ENDPATH**/ ?>