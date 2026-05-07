<?php $__env->startSection('title', 'Detail Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-credit-card-2-front"></i> Detail Pembayaran</h2>
            <p class="text-muted mb-0">Kelola detail metode pembayaran</p>
        </div>
        <a href="<?php echo e(route('detail-jenis-pembayaran.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Detail
        </a>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Jenis Pembayaran</th>
                            <th width="20%">No. Rekening / Kode</th>
                            <th width="30%">Tempat / Instruksi</th>
                            <th width="10%">Logo</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td class="fw-semibold"><?php echo e($d->jenisPembayaran->metode_pembayaran ?? '-'); ?></td>
                            <td><?php echo e($d->no_rek ?? '-'); ?></td>
                            <td><?php echo e(Str::limit($d->tempat_bayar, 40) ?? '-'); ?></td>
                            <td>
                                <?php if($d->logo): ?>
                                    <img src="<?php echo e(Storage::url($d->logo)); ?>" alt="Logo"
                                         class="img-thumbnail" style="max-width: 60px; max-height: 40px;">
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo e(route('detail-jenis-pembayaran.edit', $d->id)); ?>" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('detail-jenis-pembayaran.destroy', $d->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada detail pembayaran</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\catering-online\resources\views/detail-jenis-pembayaran/index.blade.php ENDPATH**/ ?>