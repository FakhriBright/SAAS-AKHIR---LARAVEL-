<?php $__env->startSection('title', 'Login Pelanggan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">Login Pelanggan</h3>
                    <p class="text-center text-muted mb-4">Masuk ke akun pelanggan Anda</p>

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
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="<?php echo e(old('email')); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </form>

                    <div class="text-center">
                        <p class="mb-0">Belum punya akun?
                            <a href="<?php echo e(route('register')); ?>">Daftar disini</a>
                        </p>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <small class="text-muted">Login sebagai Admin/Kurir?</small><br>
                        <a href="<?php echo e(route('admin.login')); ?>" class="btn btn-outline-secondary btn-sm mt-2">
                            <i class="bi bi-shield-lock me-2"></i>Login Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\saas-akhir\resources\views/auth/login-customer.blade.php ENDPATH**/ ?>