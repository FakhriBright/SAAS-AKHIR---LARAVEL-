<?php $__env->startSection('title', 'Daftar Akun - Fakhri Kitchen'); ?>

<?php $__env->startSection('content'); ?>
<section class="py-5" style="background: var(--cream); min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card fk-card border-0 shadow-lg">
                    <div class="card-header bg-success text-white text-center py-4 rounded-top-4">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-person-plus me-2"></i>Daftar Akun Pelanggan</h4>
                        <small class="opacity-75">Silakan isi data untuk membuat akun</small>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul class="mb-0 ps-3">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($err); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

 <form action="<?php echo e(route('register.process')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    
    <div class="form-group">
        <label>Nama Lengkap *</label>
        <input type="text" name="nama_pelanggan" class="form-control" 
               value="<?php echo e(old('nama_pelanggan')); ?>" required>
    </div>
    
    <div class="form-group">
        <label>Email *</label>
        <input type="email" name="email" class="form-control" 
               value="<?php echo e(old('email')); ?>" required>
    </div>
    
    <div class="form-group">
        <label>Nomor Telepon *</label>
        <input type="text" name="telepon" class="form-control" 
               value="<?php echo e(old('telepon')); ?>" required>
    </div>
    
    <div class="form-group">
        <label>Alamat Lengkap *</label>
        <textarea name="alamat1" class="form-control" rows="3" required><?php echo e(old('alamat1')); ?></textarea>
    </div>
    
    <div class="form-group">
        <label>Alamat Detail (Opsional)</label>
        <textarea name="alamat2" class="form-control" rows="2"><?php echo e(old('alamat2')); ?></textarea>
    </div>
    
    <div class="form-group">
        <label>Kecamatan/Kelurahan (Opsional)</label>
        <input type="text" name="alamat3" class="form-control" 
               value="<?php echo e(old('alamat3')); ?>">
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Konfirmasi Password *</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary btn-block">
        Daftar Sekarang
    </button>
</form>
                    </div>
                    <div class="card-footer bg-white text-center py-3 border-0 rounded-bottom-4">
                        <small>Sudah punya akun? <a href="<?php echo e(route('login')); ?>" class="fw-bold text-success">Login disini</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/auth/register.blade.php ENDPATH**/ ?>