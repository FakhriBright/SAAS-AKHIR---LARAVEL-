<?php $__env->startSection('title', 'Kelola Paket'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Kelola Paket</h4>
        <p class="text-muted mb-0">Manajemen katalog paket catering.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="<?php echo e(route('pakets.create')); ?>" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i>Tambah Paket
        </a>
    </div>
</div>

<div class="card-modern p-4">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Nama Paket</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Jumlah Pax</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-2 text-primary">
                                <i class="bi bi-box-seam fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold"><?php echo e($paket->nama_paket); ?></div>
                                <small class="text-muted"><?php echo e(Str::limit($paket->deskripsi, 30)); ?></small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border px-3 py-2 rounded-pill"><?php echo e($paket->kategori); ?></span></td>
                    <td class="fw-bold text-success">Rp <?php echo e(number_format($paket->harga_paket, 0, ',', '.')); ?></td>
                    <td><?php echo e($paket->jumlah_pax); ?> Pax</td>
                    <td class="text-end pe-4">
                        <div class="btn-group">
                            <a href="<?php echo e(route('pakets.edit', $paket->id)); ?>" class="btn btn-sm btn-light text-primary"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('pakets.destroy', $paket->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data paket.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\saas-akhir\resources\views/pakets/index.blade.php ENDPATH**/ ?>