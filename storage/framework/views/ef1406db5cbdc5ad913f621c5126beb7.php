<?php $__env->startSection('title', 'Edit Pengiriman'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Pengiriman</h5>
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

                    
                    <form action="<?php echo e(route('pengirimans.update', $pengiriman->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        
                        <input type="hidden" name="pemesanan_id" value="<?php echo e($pengiriman->pemesanan_id); ?>">

                        
                        <div class="mb-3 p-3 bg-light rounded">
                            <label class="form-label fw-bold">Detail Pesanan</label>
                            <p class="mb-1"><strong>No. Resi:</strong> <?php echo e($pengiriman->pemesanan->no_resi ?? '-'); ?></p>
                            <p class="mb-1"><strong>Pelanggan:</strong> <?php echo e($pengiriman->pemesanan->pelanggan->nama_pelanggan ?? '-'); ?></p>
                            <p class="mb-1"><strong>Telepon:</strong> <?php echo e($pengiriman->pemesanan->pelanggan->telepon ?? '-'); ?></p>
                            <p class="mb-1"><strong>Status Pesanan:</strong>
                                <span class="badge bg-info"><?php echo e($pengiriman->pemesanan->status_pesan); ?></span>
                            </p>
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
                                   value="<?php echo e(old('tgl_kirim', $pengiriman->tgl_kirim ? \Carbon\Carbon::parse($pengiriman->tgl_kirim)->format('Y-m-d') : date('Y-m-d'))); ?>" required>
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

                        
                        <div class="mb-3">
                            <label for="bukti_foto" class="form-label">Bukti Foto Pengiriman</label>

                            <?php if($pengiriman->bukti_foto): ?>
                                <div class="mb-2">
                                    <img src="<?php echo e(asset('storage/' . $pengiriman->bukti_foto)); ?>" alt="Bukti Lama" class="img-thumbnail" style="max-height: 150px;">
                                    <br><small class="text-muted">Foto saat ini</small>
                                </div>
                            <?php endif; ?>

                            <input type="file" name="bukti_foto" id="bukti_foto"
                                   class="form-control <?php $__errorArgs = ['bukti_foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   accept="image/*">
                            <?php $__errorArgs = ['bukti_foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> Format: JPG/PNG. Max: 2MB.
                                <span class="text-danger">*Wajib jika status "Tiba Ditujuan"</span>
                            </small>
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
                                <option value="Sedang Dikirim"
                                        <?php echo e(old('status_kirim', $pengiriman->status_kirim) == 'Sedang Dikirim' ? 'selected' : ''); ?>>
                                    🚚 Sedang Dikirim
                                </option>
                                <option value="Tiba Ditujuan"
                                        <?php echo e(old('status_kirim', $pengiriman->status_kirim) == 'Tiba Ditujuan' ? 'selected' : ''); ?>>
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
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> Jika dipilih "Tiba Ditujuan", status pesanan akan otomatis berubah jadi "Selesai"
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save"></i> Update
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/pengirimans/edit.blade.php ENDPATH**/ ?>