<?php $__env->startSection('title', 'Detail Pemesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-receipt"></i> Detail Pemesanan</h2>
            <p class="text-muted mb-0">No. Resi: <strong><?php echo e($pemesanan->no_resi); ?></strong></p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('pemesanans.index')); ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="<?php echo e(route('pemesanans.edit', $pemesanan->id)); ?>" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="<?php echo e(route('pemesanans.pdf', $pemesanan->id)); ?>" class="btn btn-danger" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Cetak Invoice
            </a>
            <form action="<?php echo e(route('pemesanans.destroy', $pemesanan->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person"></i> Informasi Pelanggan</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Nama:</strong> <?php echo e($pemesanan->pelanggan->nama_pelanggan ?? '-'); ?></p>
                    <p class="mb-2"><strong>Email:</strong> <?php echo e($pemesanan->pelanggan->email ?? '-'); ?></p>
                    <p class="mb-2"><strong>Telepon:</strong> <?php echo e($pemesanan->pelanggan->telepon ?? '-'); ?></p>
                    <p class="mb-0"><strong>Alamat:</strong><br>
                        <?php echo e($pemesanan->pelanggan->alamat1 ?? '-'); ?>

                        <?php if($pemesanan->pelanggan->alamat2): ?>, <?php echo e($pemesanan->pelanggan->alamat2); ?><?php endif; ?>
                        <?php if($pemesanan->pelanggan->alamat3): ?>, <?php echo e($pemesanan->pelanggan->alamat3); ?><?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-credit-card"></i> Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Metode:</strong> <?php echo e($pemesanan->jenisPembayaran->metode_pembayaran ?? '-'); ?></p>
                    <p class="mb-2"><strong>Tanggal Pesan:</strong> <?php echo e($pemesanan->tgl_pesan?->format('d/m/Y H:i') ?? '-'); ?></p>
                    <p class="mb-2"><strong>Status:</strong>
                        <?php if($pemesanan->status_pesan == 'Menunggu Konfirmasi'): ?>
                            <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                        <?php elseif($pemesanan->status_pesan == 'Sedang Diproses'): ?>
                            <span class="badge bg-info text-dark">Sedang Diproses</span>
                        <?php elseif($pemesanan->status_pesan == 'Menunggu Kurir'): ?>
                            <span class="badge bg-secondary">Menunggu Kurir</span>
                        <?php elseif($pemesanan->status_pesan == 'Selesai'): ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php else: ?>
                            <span class="badge bg-light text-dark"><?php echo e($pemesanan->status_pesan ?? '-'); ?></span>
                        <?php endif; ?>
                    </p>
                    <p class="mb-0"><strong>No. Resi:</strong> <?php echo e($pemesanan->no_resi); ?></p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="bi bi-box-seam"></i> Detail Paket yang Dipesan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Nama Paket</th>
                            <th width="20%">Harga Satuan</th>
                            <th width="15%">Jumlah</th>
                            <th width="20%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pemesanan->detailPemesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td>
                                <strong><?php echo e($detail->paket->nama_paket ?? 'Paket Dihapus'); ?></strong>
                                <?php if($detail->paket && $detail->paket->deskripsi): ?>
                                    <br><small class="text-muted"><?php echo e(Str::limit($detail->paket->deskripsi, 60)); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>Rp <?php echo e(number_format($detail->paket->harga ?? 0, 0, ',', '.')); ?></td>
                            <td><?php echo e($detail->jumlah); ?></td>
                            <td class="fw-bold text-primary">
                                Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                Tidak ada detail paket
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end fs-6">Total Bayar:</th>
                            <th class="fw-bold text-primary fs-5">
                                Rp <?php echo e(number_format($pemesanan->total_bayar, 0, ',', '.')); ?>

                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .card { border-radius: 10px; overflow: hidden; }
    .table th { font-weight: 600; text-transform: uppercase; font-size: 0.85rem; background-color: #f8f9fa; }
    .badge { padding: 0.5em 0.8em; font-weight: 500; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\catering-online\resources\views/pemesanans/show.blade.php ENDPATH**/ ?>