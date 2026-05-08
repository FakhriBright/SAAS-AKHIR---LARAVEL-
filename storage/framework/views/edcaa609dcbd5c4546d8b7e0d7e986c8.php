<?php $__env->startSection('title', 'Buat Pesanan Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex align-items-center mb-4">
                <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-fk-outline me-3"><i class="bi bi-arrow-left"></i></a>
                <div>
                    <h2 class="fw-bold mb-1">Buat Pesanan Baru</h2>
                    <p class="text-muted mb-0">Pilih paket dan lengkapi data pemesanan Anda</p>
                </div>
            </div>

            <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0 ps-3"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($e); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <form action="<?php echo e(route('customer.order.store')); ?>" method="POST" id="orderForm">
                <?php echo csrf_field(); ?>
                
                
                <div class="card fk-card mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-box-seam text-success me-2"></i>Pilih Paket</h5>
                        
                        <div id="paket-container">
                            
                            <div class="paket-item border rounded p-3 mb-3 bg-light">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-7">
                                        <label class="form-label small fw-medium">Paket Catering</label>
                                        <select name="paket_id[]" class="form-select paket-select" required>
                                            <option value="">-- Pilih Paket --</option>
                                            <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($p->id); ?>" data-harga="<?php echo e($p->harga_paket); ?>">
                                                <?php echo e($p->nama_paket); ?> - Rp <?php echo e(number_format($p->harga_paket, 0, ',', '.')); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-medium">Jumlah</label>
                                        <input type="number" name="jumlah[]" class="form-control qty-input" min="1" value="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-row" style="display:none;"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-fk-outline btn-sm mt-2" id="add-paket">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Paket Lain
                        </button>
                    </div>
                </div>

                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card fk-card h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3"><i class="bi bi-calendar-event text-success me-2"></i>Jadwal & Pembayaran</h5>
                                <div class="mb-3">
                                    <label class="form-label small fw-medium">Tanggal Pesan</label>
                                    <input type="date" name="tgl_pesan" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label small fw-medium">Metode Pembayaran</label>
                                    <select name="id_jenis_bayar" id="metode-bayar" class="form-select" required>
                                        <option value="">-- Pilih Metode --</option>
                                        <?php $__currentLoopData = $jenisPembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($jp->id); ?>"><?php echo e($jp->metode_pembayaran); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card fk-card h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3"><i class="bi bi-chat-left-text text-success me-2"></i>Catatan (Opsional)</h5>
                                <textarea name="catatan" class="form-control" rows="4" placeholder="Contoh: Acara ulang tahun, butuh 50 porsi, alergen kacang..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card fk-card bg-success bg-opacity-10 border-success mb-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-success">Estimasi Total:</h5>
                        <h3 class="mb-0 fw-bold text-success" id="total-preview">Rp 0</h3>
                    </div>
                </div>

                
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-fk-primary btn-lg flex-grow-1" id="btn-submit">
                        <i class="bi bi-check-circle me-2"></i> Konfirmasi & Pesan
                    </button>
                    <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-fk-outline btn-lg">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const paketContainer = document.getElementById('paket-container');
    const addBtn = document.getElementById('add-paket');

    // Template untuk baris baru (Blade akan render opsi dropdown-nya di server)
    const newRowTemplate = `
        <div class="paket-item border rounded p-3 mb-3 bg-light">
            <div class="row g-3 align-items-end">
                <div class="col-md-7">
                    <label class="form-label small fw-medium">Paket Catering</label>
                    <select name="paket_id[]" class="form-select paket-select" required>
                        <option value="">-- Pilih Paket --</option>
                        <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" data-harga="<?php echo e($p->harga_paket); ?>">
                            <?php echo e($p->nama_paket); ?> - Rp <?php echo e(number_format($p->harga_paket, 0, ',', '.')); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control qty-input" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-row"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>
    `;

    // Tambah baris baru
    addBtn.addEventListener('click', () => {
        paketContainer.insertAdjacentHTML('beforeend', newRowTemplate);
        updateRemoveButtons();
    });

    // Hapus baris (Event Delegation)
    paketContainer.addEventListener('click', (e) => {
        if(e.target.closest('.remove-row')) {
            e.target.closest('.paket-item').remove();
            updateRemoveButtons();
            calculateTotal();
        }
    });

    // Tampilkan/sembunyikan tombol hapus
    function updateRemoveButtons() {
        const rows = paketContainer.querySelectorAll('.paket-item');
        rows.forEach(row => {
            const btn = row.querySelector('.remove-row');
            btn.style.display = rows.length > 1 ? 'block' : 'none';
        });
    }

    // Hitung total estimasi
    function calculateTotal() {
        let total = 0;
        const rows = paketContainer.querySelectorAll('.paket-item');
        
        rows.forEach(row => {
            const select = row.querySelector('.paket-select');
            const qtyInput = row.querySelector('.qty-input');
            
            // Ambil harga dari data-harga attribute
            const harga = parseInt(select.options[select.selectedIndex]?.dataset.harga) || 0;
            const qty = parseInt(qtyInput.value) || 0;
            
            total += harga * qty;
        });
        
        document.getElementById('total-preview').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Event listener untuk perubahan paket/jumlah
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

    // Inisialisasi awal
    updateRemoveButtons();
    calculateTotal();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/customer/order/create.blade.php ENDPATH**/ ?>