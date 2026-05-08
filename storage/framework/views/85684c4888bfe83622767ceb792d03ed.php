<?php $__env->startSection('title', 'Profil Saya - Fakhri Kitchen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="fw-bold mb-4"><i class="bi bi-person-circle text-primary me-2"></i>Profil Saya</h2>

            <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>

            <div class="card fk-card">
                <div class="card-body p-4 p-md-5">
                    <form action="<?php echo e(route('customer.profile.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Nama Lengkap</label>
                                <input type="text" name="nama_pelanggan" class="form-control" value="<?php echo e(old('nama_pelanggan', $pelanggan->nama_pelanggan)); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Email (Read Only)</label>
                                <input type="email" class="form-control" value="<?php echo e($pelanggan->email); ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Nomor Telepon</label>
                                <input type="tel" name="telepon" class="form-control" value="<?php echo e(old('telepon', $pelanggan->telepon)); ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium">Alamat Lengkap</label>
                                <textarea name="alamat1" class="form-control" rows="2" required><?php echo e(old('alamat1', $pelanggan->alamat1)); ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Kelurahan/Kecamatan</label>
                                <input type="text" name="alamat2" class="form-control" value="<?php echo e(old('alamat2', $pelanggan->alamat2)); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Kota/Kabupaten</label>
                                <input type="text" name="alamat3" class="form-control" value="<?php echo e(old('alamat3', $pelanggan->alamat3)); ?>">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-fk-primary px-4"><i class="bi bi-check-circle me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR-LARAVEL\resources\views/customer/profile.blade.php ENDPATH**/ ?>