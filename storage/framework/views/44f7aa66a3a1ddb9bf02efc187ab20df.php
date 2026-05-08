<?php $__env->startSection('title', 'Data Paket Catering'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-box-seam me-2"></i>Data Paket Catering</h2>
            <p class="text-muted mb-0">Kelola semua paket catering yang tersedia</p>
        </div>
        <a href="<?php echo e(route('pakets.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Paket
        </a>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Paket</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th>Pax</th>
                            <th>Kategori</th>
                            <th class="text-center">Foto</th>
                            <th class="pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4"><?php echo e($pakets->firstItem() + $index); ?></td>
                            <td>
                                <strong><?php echo e($paket->nama_paket); ?></strong>
                                <br><small class="text-muted"><?php echo e(Str::limit($paket->deskripsi, 50)); ?></small>
                            </td>
                            <td><span class="badge bg-info"><?php echo e($paket->jenis); ?></span></td>
                            <td class="fw-bold text-success">Rp <?php echo e(number_format($paket->harga_paket, 0, ',', '.')); ?></td>
                            <td><?php echo e($paket->jumlah_pax); ?> Pax</td>
                            <td><?php echo e($paket->kategori ?? '-'); ?></td>
                            <td class="text-center">
                                <?php if($paket->foto1): ?>
                                    <img src="<?php echo e(asset('storage/' . $paket->foto1)); ?>" alt="Foto" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group">
                                    <a href="<?php echo e(route('pakets.edit', $paket->id)); ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('pakets.destroy', $paket->id)); ?>" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada data paket
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($pakets->hasPages()): ?>
        <div class="card-footer bg-white border-0 py-3">
            <?php echo e($pakets->links('pagination::bootstrap-5')); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/pakets/index.blade.php ENDPATH**/ ?>