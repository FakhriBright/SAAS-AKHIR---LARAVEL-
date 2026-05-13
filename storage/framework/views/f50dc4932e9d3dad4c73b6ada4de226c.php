<?php $__env->startSection('title', 'Pengiriman'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Pengiriman</h4>
        <p class="text-muted mb-0">Monitoring status pengiriman kurir.</p>
    </div>
    <a href="<?php echo e(route('pengirimans.create')); ?>" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-circle me-2"></i>Tambah Pengiriman
    </a>
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
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pengirimans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengiriman): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-light rounded-circle p-2">
                                <i class="bi bi-person text-dark"></i>
                            </div>
                            
                            <span class="fw-bold"><?php echo e($pengiriman->user->name ?? $pengiriman->user->nama_pelanggan ?? '-'); ?></span>
                        </div>
                    </td>
                    <td>
                        <a href="<?php echo e(route('pemesanans.show', $pengiriman->pemesanan->id)); ?>" class="text-primary fw-bold text-decoration-none">
                            <?php echo e($pengiriman->pemesanan->no_resi ?? '-'); ?>

                        </a>
                    </td>
                    
                    <td><?php echo e($pengiriman->tgl_kirim ? $pengiriman->tgl_kirim->format('d/m/Y') : '-'); ?></td>
                    <td><?php echo e($pengiriman->tgl_tiba ? $pengiriman->tgl_tiba->format('d/m/Y') : '-'); ?></td>
                    <td>
                        
                        <?php
                            $statusClass = match($pengiriman->status_kirim) {
                                'Menunggu Kurir' => 'secondary',
                                'Sedang Dikirim' => 'primary',
                                'Tiba Ditujuan' => 'success',
                                default => 'light'
                            };
                        ?>
                        <span class="badge bg-<?php echo e($statusClass); ?> bg-opacity-10 text-<?php echo e($statusClass); ?> px-2 py-1 rounded-pill small">
                            <?php echo e($pengiriman->status_kirim); ?>

                        </span>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="btn-group">
                            <a href="<?php echo e(route('pengirimans.edit', $pengiriman->id)); ?>" class="btn btn-sm btn-light text-warning"><i class="bi bi-pencil-fill"></i></a>
                            <a href="<?php echo e(route('pengirimans.show', $pengiriman->id)); ?>" class="btn btn-sm btn-light text-primary"><i class="bi bi-eye"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data pengiriman</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/pengirimans/index.blade.php ENDPATH**/ ?>