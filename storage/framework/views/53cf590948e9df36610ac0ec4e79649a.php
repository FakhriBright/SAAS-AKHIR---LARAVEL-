<?php $__env->startSection('title', 'Tambah Pengiriman'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card-modern p-4" style="max-width: 800px; margin: 0 auto;">
        <h4 class="fw-bold mb-4"><i class="bi bi-truck me-2 text-primary"></i>Tambah Pengiriman</h4>
        
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
        
        <form action="<?php echo e(route('pengirimans.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Pesanan <span class="text-danger">*</span></label>
                
                <select name="pemesanan_id" class="form-select" required>
                    <option value="">-- Pilih Pesanan --</option>
                    <?php $__currentLoopData = $pemesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pemesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($pemesanan->id); ?>" <?php echo e(old('pemesanan_id') == $pemesanan->id ? 'selected' : ''); ?>>
                        <?php echo e($pemesanan->no_resi); ?> - <?php echo e($pemesanan->pelanggan->nama_pelanggan ?? 'Pelanggan'); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Kurir <span class="text-danger">*</span></label>
                
                <select name="id_user" class="form-select" required>
                    <option value="">-- Pilih Kurir --</option>
                    <?php $__currentLoopData = $kurirs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kurir): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($kurir->id); ?>" <?php echo e(old('id_user') == $kurir->id ? 'selected' : ''); ?>>
                        <?php echo e($kurir->name ?? $kurir->nama_kurir ?? $kurir->nama_pelanggan ?? 'Kurir'); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    
                    <label class="form-label fw-bold">Tanggal Kirim <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_kirim" class="form-control" value="<?php echo e(old('tgl_kirim', date('Y-m-d'))); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    
                    <label class="form-label fw-bold">Tanggal Tiba (Opsional)</label>
                    <input type="date" name="tgl_tiba" class="form-control" value="<?php echo e(old('tgl_tiba')); ?>">
                </div>
            </div>
            
            <div class="mb-3">
                
                <label class="form-label fw-bold">Status Pengiriman</label>
                <select name="status_kirim" class="form-select">
                    <option value="Menunggu Kurir" <?php echo e(old('status_kirim') == 'Menunggu Kurir' ? 'selected' : ''); ?>>Menunggu Kurir</option>
                    <option value="Sedang Dikirim" <?php echo e(old('status_kirim') == 'Sedang Dikirim' ? 'selected' : ''); ?>>Sedang Dikirim</option>
                    <option value="Tiba Ditujuan" <?php echo e(old('status_kirim') == 'Tiba Ditujuan' ? 'selected' : ''); ?>>Tiba Ditujuan</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Bukti Foto (Opsional)</label>
                <input type="file" name="bukti_foto" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-2"></i>Simpan
                </button>
                <a href="<?php echo e(route('pengirimans.index')); ?>" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/pengirimans/create.blade.php ENDPATH**/ ?>