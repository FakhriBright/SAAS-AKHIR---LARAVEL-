<?php $__env->startSection('title', 'Data Pelanggan'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Data Pelanggan</h4>
        <p class="text-muted mb-0">Database pelanggan terdaftar.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="<?php echo e(route('pelanggans.create')); ?>" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-person-plus me-2"></i>Tambah Pelanggan
        </a>
    </div>
</div>

<div class="card-modern p-4">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Pelanggan</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pelanggans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelanggan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-info fw-bold" style="width: 40px; height: 40px;">
                                <?php echo e(strtoupper(substr($pelanggan->nama_pelanggan, 0, 1))); ?>

                            </div>
                            <div class="fw-bold"><?php echo e($pelanggan->nama_pelanggan); ?></div>
                        </div>
                    </td>
                    <td><?php echo e($pelanggan->email); ?></td>
                    <td><?php echo e($pelanggan->telepon); ?></td>
                    <td class="text-muted small"><?php echo e(Str::limit($pelanggan->alamat1, 40)); ?></td>
                    <td class="text-end pe-4">
                        <div class="btn-group">
                            <a href="<?php echo e(route('pelanggans.edit', $pelanggan->id)); ?>" class="btn btn-sm btn-light text-primary"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('pelanggans.destroy', $pelanggan->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus pelanggan?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data pelanggan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\saas-akhir\resources\views/pelanggans/index.blade.php ENDPATH**/ ?>