<?php $__env->startSection('title', 'Edit Pengiriman'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card-modern p-4" style="max-width: 800px; margin: 0 auto;">
        <h4 class="fw-bold mb-4"><i class="bi bi-pencil me-2 text-warning"></i>Edit Pengiriman</h4>
        
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
        
        <form action="<?php echo e(route('pengirimans.update', $pengiriman->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Pesanan</label>
                <select name="pemesanan_id" class="form-select" required>
                    <option value="">-- Pilih Pesanan --</option>
                    <?php $__currentLoopData = $pemesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pemesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($pemesanan->id); ?>" <?php echo e(old('pemesanan_id', $pengiriman->pemesanan_id) == $pemesanan->id ? 'selected' : ''); ?>>
                        <?php echo e($pemesanan->no_resi); ?> - <?php echo e($pemesanan->pelanggan->nama_pelanggan ?? 'Pelanggan'); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Kirim</label>
                    <input type="date" name="tgl_kirim" class="form-control" value="<?php echo e(old('tgl_kirim', $pengiriman->tgl_kirim?->format('Y-m-d'))); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Tiba</label>
                    <input type="date" name="tgl_tiba" class="form-control" value="<?php echo e(old('tgl_tiba', $pengiriman->tgl_tiba?->format('Y-m-d'))); ?>">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Status Pengiriman</label>
                <select name="status_kirim" class="form-select" required>
                    <option value="Menunggu Kurir" <?php echo e(old('status_kirim', $pengiriman->status_kirim) == 'Menunggu Kurir' ? 'selected' : ''); ?>>Menunggu Kurir</option>
                    <option value="Sedang Dikirim" <?php echo e(old('status_kirim', $pengiriman->status_kirim) == 'Sedang Dikirim' ? 'selected' : ''); ?>>Sedang Dikirim</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Bukti Foto</label>
                <?php if($pengiriman->bukti_foto): ?>
                <div class="mb-2">
                    <img src="<?php echo e(Storage::url($pengiriman->bukti_foto)); ?>" alt="Bukti saat ini" class="img-thumbnail" style="max-width: 200px;">
                    <small class="text-muted d-block">Bukti saat ini</small>
                </div>
                <?php endif; ?>
                <input type="file" name="bukti_foto" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, PNG. Max: 2MB. Kosongkan jika tidak ingin mengubah.</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-pencil me-2"></i>Update
                </button>
                <a href="<?php echo e(route('pengirimans.index')); ?>" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/pengirimans/edit.blade.php ENDPATH**/ ?>