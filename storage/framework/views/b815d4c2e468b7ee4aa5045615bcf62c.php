<?php $__env->startSection('title', 'Tambah Pesanan Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-cart-plus"></i> Tambah Pesanan Catering</h5>
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

                    <form action="<?php echo e(route('pemesanans.store')); ?>" method="POST" id="orderForm">
                        <?php echo csrf_field(); ?>

                        
                        <div class="row g-4 mb-4">
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Pelanggan <span class="text-danger">*</span></label>
                                <select name="id_pelanggan" class="form-select <?php $__errorArgs = ['id_pelanggan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    
                                    <?php $__currentLoopData = $pelanggans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelanggan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($pelanggan->id); ?>" <?php echo e(old('id_pelanggan') == $pelanggan->id ? 'selected' : ''); ?>>
                                        <?php echo e($pelanggan->nama_pelanggan); ?> - <?php echo e($pelanggan->telepon); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['id_pelanggan'];
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
                                <label class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select name="id_jenis_bayar" class="form-select <?php $__errorArgs = ['id_jenis_bayar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">-- Pilih Metode --</option>
                                    <?php $__currentLoopData = $jenisPembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($jp->id); ?>" <?php echo e(old('id_jenis_bayar') == $jp->id ? 'selected' : ''); ?>>
                                        <?php echo e($jp->metode_pembayaran); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['id_jenis_bayar'];
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

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tanggal Pesan <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_pesan" class="form-control <?php $__errorArgs = ['tgl_pesan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('tgl_pesan', date('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['tgl_pesan'];
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
                            <label class="form-label fw-bold">Detail Paket <span class="text-danger">*</span></label>
                            <div id="paket-container">
                                <div class="paket-item border rounded p-3 mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small">Pilih Paket</label>
                                            <select name="paket_id[]" class="form-select" required>
                                                <option value="">-- Pilih Paket --</option>
                                                <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($paket->id); ?>" data-harga="<?php echo e($paket->harga); ?>">
                                                    <?php echo e($paket->nama_paket); ?> - Rp <?php echo e(number_format($paket->harga, 0, ',', '.')); ?>

                                                </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small">Jumlah</label>
                                            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" value="1" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-danger w-100" onclick="removePaket(this)" style="display:none;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPaket()">
                                <i class="bi bi-plus"></i> Tambah Paket Lain
                            </button>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control <?php $__errorArgs = ['catatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      rows="3" placeholder="Contoh: Acara ulang tahun, butuh 50 porsi..."><?php echo e(old('catatan')); ?></textarea>
                            <?php $__errorArgs = ['catatan'];
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

                        
                        <div class="alert alert-info d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold">Estimasi Total:</span>
                            <span class="fs-4 fw-bold text-primary" id="total-preview">Rp 0</span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-submit">
                                <i class="bi bi-check-circle"></i> Simpan Pesanan
                            </button>
                            <a href="<?php echo e(route('pemesanans.index')); ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Tambah paket dinamis
    function addPaket() {
        const container = document.getElementById('paket-container');
        const itemCount = container.querySelectorAll('.paket-item').length;
        
        const newItem = document.createElement('div');
        newItem.className = 'paket-item border rounded p-3 mb-3';
        newItem.innerHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small">Pilih Paket</label>
                    <select name="paket_id[]" class="form-select" required>
                        <option value="">-- Pilih Paket --</option>
                        <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($paket->id); ?>" data-harga="<?php echo e($paket->harga); ?>"><?php echo e($paket->nama_paket); ?> - Rp <?php echo e(number_format($paket->harga, 0, ',', '.')); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" value="1" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="removePaket(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        
        // Show delete button for all items when more than 1
        updateDeleteButtons();
    }

    // Hapus paket
    function removePaket(btn) {
        btn.closest('.paket-item').remove();
        updateDeleteButtons();
        calculateTotal();
    }

    // Update visibility delete buttons
    function updateDeleteButtons() {
        const items = document.querySelectorAll('.paket-item');
        items.forEach((item, index) => {
            const deleteBtn = item.querySelector('button.btn-danger');
            if (items.length > 1) {
                deleteBtn.style.display = 'block';
            } else {
                deleteBtn.style.display = 'none';
            }
        });
    }

    // Hitung total realtime
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('select[name="paket_id[]"]').forEach((select, i) => {
            const option = select.options[select.selectedIndex];
            const harga = parseInt(option?.dataset.harga) || 0;
            const jumlahInputs = document.querySelectorAll('input[name="jumlah[]"]');
            const jumlah = parseInt(jumlahInputs[i]?.value) || 0;
            total += harga * jumlah;
        });
        document.getElementById('total-preview').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Auto calculate on change
    document.addEventListener('change', function(e) {
        if (e.target.name === 'paket_id[]' || e.target.name === 'jumlah[]') {
            calculateTotal();
        }
    });

    // Loading state saat submit
    document.getElementById('orderForm')?.addEventListener('submit', function() {
        const btn = document.getElementById('btn-submit');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
        }
    });

    // Init
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();
        updateDeleteButtons();
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\catering-online\resources\views/pemesanans/create.blade.php ENDPATH**/ ?>