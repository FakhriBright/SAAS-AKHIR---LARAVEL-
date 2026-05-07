<?php $__env->startSection('title', 'Edit Paket'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Paket: <?php echo e($paket->nama_paket); ?></h5>
                </div>
                <div class="card-body p-4">
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

                    <form action="<?php echo e(route('pakets.update', $paket->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" name="nama_paket" class="form-control <?php $__errorArgs = ['nama_paket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('nama_paket', $paket->nama_paket)); ?>" required placeholder="Contoh: Paket Premium">
                            <?php $__errorArgs = ['nama_paket'];
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

                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      rows="3" required placeholder="Deskripsi paket..."><?php echo e(old('deskripsi', $paket->deskripsi)); ?></textarea>
                            <?php $__errorArgs = ['deskripsi'];
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

                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga" class="form-control <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('harga', $paket->harga)); ?>" min="0" required placeholder="50000">
                                <?php $__errorArgs = ['harga'];
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
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jumlah Pax <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_pax" class="form-control <?php $__errorArgs = ['jumlah_pax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('jumlah_pax', $paket->jumlah_pax)); ?>" min="1" required placeholder="1">
                                <?php $__errorArgs = ['jumlah_pax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="text-muted">Jumlah porsi/orang</small>
                            </div>
                        </div>

                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Paket <span class="text-danger">*</span></label>
                            <select name="jenis" class="form-select <?php $__errorArgs = ['jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Prasmanan" <?php echo e(old('jenis', $paket->jenis) == 'Prasmanan' ? 'selected' : ''); ?>>Prasmanan</option>
                                <option value="Box" <?php echo e(old('jenis', $paket->jenis) == 'Box' ? 'selected' : ''); ?>>Box</option>
                            </select>
                            <?php $__errorArgs = ['jenis'];
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

                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori (Opsional)</label>
                            <input type="text" name="kategori" class="form-control <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('kategori', $paket->kategori)); ?>" placeholder="Contoh: Prewedding, Ulang Tahun">
                            <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted">Pisahkan dengan koma jika lebih dari satu</small>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto Saat Ini</label>
                            <div class="row g-2">
                                <?php if($paket->foto1): ?>
                                <div class="col-4">
                                    <img src="<?php echo e(asset('storage/' . $paket->foto1)); ?>" class="img-thumbnail" alt="Foto 1" style="height: 80px; object-fit: cover;">
                                    <small class="d-block text-center">Foto 1</small>
                                </div>
                                <?php endif; ?>
                                <?php if($paket->foto2): ?>
                                <div class="col-4">
                                    <img src="<?php echo e(asset('storage/' . $paket->foto2)); ?>" class="img-thumbnail" alt="Foto 2" style="height: 80px; object-fit: cover;">
                                    <small class="d-block text-center">Foto 2</small>
                                </div>
                                <?php endif; ?>
                                <?php if($paket->foto3): ?>
                                <div class="col-4">
                                    <img src="<?php echo e(asset('storage/' . $paket->foto3)); ?>" class="img-thumbnail" alt="Foto 3" style="height: 80px; object-fit: cover;">
                                    <small class="d-block text-center">Foto 3</small>
                                </div>
                                <?php endif; ?>
                                <?php if(!$paket->foto1 && !$paket->foto2 && !$paket->foto3): ?>
                                <p class="text-muted small">Belum ada foto</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload Foto Baru (Opsional)</label>
                            <small class="text-muted d-block mb-2">Kosongkan jika tidak ingin mengganti foto</small>
                            
                            <div class="mb-2">
                                <label class="form-label small">Ganti Foto Utama</label>
                                <input type="file" name="foto1" class="form-control <?php $__errorArgs = ['foto1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*">
                                <?php $__errorArgs = ['foto1'];
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
                            
                            <div class="mb-2">
                                <label class="form-label small">Ganti Foto 2</label>
                                <input type="file" name="foto2" class="form-control <?php $__errorArgs = ['foto2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*">
                                <?php $__errorArgs = ['foto2'];
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
                            
                            <div class="mb-2">
                                <label class="form-label small">Ganti Foto 3</label>
                                <input type="file" name="foto3" class="form-control <?php $__errorArgs = ['foto3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*">
                                <?php $__errorArgs = ['foto3'];
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
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-check-circle"></i> Update Paket
                            </button>
                            <a href="<?php echo e(route('pakets.index')); ?>" class="btn btn-outline-secondary">
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

<?php $__env->startPush('styles'); ?>
<style>
    .img-thumbnail {
        transition: transform 0.2s;
    }
    .img-thumbnail:hover {
        transform: scale(1.05);
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\catering-online\resources\views/pakets/edit.blade.php ENDPATH**/ ?>