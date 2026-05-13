<?php $__env->startSection('title', 'Pengiriman'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Pengiriman</h4>
        <p class="text-muted mb-0">Monitoring status pengiriman kurir.</p>
    </div>
</div>

<div class="card-modern p-4">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Kurir</th>
                    <th>No. Resi</th>
                    <th>Tgl Kirim</th>
                    <th>Tgl Tiba</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pengirimans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kirim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 35px; height: 35px;">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="fw-bold"><?php echo e($kirim->user->name ?? 'Admin'); ?></div>
                        </div>
                    </td>
                    <td class="fw-bold text-primary"><?php echo e($kirim->pemesanan->no_resi ?? '-'); ?></td>
                    <td><?php echo e($kirim->tgl_kirim->format('d/m/Y')); ?></td>
                    <td><?php echo e($kirim->tgl_tiba ? $kirim->tgl_tiba->format('d/m/Y') : '-'); ?></td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                            <?php echo e($kirim->status_kirim); ?>

                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <a href="<?php echo e(route('pengirimans.show', $kirim->id)); ?>" class="btn btn-sm btn-light text-primary">
                            <i class="bi bi-eye me-1"></i> Detail
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data pengiriman.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/pengirimans/index.blade.php ENDPATH**/ ?>