<?php $__env->startSection('title', 'Data Pengiriman'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-truck"></i> Data Pengiriman</h2>
            <p class="text-muted mb-0">Kelola pengiriman pesanan catering</p>
        </div>
        <a href="<?php echo e(route('pengirimans.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pengiriman
        </a>
    </div>

    
    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Pelanggan</th>
                            <th width="15%">No. Resi</th>
                            <th width="15%">Tgl Kirim</th>
                            <th width="15%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pengirimans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td>
                                <div class="fw-semibold">
                                    <?php echo e($d->pemesanan->pelanggan->nama_pelanggan ?? '-'); ?>

                                </div>
                                <small class="text-muted">
                                    <?php echo e($d->pemesanan->pelanggan->telepon ?? ''); ?>

                                </small>
                            </td>
                            <td>
                                <strong><?php echo e($d->pemesanan->no_resi ?? '-'); ?></strong>
                            </td>
                            <td>
                                <?php echo e($d->tgl_kirim ? \Carbon\Carbon::parse($d->tgl_kirim)->format('d/m/Y') : '-'); ?>

                            </td>
                            <td>
                                <?php if($d->status_kirim == 'Sedang Dikirim'): ?>
                                    <span class="badge bg-primary">🚚 Sedang Dikirim</span>
                                <?php elseif($d->status_kirim == 'Tiba Ditujuan'): ?>
                                    <span class="badge bg-success">✅ Tiba Ditujuan</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark"><?php echo e($d->status_kirim ?? 'Menunggu'); ?></span>
                                <?php endif; ?>
                            </td>
                                                <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Pelanggan</th>
                            <th width="15%">No. Resi</th>
                            <th width="12%">Tgl Kirim</th>
                            <th width="10%">Status</th>
                            <th width="10%">Bukti</th> 
                            <th width="13%">Aksi</th>
                        </tr>
                    </thead>
                            
                            <td class="text-center">
                                <?php if($d->bukti_foto): ?>
                                    <a href="<?php echo e(asset('storage/' . $d->bukti_foto)); ?>" target="_blank">
                                        <img src="<?php echo e(asset('storage/' . $d->bukti_foto)); ?>" alt="Bukti"
                                             class="img-thumbnail" style="max-width: 60px; max-height: 40px;">
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Belum Upload</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo e(route('pengirimans.edit', $d->id)); ?>"
                                       class="btn btn-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="<?php echo e(route('pengirimans.destroy', $d->id)); ?>"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data pengiriman ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada data pengiriman</p>
                                <a href="<?php echo e(route('pengirimans.create')); ?>" class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-plus-circle"></i> Tambah Pengiriman
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .table th { font-weight: 600; text-transform: uppercase; font-size: 0.85rem; background-color: #f8f9fa; }
    .badge { padding: 0.5em 0.8em; font-weight: 500; }
    .btn-group-sm .btn { padding: 0.25rem 0.4rem; font-size: 0.75rem; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\catering-online\resources\views/pengirimans/index.blade.php ENDPATH**/ ?>