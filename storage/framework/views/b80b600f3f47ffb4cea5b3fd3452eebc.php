<?php $__env->startSection('title', 'Data Pelanggan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-people"></i> Data Pelanggan</h2>
            <p class="text-muted mb-0">Kelola data pelanggan catering</p>
        </div>
        <a href="<?php echo e(route('pelanggans.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pelanggan
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
                            <th width="20%">Nama Pelanggan</th>
                            <th width="20%">Email</th>
                            <th width="12%">No. Telepon</th>
                            <th width="28%">Alamat</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pelanggans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td class="fw-semibold"><?php echo e($p->nama_pelanggan); ?></td>
                            <td><?php echo e($p->email); ?></td>
                            <td><?php echo e($p->telepon); ?></td>
                            <td>
                                
                                <?php echo e($p->alamat1); ?>

                                <?php if($p->alamat2): ?>, <?php echo e($p->alamat2); ?><?php endif; ?>
                                <?php if($p->alamat3): ?>, <?php echo e($p->alamat3); ?><?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?php echo e(route('pelanggans.edit', $p->id)); ?>"
                                       class="btn btn-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="<?php echo e(route('pelanggans.destroy', $p->id)); ?>"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
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
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada data pelanggan</p>
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

<?php $__env->startPush('styles'); ?>
<style>
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\catering-online\resources\views/pelanggans/index.blade.php ENDPATH**/ ?>