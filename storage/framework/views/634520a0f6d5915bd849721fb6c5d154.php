<?php $__env->startSection('title', 'Login' . ($role !== 'pelanggan' ? ' ' . ucfirst($role) : '')); ?>

<?php $__env->startSection('content'); ?>
<style>
    .login-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }
    .login-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        max-width: 450px;
        width: 100%;
        overflow: hidden;
    }
    .login-header {
        background: <?php echo e($role === 'pelanggan' ? 'linear-gradient(135deg, #2d6a4f, #1b4332)' :
                    ($role === 'admin' ? 'linear-gradient(135deg, #1e3a8a, #1e40af)' :
                    ($role === 'owner' ? 'linear-gradient(135deg, #7c3aed, #6d28d9)' :
                    'linear-gradient(135deg, #059669, #047857)'))); ?>;
        color: white;
        padding: 40px 30px;
        text-align: center;
    }
    .login-header i {
        font-size: 3rem;
        margin-bottom: 10px;
    }
    .login-header h2 {
        margin: 0;
        font-weight: 700;
    }
    .login-header p {
        margin: 5px 0 0;
        opacity: 0.9;
    }
    .login-body {
        padding: 40px 30px;
    }
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    .form-control {
        border-radius: 10px;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
    }
    .form-control:focus {
        border-color: <?php echo e($role === 'pelanggan' ? '#2d6a4f' :
                      ($role === 'admin' ? '#1e40af' :
                      ($role === 'owner' ? '#6d28d9' : '#047857'))); ?>;
        box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
    }
    .btn-login {
        background: <?php echo e($role === 'pelanggan' ? 'linear-gradient(135deg, #2d6a4f, #1b4332)' :
                    ($role === 'admin' ? 'linear-gradient(135deg, #1e3a8a, #1e40af)' :
                    ($role === 'owner' ? 'linear-gradient(135deg, #7c3aed, #6d28d9)' :
                    'linear-gradient(135deg, #059669, #047857)'))); ?>;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 14px;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .btn-login:hover {
        transform: translateY(-2px);
    }
    .role-badge {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        margin-top: 10px;
    }
</style>

<div class="login-container">
    <div class="login-card">
        
        <div class="login-header">
            <?php if($role === 'pelanggan'): ?>
                <i class="bi bi-cup-hot"></i>
                <h2>Fakhri Kitchen</h2>
                <p>Login Pelanggan</p>
            <?php elseif($role === 'admin'): ?>
                <i class="bi bi-shield-lock"></i>
                <h2>Admin Portal</h2>
                <p>Fakhri Kitchen Management</p>
                <span class="role-badge">Administrator</span>
            <?php elseif($role === 'owner'): ?>
                <i class="bi bi-briefcase"></i>
                <h2>Owner Portal</h2>
                <p>Executive Dashboard</p>
                <span class="role-badge">Owner</span>
            <?php elseif($role === 'kurir'): ?>
                <i class="bi bi-truck"></i>
                <h2>Kurir Portal</h2>
                <p>Delivery Management</p>
                <span class="role-badge">Kurir</span>
            <?php endif; ?>
        </div>

        
        <div class="login-body">
            <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <form action="<?php echo e(route('login.process')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="role" value="<?php echo e($role); ?>">

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control border-start-0"
                               value="<?php echo e(old('email')); ?>" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control border-start-0" required>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </button>
            </form>

            <?php if($role === 'pelanggan'): ?>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0 text-muted">Belum punya akun?
                    <a href="<?php echo e(route('register')); ?>" class="text-success fw-bold">Daftar disini</a>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\saas-akhir\resources\views/auth/login.blade.php ENDPATH**/ ?>