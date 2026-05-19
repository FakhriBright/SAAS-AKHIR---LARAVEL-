<?php $__env->startSection('title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .profile-container { 
        padding: 40px 0; 
        max-width: 1000px; 
        margin: 0 auto; 
    }
    
    .page-header {
        margin-bottom: 32px;
    }
    .page-header h2 { 
        font-weight: 700; 
        margin-bottom: 4px;
    }
    .page-header p { color: #666; margin: 0; }
    
    .profile-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        margin-bottom: 24px;
    }
    
    .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f7f4;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        font-size: 0.9rem;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #2d6a4f;
        box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
    }
    
    textarea.form-control {
        min-height: 80px;
        resize: vertical;
    }
    
    .form-text {
        font-size: 0.8rem;
        color: #888;
        margin-top: 4px;
    }
    
    .btn-save {
        background: #2d6a4f;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-save:hover {
        background: #1b4332;
        transform: translateY(-2px);
    }
    
    .btn-outline {
        background: white;
        color: #2d6a4f;
        border: 1px solid #2d6a4f;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-left: 12px;
    }
    
    .btn-outline:hover {
        background: #f0f7f4;
    }
    
    .section-divider {
        height: 1px;
        background: #e8e8e8;
        margin: 24px 0;
    }
    
    .password-strength {
        height: 3px;
        background: #e8e8e8;
        border-radius: 2px;
        margin-top: 6px;
        overflow: hidden;
    }
    
    .password-strength-bar {
        height: 100%;
        width: 0;
        transition: all 0.3s;
    }
    
    .password-strength-bar.weak { width: 33%; background: #dc3545; }
    .password-strength-bar.medium { width: 66%; background: #ffc107; }
    .password-strength-bar.strong { width: 100%; background: #28a745; }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container profile-container">
    <div class="page-header">
        <h2>Profil Saya</h2>
        <p>Kelola informasi akun dan alamat Anda</p>
    </div>

    <form action="<?php echo e(route('customer.profile.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        
        <div class="profile-card">
            <h3 class="card-title">
                <i class="bi bi-person" style="color: #2d6a4f;"></i>
                Informasi Pribadi
            </h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pelanggan" class="form-control" 
                           value="<?php echo e(old('nama_pelanggan', $pelanggan->nama_pelanggan)); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" 
                           value="<?php echo e(old('email', $pelanggan->email)); ?>" required>
                    <div class="form-text">
                        <i class="bi bi-check-circle text-success"></i> Email terverifikasi
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                    <input type="tel" name="telepon" class="form-control" 
                           value="<?php echo e(old('telepon', $pelanggan->telepon)); ?>" 
                           placeholder="08123456789" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" 
                           value="<?php echo e(old('tanggal_lahir', $pelanggan->tanggal_lahir ?? '')); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea name="alamat1" class="form-control" rows="3" 
                          placeholder="Masukkan alamat lengkap Anda..." required><?php echo e(old('alamat1', $pelanggan->alamat1)); ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kecamatan/Kelurahan</label>
                    <input type="text" name="alamat2" class="form-control" 
                           value="<?php echo e(old('alamat2', $pelanggan->alamat2 ?? '')); ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kota & Kode Pos</label>
                    <input type="text" name="alamat3" class="form-control" 
                           value="<?php echo e(old('alamat3', $pelanggan->alamat3 ?? '')); ?>"
                           placeholder="Kota, Kode Pos">
                </div>
            </div>
            
            <div class="section-divider"></div>
            
            <h4 style="margin-bottom: 20px; font-weight: 600; font-size: 1rem;">
                <i class="bi bi-lock me-2"></i>Ganti Password (Opsional)
            </h4>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" 
                           id="newPassword" placeholder="Kosongkan jika tidak ingin mengubah">
                    <div class="password-strength">
                        <div class="password-strength-bar" id="passwordStrength"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" 
                           placeholder="Ulangi password baru">
                </div>
            </div>
            
            <div style="margin-top: 24px;">
                <button type="submit" class="btn-save">
                    <i class="bi bi-check-circle"></i> Simpan Perubahan
                </button>
                <button type="reset" class="btn-outline">
                    <i class="bi bi-x-circle"></i> Reset
                </button>
            </div>
        </div>
    </form>
    

<script>
    // Password strength checker
    document.getElementById('newPassword')?.addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('passwordStrength');
        
        if (!password) {
            strengthBar.className = 'password-strength-bar';
            return;
        }
        
        let strength = 0;
        if (password.length > 6) strength++;
        if (password.length > 10) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        strengthBar.className = 'password-strength-bar';
        if (strength <= 2) {
            strengthBar.classList.add('weak');
        } else if (strength <= 4) {
            strengthBar.classList.add('medium');
        } else {
            strengthBar.classList.add('strong');
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\saas-akhir\resources\views/customer/profile.blade.php ENDPATH**/ ?>