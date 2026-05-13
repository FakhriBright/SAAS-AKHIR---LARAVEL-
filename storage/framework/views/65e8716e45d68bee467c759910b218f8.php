<?php $__env->startSection('title', 'Edit Detail Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card-modern p-4" style="max-width: 800px; margin: 0 auto;">
        <h4 class="fw-bold mb-4">
            <i class="bi bi-pencil me-2 text-warning"></i>Edit Detail Pembayaran
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
        
        <form action="<?php echo e(route('detail-jenis-pembayaran.update', $detailJenisPembayaran->id)); ?>" 
              method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Jenis Pembayaran <span class="text-danger">*</span></label>
                <select name="id_jenis_pembayaran" class="form-select" required>
                    <option value="">Pilih Jenis Pembayaran</option>
                    <?php $__currentLoopData = $jenisPembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($jp->id); ?>" 
                            <?php echo e(old('id_jenis_pembayaran', $detailJenisPembayaran->id_jenis_pembayaran) == $jp->id ? 'selected' : ''); ?>>
                        <?php echo e($jp->metode_pembayaran); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">No. Rekening / Kode <span class="text-danger">*</span></label>
                
                <input type="text" name="nomor_rekening" class="form-control" 
                       value="<?php echo e(old('nomor_rekening', $detailJenisPembayaran->no_rek)); ?>" 
                       placeholder="Contoh: 1234567890" required>
                <small class="text-muted">Nomor rekening atau kode pembayaran</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Pemilik <span class="text-danger">*</span></label>
                
                <input type="text" name="nama_pemilik" class="form-control" 
                       value="<?php echo e(old('nama_pemilik', $detailJenisPembayaran->tempat_bayar)); ?>" 
                       placeholder="Contoh: Fakhri Kitchen" required>
                <small class="text-muted">Nama pemilik rekening</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Bank / Provider</label>
                <input type="text" name="bank" class="form-control" 
                       value="<?php echo e(old('bank', $detailJenisPembayaran->bank)); ?>" 
                       placeholder="Contoh: BCA, Mandiri, GoPay, dll">
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Logo / Bukti Pembayaran</label>
                <?php if($detailJenisPembayaran->logo): ?>
                <div class="mb-2">
                    <img src="<?php echo e(Storage::url($detailJenisPembayaran->logo)); ?>" 
                         alt="Logo saat ini" 
                         class="img-thumbnail" 
                         style="max-width: 150px;">
                    <small class="text-muted d-block">Logo saat ini</small>
                </div>
                <?php endif; ?>
                <input type="file" name="logo" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB. Kosongkan jika tidak ingin mengubah.</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-pencil me-2"></i>Update
                </button>
                <a href="<?php echo e(route('detail-jenis-pembayaran.index')); ?>" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/detail-jenis-pembayaran/edit.blade.php ENDPATH**/ ?>