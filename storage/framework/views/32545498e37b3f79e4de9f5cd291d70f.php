<?php $__env->startSection('title', 'Tambah Pesanan Catering'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-cart-plus me-2"></i>Tambah Pesanan Catering
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0 ps-3">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('pemesanans.store')); ?>" method="POST" id="orderForm">
                        <?php echo csrf_field(); ?>

                        <div class="row g-3">
                            
                            <div class="col-md-6">
                                <label for="id_pelanggan" class="form-label fw-bold">Pelanggan <span class="text-danger">*</span></label>
                                <select name="id_pelanggan" id="id_pelanggan" class="form-select <?php $__errorArgs = ['id_pelanggan'];
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
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="col-md-6">
                                <label for="id_jenis_bayar" class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select name="id_jenis_bayar" id="id_jenis_bayar" class="form-select <?php $__errorArgs = ['id_jenis_bayar'];
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
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="col-12">
                                <label for="tgl_pesan" class="form-label fw-bold">Tanggal Pesan <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_pesan" id="tgl_pesan" class="form-control <?php $__errorArgs = ['tgl_pesan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('tgl_pesan', date('Y-m-d'))); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
                                <?php $__errorArgs = ['tgl_pesan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="col-12">
                                <label class="form-label fw-bold">Detail Paket <span class="text-danger">*</span></label>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div id="paket-container">
                                            
                                            <div class="paket-item border rounded p-3 mb-3">
                                                <div class="row g-3 align-items-end">
                                                    <div class="col-md-8">
                                                        <label class="form-label small">Pilih Paket</label>
                                                        <select name="paket_id[]" class="form-select paket-select" required>
                                                            <option value="">-- Pilih Paket --</option>
                                                            <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($paket->id); ?>"
                                                                    data-harga="<?php echo e($paket->harga_paket); ?>">
                                                                <?php echo e($paket->nama_paket); ?> - Rp <?php echo e(number_format($paket->harga_paket, 0, ',', '.')); ?>

                                                                (<?php echo e($paket->jumlah_pax); ?> Pax)
                                                            </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small">Jumlah</label>
                                                        <input type="number" name="jumlah[]" class="form-control qty-input"
                                                               min="1" value="1" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-row"
                                                                style="display:none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-paket">
                                            <i class="bi bi-plus-circle me-1"></i> Tambah Paket Lain
                                        </button>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-12">
                                <label for="catatan" class="form-label fw-bold">Catatan (Opsional)</label>
                                <textarea name="catatan" id="catatan" class="form-control <?php $__errorArgs = ['catatan'];
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
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="col-12">
                                <div class="alert alert-info d-flex justify-content-between align-items-center mb-0">
                                    <h5 class="mb-0 fw-bold">Estimasi Total:</h5>
                                    <h3 class="mb-0 fw-bold text-primary" id="total-preview">Rp 0</h3>
                                </div>
                            </div>
                        </div>

                        
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary flex-grow-1 btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Simpan Pesanan
                            </button>
                            <a href="<?php echo e(route('pemesanans.index')); ?>" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle me-2"></i>Batal
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
    // Data paket dari Laravel ke JavaScript
    const paketData = <?php echo json_encode($pakets, 15, 512) ?>;

    const paketContainer = document.getElementById('paket-container');
    const addBtn = document.getElementById('add-paket');

    // Fungsi populate dropdown
    function populatePaketDropdown(selectElement) {
        // Clear existing options except first
        selectElement.innerHTML = '<option value="">-- Pilih Paket --</option>';

        paketData.forEach(paket => {
            const option = document.createElement('option');
            option.value = paket.id;
            option.dataset.harga = paket.harga_paket;
            option.textContent = `${paket.nama_paket} - Rp ${new Intl.NumberFormat('id-ID').format(paket.harga_paket)} (${paket.jumlah_pax} Pax)`;
            selectElement.appendChild(option);
        });
    }

    // Template HTML untuk row baru
    function createNewRow() {
        const div = document.createElement('div');
        div.className = 'paket-item border rounded p-3 mb-3';
        div.innerHTML = `
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label small">Pilih Paket</label>
                    <select name="paket_id[]" class="form-select paket-select" required>
                        <option value="">-- Pilih Paket --</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control qty-input" min="1" value="1" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-row">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        return div;
    }

    // Initialize dropdown pertama
    const firstSelect = paketContainer.querySelector('.paket-select');
    if (firstSelect) {
        populatePaketDropdown(firstSelect);
    }

    // Tambah baris baru
    addBtn.addEventListener('click', () => {
        const newRow = createNewRow();
        paketContainer.appendChild(newRow);
        const newSelect = newRow.querySelector('.paket-select');
        populatePaketDropdown(newSelect);
        updateRemoveButtons();
    });

    // Hapus baris
    paketContainer.addEventListener('click', (e) => {
        if(e.target.closest('.remove-row')) {
            const row = e.target.closest('.paket-item');
            row.remove();
            updateRemoveButtons();
            calculateTotal();
        }
    });

    // Update tombol hapus
    function updateRemoveButtons() {
        const rows = paketContainer.querySelectorAll('.paket-item');
        rows.forEach((row, index) => {
            const btn = row.querySelector('.remove-row');
            btn.style.display = rows.length > 1 ? 'block' : 'none';
        });
    }

    // Hitung total
    function calculateTotal() {
        let total = 0;
        const rows = paketContainer.querySelectorAll('.paket-item');

        rows.forEach(row => {
            const select = row.querySelector('.paket-select');
            const qtyInput = row.querySelector('.qty-input');

            const selectedOption = select.options[select.selectedIndex];
            const harga = parseInt(selectedOption?.dataset.harga) || 0;
            const qty = parseInt(qtyInput.value) || 0;

            total += harga * qty;
        });

        document.getElementById('total-preview').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Event listeners
    paketContainer.addEventListener('change', (e) => {
        if(e.target.matches('.paket-select, .qty-input')) {
            calculateTotal();
        }
    });

    paketContainer.addEventListener('input', (e) => {
        if(e.target.matches('.qty-input')) {
            calculateTotal();
        }
    });

    // Init
    updateRemoveButtons();
    calculateTotal();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/pemesanans/create.blade.php ENDPATH**/ ?>