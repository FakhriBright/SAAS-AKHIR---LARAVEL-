<?php $__env->startSection('title', 'Detail Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Detail Rekening</h4>
        <p class="text-muted mb-0">Kelola detail rekening untuk transfer</p>
    </div>
    <a href="<?php echo e(route('detail-jenis-pembayaran.create')); ?>" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-circle me-2"></i>Tambah Detail
    </a>
</div>

<div class="card-modern p-4">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th class="ps-4">No</th>
                    <th>Jenis Pembayaran</th>
                    <th>No. Rekening / Kode</th>
                    <th>Nama Pemilik</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $detailPembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4 fw-bold text-muted small"><?php echo e($index + 1); ?></td>
                    <td class="fw-bold"><?php echo e($detail->jenisPembayaran->metode_pembayaran ?? '-'); ?></td>
                    
                    <td><span class="bg-light px-2 py-1 rounded text-dark fw-bold font-monospace"><?php echo e($detail->no_rek ?? $detail->nomor_rekening ?? '-'); ?></span></td>
                    <td><?php echo e($detail->tempat_bayar ?? $detail->nama_pemilik ?? '-'); ?></td>
                    <td class="pe-4 text-end">
                        <div class="btn-group">
                            <a href="<?php echo e(route('detail-jenis-pembayaran.edit', $detail->id)); ?>" class="btn btn-sm btn-light text-warning"><i class="bi bi-pencil-fill"></i></a>
                            <form action="<?php echo e(route('detail-jenis-pembayaran.destroy', $detail->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus detail ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash-fill"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada detail rekening</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/detail-jenis-pembayaran/index.blade.php ENDPATH**/ ?>