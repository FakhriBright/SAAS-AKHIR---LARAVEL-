<?php $__env->startSection('title', 'Data Pemesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-cart-check"></i> Data Pemesanan</h2>
            <p class="text-muted mb-0">Kelola semua pesanan catering Fakhri Kitchen</p>
        </div>
        <a href="<?php echo e(route('pemesanans.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pesanan
        </a>
    </div>

    
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-cart-check text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Total Pesanan</p>
                            <h4 class="fw-bold mb-0"><?php echo e($pemesanans->total() ?? 0); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-hourglass-split text-warning fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Menunggu Konfirmasi</p>
                            <h4 class="fw-bold mb-0">
                                <?php echo e(\App\Models\Pemesanan::where('status_pesan', 'Menunggu Konfirmasi')->count()); ?>

                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-truck text-info fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Sedang Diproses</p>
                            <h4 class="fw-bold mb-0">
                                <?php echo e(\App\Models\Pemesanan::whereIn('status_pesan', ['Sedang Diproses', 'Menunggu Kurir'])->count()); ?>

                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Selesai</p>
                            <h4 class="fw-bold mb-0">
                                <?php echo e(\App\Models\Pemesanan::where('status_pesan', 'Selesai')->count()); ?>

                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="searchOrder" placeholder="Cari no. resi atau pelanggan...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                        <option value="Sedang Diproses">Sedang Diproses</option>
                        <option value="Menunggu Kurir">Menunggu Kurir</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100" onclick="resetFilter()">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 datatable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">NO. RESI</th>
                            <th>TANGGAL</th>
                            <th>PELANGGAN</th>
                            <th>PEMBAYARAN</th>
                            <th>TOTAL</th>
                            <th>STATUS</th>
                            <th class="pe-4 text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pemesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pemesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="order-row" data-status="<?php echo e($pemesanan->status_pesan); ?>">
                            <td class="ps-4 fw-bold"><?php echo e($pemesanan->no_resi); ?></td>
                            <td><?php echo e($pemesanan->tgl_pesan->format('d/m/Y')); ?></td>
                            <td>
                                <div class="fw-bold"><?php echo e($pemesanan->pelanggan->nama_pelanggan ?? '-'); ?></div>
                                <small class="text-muted"><?php echo e($pemesanan->pelanggan->telepon ?? ''); ?></small>
                            </td>
                            <td>
                                <small><?php echo e($pemesanan->jenisPembayaran->metode_pembayaran ?? '-'); ?></small>
                            </td>
                            <td class="fw-bold text-primary">
                                Rp <?php echo e(number_format($pemesanan->total_bayar, 0, ',', '.')); ?>

                            </td>
                            <td>
                                <?php if($pemesanan->status_pesan == 'Menunggu Konfirmasi'): ?>
                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                <?php elseif($pemesanan->status_pesan == 'Sedang Diproses'): ?>
                                    <span class="badge bg-info text-dark">Sedang Diproses</span>
                                <?php elseif($pemesanan->status_pesan == 'Menunggu Kurir'): ?>
                                    <span class="badge bg-secondary">Menunggu Kurir</span>
                                <?php elseif($pemesanan->status_pesan == 'Selesai'): ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php elseif($pemesanan->status_pesan == 'Dibatalkan'): ?>
                                    <span class="badge bg-danger">Dibatalkan</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="<?php echo e(route('pemesanans.show', $pemesanan->id)); ?>" class="btn btn-sm btn-outline-primary" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('pemesanans.edit', $pemesanan->id)); ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('pemesanans.destroy', $pemesanan->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus pesanan ini?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox display-4 text-muted d-block mb-3"></i>
                                <p class="text-muted mb-3">Belum ada data pemesanan</p>
                                <a href="<?php echo e(route('pemesanans.create')); ?>" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Tambah Pesanan Pertama
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <?php if($pemesanans->hasPages()): ?>
        <div class="card-footer bg-white border-0 py-3">
            <?php echo e($pemesanans->links('pagination::bootstrap-5')); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Search filter
    document.getElementById('searchOrder')?.addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        document.querySelectorAll('.order-row').forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });

    // Status filter
    document.getElementById('filterStatus')?.addEventListener('change', function() {
        let status = this.value;
        document.querySelectorAll('.order-row').forEach(row => {
            if (status === '' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    function resetFilter() {
        document.getElementById('searchOrder').value = '';
        document.getElementById('filterStatus').value = '';
        document.querySelectorAll('.order-row').forEach(row => {
            row.style.display = '';
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/pemesanans/index.blade.php ENDPATH**/ ?>