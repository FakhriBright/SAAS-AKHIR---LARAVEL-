  
<?php $__env->startSection('title', 'Edit Jenis Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Jenis Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('jenis-pembayaran.update', $jenisPembayaran->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <input type="text" name="metode_pembayaran" id="metode_pembayaran"
                                   class="form-control"
                                   value="<?php echo e(old('metode_pembayaran', $jenisPembayaran->metode_pembayaran)); ?>" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Update
                            </button>
                            <a href="<?php echo e(route('jenis-pembayaran.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/jenis-pembayaran/edit.blade.php ENDPATH**/ ?>