<?php $__env->startSection('title', 'Update Pengiriman'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card-modern p-4" style="max-width: 600px; margin: 0 auto;">
        <h4 class="fw-bold mb-4">
            <i class="bi bi-truck me-2 text-primary"></i>Update Status Pengiriman
        </h4>
        
        <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?>
        
        
        <form action="<?php echo e(route('kurir.pengirimans.update', $pengiriman->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="mb-3">
                <label class="form-label fw-bold">No. Resi</label>
                <input type="text" class="form-control" value="<?php echo e($pengiriman->pemesanan->no_resi); ?>" disabled>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Status Saat Ini</label>
                <input type="text" class="form-control" value="<?php echo e($pengiriman->status_kirim); ?>" disabled>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Update Status <span class="text-danger">*</span></label>
                <select name="status_kirim" class="form-select" required>
                    <option value="Tiba Ditujuan" <?php echo e(old('status_kirim') == 'Tiba Ditujuan' ? 'selected' : ''); ?>>
                        Tiba Ditujuan ✅
                    </option>
                </select>
                <small class="text-muted">Kurir hanya bisa update status "Tiba Ditujuan"</small>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Upload Bukti Foto <span class="text-danger">*</span></label>
                <?php if($pengiriman->bukti_foto): ?>
                <div class="mb-2">
                    <img src="<?php echo e(Storage::url($pengiriman->bukti_foto)); ?>" class="img-thumbnail" style="max-width: 200px;">
                </div>
                <?php endif; ?>
                <input type="file" name="bukti_foto" class="form-control" accept="image/*" required>
                <small class="text-muted">Wajib upload foto sebagai bukti pengiriman</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-circle me-2"></i>Selesaikan Pengiriman
                </button>
                <a href="<?php echo e(route('kurir.pengirimans.index')); ?>" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\saas-akhir\resources\views/pengirimans/edit-kurir.blade.php ENDPATH**/ ?>