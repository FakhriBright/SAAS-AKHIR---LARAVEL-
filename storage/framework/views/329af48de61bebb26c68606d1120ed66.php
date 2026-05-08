<?php $__env->startSection('title', 'Jenis Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-credit-card"></i> Jenis Pembayaran</h2>
            <p class="text-muted mb-0">Kelola metode pembayaran</p>
        </div>
        <a href="<?php echo e(route('jenis-pembayaran.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Jenis
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
                            <th width="40%">Metode Pembayaran</th>
                            <th width="25%">Jumlah Detail</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $jenisPembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>  
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td class="fw-semibold"><?php echo e($jp->metode_pembayaran); ?></td>
                            <td>
                                
                                <span class="badge bg-info">
                                    <?php echo e($jp->detailJenisPembayarans->count()); ?> detail
                                </span>
                                <?php if($jp->detailJenisPembayarans->count() > 0): ?>
                                    <small class="text-muted d-block mt-1">
                                        <?php $__currentLoopData = $jp->detailJenisPembayarans->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($detail->no_rek ?: 'Tanpa No. Rek'); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($jp->detailJenisPembayarans->count() > 2): ?>
                                            <span class="text-muted">+<?php echo e($jp->detailJenisPembayarans->count() - 2); ?> lainnya</span>
                                        <?php endif; ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?php echo e(route('jenis-pembayaran.edit', $jp->id)); ?>"
                                       class="btn btn-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?php echo e(route('detail-jenis-pembayaran.create')); ?>?jenis=<?php echo e($jp->id); ?>"
                                       class="btn btn-success"
                                       title="Tambah Detail">
                                        <i class="bi bi-plus-circle"></i>
                                    </a>
                                    <form action="<?php echo e(route('jenis-pembayaran.destroy', $jp->id)); ?>"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada data jenis pembayaran</p>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/jenis-pembayaran/index.blade.php ENDPATH**/ ?>