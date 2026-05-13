<?php $__env->startSection('title', 'Metode Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Metode Pembayaran</h4>
        <p class="text-muted mb-0">Kelola metode pembayaran yang tersedia</p>
    </div>
    <a href="<?php echo e(route('jenis-pembayaran.create')); ?>" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-circle me-2"></i>Tambah Jenis
    </a>
</div>

<div class="card-modern p-4">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th class="ps-4">No</th>
                    <th>Metode Pembayaran</th>
                    <th>Deskripsi</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $jenisPembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $jp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4 fw-bold text-muted small"><?php echo e($index + 1); ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <?php if(str_contains(strtolower($jp->metode_pembayaran), 'cod') || str_contains(strtolower($jp->metode_pembayaran), 'bayar')): ?>
                                <div class="bg-success bg-opacity-10 rounded-circle p-2"><i class="bi bi-cash-coin text-success"></i></div>
                            <?php elseif(str_contains(strtolower($jp->metode_pembayaran), 'transfer')): ?>
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2"><i class="bi bi-bank text-primary"></i></div>
                            <?php else: ?>
                                <div class="bg-info bg-opacity-10 rounded-circle p-2"><i class="bi bi-wallet2 text-info"></i></div>
                            <?php endif; ?>
                            <div>
                                <div class="fw-bold text-dark"><?php echo e($jp->metode_pembayaran); ?></div>
                                <div class="small text-muted"><?php echo e(Str::limit($jp->deskripsi ?? 'Deskripsi tidak tersedia', 50)); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted"><?php echo e($jp->deskripsi ?? '-'); ?></td>
                    <td class="pe-4 text-end">
                        <div class="btn-group">
                            <a href="<?php echo e(route('jenis-pembayaran.edit', $jp->id)); ?>" class="btn btn-sm btn-light text-warning">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="<?php echo e(route('jenis-pembayaran.destroy', $jp->id)); ?>" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Yakin ingin menghapus metode ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-light text-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3" class="text-center py-4 text-muted">Belum ada metode pembayaran</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/jenis-pembayaran/index.blade.php ENDPATH**/ ?>