<?php $__env->startSection('title', 'Edit Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Pesanan: <?php echo e($pemesanan->no_resi); ?></h5>
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

                    <form action="<?php echo e(route('pemesanans.update', $pemesanan->id)); ?>" method="POST" id="orderForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        
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
                                    <option value="<?php echo e($pelanggan->id); ?>" 
                                        <?php echo e((old('id_pelanggan', $pemesanan->id_pelanggan) == $pelanggan->id) ? 'selected' : ''); ?>>
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
                                    <option value="<?php echo e($jp->id); ?>" 
                                        <?php echo e((old('id_jenis_bayar', $pemesanan->id_jenis_bayar) == $jp->id) ? 'selected' : ''); ?>>
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
                                   value="<?php echo e(old('tgl_pesan', $pemesanan->tgl_pesan)); ?>" required>
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
                                <?php $__empty_1 = true; $__currentLoopData = $pemesanan->detailPemesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="paket-item border rounded p-3 mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small">Pilih Paket</label>
                                            <select name="paket_id[]" class="form-select paket-select" required>
                                                <option value="">-- Pilih Paket --</option>
                                                <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                
                                                <option value="<?php echo e($paket->id); ?>" data-harga="<?php echo e($paket->harga_paket); ?>"
                                                    <?php echo e($detail->paket_id == $paket->id ? 'selected' : ''); ?>>
                                                    <?php echo e($paket->nama_paket); ?> - Rp <?php echo e(number_format($paket->harga_paket, 0, ',', '.')); ?>

                                                </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small">Jumlah</label>
                                            <input type="number" name="jumlah[]" class="form-control qty-input" placeholder="Jumlah" 
                                                   min="1" value="<?php echo e(old('jumlah.' . $index, $detail->jumlah)); ?>" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-danger w-100" onclick="removePaket(this)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="paket-item border rounded p-3 mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small">Pilih Paket</label>
                                            <select name="paket_id[]" class="form-select paket-select" required>
                                                <option value="">-- Pilih Paket --</option>
                                                <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                
                                                <option value="<?php echo e($paket->id); ?>" data-harga="<?php echo e($paket->harga_paket); ?>">
                                                    <?php echo e($paket->nama_paket); ?> - Rp <?php echo e(number_format($paket->harga_paket, 0, ',', '.')); ?>

                                                </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small">Jumlah</label>
                                            <input type="number" name="jumlah[]" class="form-control qty-input" placeholder="Jumlah" min="1" value="1" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-danger w-100" onclick="removePaket(this)" style="display:none;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPaket()">
                                <i class="bi bi-plus"></i> Tambah Paket Lain
                            </button>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Pesanan <span class="text-danger">*</span></label>
                            <select name="status_pesan" class="form-select <?php $__errorArgs = ['status_pesan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="Menunggu Konfirmasi" <?php echo e(old('status_pesan', $pemesanan->status_pesan) == 'Menunggu Konfirmasi' ? 'selected' : ''); ?>>Menunggu Konfirmasi</option>
                                <option value="Sedang Diproses" <?php echo e(old('status_pesan', $pemesanan->status_pesan) == 'Sedang Diproses' ? 'selected' : ''); ?>>Sedang Diproses</option>
                                <option value="Menunggu Kurir" <?php echo e(old('status_pesan', $pemesanan->status_pesan) == 'Menunggu Kurir' ? 'selected' : ''); ?>>Menunggu Kurir</option>
                                <option value="Selesai" <?php echo e(old('status_pesan', $pemesanan->status_pesan) == 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                                <option value="Dibatalkan" <?php echo e(old('status_pesan', $pemesanan->status_pesan) == 'Dibatalkan' ? 'selected' : ''); ?>>Dibatalkan</option>
                            </select>
                            <?php $__errorArgs = ['status_pesan'];
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
                            <label class="form-label fw-bold">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control <?php $__errorArgs = ['catatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      rows="3" placeholder="Contoh: Acara ulang tahun, butuh 50 porsi..."><?php echo e(old('catatan', $pemesanan->catatan)); ?></textarea>
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
                            <span class="fs-4 fw-bold text-primary" id="total-preview">Rp <?php echo e(number_format($pemesanan->total_bayar, 0, ',', '.')); ?></span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg" id="btn-submit">
                                <i class="bi bi-check-circle"></i> Update Pesanan
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
    // Data paket
    const paketData = <?php echo json_encode($pakets, 15, 512) ?>;

    // Fungsi populate dropdown
    function populatePaketDropdown(selectElement) {
        selectElement.innerHTML = '<option value="">-- Pilih Paket --</option>';
        paketData.forEach(paket => {
            const option = document.createElement('option');
            option.value = paket.id;
            option.dataset.harga = paket.harga_paket;
            option.textContent = `${paket.nama_paket} - Rp ${new Intl.NumberFormat('id-ID').format(paket.harga_paket)}`;
            selectElement.appendChild(option);
        });
    }

    // Tambah paket dinamis
    function addPaket() {
        const container = document.getElementById('paket-container');
        const newItem = document.createElement('div');
        newItem.className = 'paket-item border rounded p-3 mb-3';
        newItem.innerHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small">Pilih Paket</label>
                    <select name="paket_id[]" class="form-select paket-select" required>
                        <option value="">-- Pilih Paket --</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control qty-input" placeholder="Jumlah" min="1" value="1" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="removePaket(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        
        // Populate dropdown yang baru
        const newSelect = newItem.querySelector('.paket-select');
        populatePaketDropdown(newSelect);
        
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
        items.forEach((item) => {
            const deleteBtn = item.querySelector('button.btn-danger');
            if (deleteBtn) {
                deleteBtn.style.display = items.length > 1 ? 'block' : 'none';
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

    // Init
    document.addEventListener('DOMContentLoaded', function() {
        // Populate semua dropdown yang ada
        document.querySelectorAll('.paket-select').forEach(select => {
            if (!select.options.length || select.options.length === 1) {
                populatePaketDropdown(select);
            }
        });
        
        calculateTotal();
        updateDeleteButtons();
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/pemesanans/edit.blade.php ENDPATH**/ ?>