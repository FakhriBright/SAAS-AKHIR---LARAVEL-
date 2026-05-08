<?php $__env->startSection('title', 'Profil Saya - Fakhri Kitchen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="text-center mb-4">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                    <i class="bi bi-person fs-1" style="color: var(--primary); font-size: 3rem !important;"></i>
                </div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-dark);">Profil Saya</h2>
                <p class="text-muted">Kelola informasi pribadi Anda</p>
            </div>

            <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="card fk-card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold" style="color: var(--primary-dark);">
                        <i class="bi bi-person-badge me-2"></i>Informasi Pribadi
                    </h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="<?php echo e(route('customer.profile.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase text-muted">
                                    <i class="bi bi-person me-1"></i>Nama Lengkap
                                </label>
                                <input type="text" name="nama_pelanggan" class="form-control form-control-lg" 
                                       value="<?php echo e(old('nama_pelanggan', $pelanggan->nama_pelanggan)); ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase text-muted">
                                    <i class="bi bi-envelope me-1"></i>Email
                                </label>
                                <input type="email" class="form-control form-control-lg bg-light" 
                                       value="<?php echo e($pelanggan->email); ?>" disabled>
                                <small class="text-muted">Email tidak dapat diubah</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase text-muted">
                                    <i class="bi bi-telephone me-1"></i>Nomor Telepon
                                </label>
                                <input type="tel" name="telepon" class="form-control form-control-lg" 
                                       value="<?php echo e(old('telepon', $pelanggan->telepon)); ?>" required 
                                       placeholder="081234567890">
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label fw-semibold small text-uppercase text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>Alamat Lengkap
                                </label>
                                <textarea name="alamat1" class="form-control" rows="2" required 
                                          placeholder="Jl. Contoh No. 123, Kota..."><?php echo e(old('alamat1', $pelanggan->alamat1)); ?></textarea>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase text-muted">
                                    Kelurahan/Kecamatan
                                </label>
                                <input type="text" name="alamat2" class="form-control" 
                                       value="<?php echo e(old('alamat2', $pelanggan->alamat2)); ?>" 
                                       placeholder="Kecamatan">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase text-muted">
                                    Kota/Kabupaten
                                </label>
                                <input type="text" name="alamat3" class="form-control" 
                                       value="<?php echo e(old('alamat3', $pelanggan->alamat3)); ?>" 
                                       placeholder="Kota">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-3 mt-5">
                            <a href="<?php echo e(route('customer.dashboard')); ?>" class="btn btn-fk-outline btn-lg px-4">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-fk-primary btn-lg px-4">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="row g-4 mt-4">
                <div class="col-md-6">
                    <div class="card fk-card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-shield-check text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Akun Terverifikasi</h6>
                                    <small class="text-muted">Data Anda aman</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-0">Informasi Anda terlindungi dan hanya digunakan untuk keperluan pemesanan.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card fk-card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-award text-info fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Member Sejak</h6>
                                    <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($pelanggan->created_at)->format('d F Y')); ?></small>
                                </div>
                            </div>
                            <p class="text-muted small mb-0">Terima kasih telah menjadi pelanggan setia Fakhri Kitchen.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/customer/profile.blade.php ENDPATH**/ ?>