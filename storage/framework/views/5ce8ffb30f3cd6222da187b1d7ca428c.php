<?php $__env->startSection('title', 'Tambah Detail Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card-modern p-4" style="max-width: 800px; margin: 0 auto;">
        <h4 class="fw-bold mb-4">
            <i class="bi bi-plus-circle me-2 text-success"></i>Tambah Detail Pembayaran
        </h4>
        
        <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <form action="<?php echo e(route('detail-jenis-pembayaran.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Jenis Pembayaran <span class="text-danger">*</span></label>
                <select name="id_jenis_pembayaran" class="form-select" required>
                    <option value="">Pilih Jenis Pembayaran</option>
                    <?php $__currentLoopData = $jenisPembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($jp->id); ?>" <?php echo e(old('id_jenis_pembayaran') == $jp->id ? 'selected' : ''); ?>>
                        <?php echo e($jp->metode_pembayaran); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <small class="text-muted">Pilih jenis pembayaran yang sudah dibuat</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">No. Rekening / Kode <span class="text-danger">*</span></label>
                <input type="text" name="nomor_rekening" class="form-control" 
                       value="<?php echo e(old('nomor_rekening')); ?>" 
                       placeholder="Contoh: 1234567890" required>
                <small class="text-muted">Nomor rekening atau kode pembayaran</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Pemilik <span class="text-danger">*</span></label>
                <input type="text" name="nama_pemilik" class="form-control" 
                       value="<?php echo e(old('nama_pemilik')); ?>" 
                       placeholder="Contoh: Fakhri Kitchen" required>
                <small class="text-muted">Nama pemilik rekening</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Bank / Provider</label>
                <input type="text" name="bank" class="form-control" 
                       value="<?php echo e(old('bank')); ?>" 
                       placeholder="Contoh: BCA, Mandiri, GoPay, dll">
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Logo / Bukti Pembayaran</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-circle me-2"></i>Simpan
                </button>
                <a href="<?php echo e(route('detail-jenis-pembayaran.index')); ?>" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/detail-jenis-pembayaran/create.blade.php ENDPATH**/ ?>