<?php $__env->startSection('title', 'Tambah Pengiriman'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-truck"></i> Tambah Pengiriman</h5>
                </div>
                <div class="card-body">
                    
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

                    
                    <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('pengirimans.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        
                        <div class="mb-3">
                            <label for="pemesanan_id" class="form-label">Pilih Pesanan <span class="text-danger">*</span></label>
                            <select name="pemesanan_id" id="pemesanan_id"
                                    class="form-select <?php $__errorArgs = ['pemesanan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">-- Pilih Pesanan --</option>
                                <?php $__empty_1 = true; $__currentLoopData = $pemesanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option value="<?php echo e($p->id); ?>" <?php echo e(old('pemesanan_id') == $p->id ? 'selected' : ''); ?>>
                                        <?php echo e($p->pelanggan->nama_pelanggan ?? 'Tanpa Nama'); ?>

                                        - <?php echo e($p->no_resi ?? ''); ?>

                                        (<?php echo e($p->tgl_pesan?->format('d/m/Y') ?? ''); ?>)
                                        <small class="text-muted">[<?php echo e($p->status_pesan); ?>]</small>
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <option value="" disabled>Tidak ada pesanan yang siap dikirim</option>
                                <?php endif; ?>
                            </select>
                            <?php $__errorArgs = ['pemesanan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php if($pemesanan->isEmpty()): ?>
                                <small class="text-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Pastikan ada pemesanan dengan status "Sedang Diproses" atau "Menunggu Kurir"
                                </small>
                            <?php endif; ?>
                        </div>

                        
                        <div class="mb-3">
                            <label for="tgl_kirim" class="form-label">Tanggal Kirim <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_kirim" id="tgl_kirim"
                                   class="form-control <?php $__errorArgs = ['tgl_kirim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('tgl_kirim', date('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['tgl_kirim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-4">
                            <label for="status_kirim" class="form-label">Status Pengiriman <span class="text-danger">*</span></label>
                            <select name="status_kirim" id="status_kirim"
                                    class="form-select <?php $__errorArgs = ['status_kirim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="Sedang Dikirim" <?php echo e(old('status_kirim') == 'Sedang Dikirim' ? 'selected' : ''); ?>>
                                    🚚 Sedang Dikirim
                                </option>
                                
                                <option value="Tiba Ditujuan" <?php echo e(old('status_kirim') == 'Tiba Ditujuan' ? 'selected' : ''); ?>>
                                    ✅ Tiba Ditujuan
                                </option>
                            </select>
                            <?php $__errorArgs = ['status_kirim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="<?php echo e(route('pengirimans.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\catering-online\resources\views/pengirimans/create.blade.php ENDPATH**/ ?>