

<?php $__env->startSection('title', 'Detail Pesanan #<?php echo e($order->no_resi); ?>'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Pesanan</h2>
            <p class="text-muted mb-0">No. Resi: <span class="fw-bold text-primary"><?php echo e($order->no_resi); ?></span></p>
        </div>
        <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    
    <?php
    $statusConfig = [
        'Menunggu Konfirmasi' => ['class' => 'warning', 'icon' => 'bi-hourglass-split', 'desc' => 'Pesanan sedang menunggu konfirmasi admin'],
        'Sedang Diproses' => ['class' => 'info', 'icon' => 'bi-gear', 'desc' => 'Pesanan sedang disiapkan oleh dapur kami'],
        'Menunggu Kurir' => ['class' => 'primary', 'icon' => 'bi-truck', 'desc' => 'Pesanan siap diantar, menunggu kurir'],
        'Selesai' => ['class' => 'success', 'icon' => 'bi-check-circle', 'desc' => 'Pesanan telah selesai dan diterima'],
        'Dibatalkan' => ['class' => 'danger', 'icon' => 'bi-x-circle', 'desc' => 'Pesanan telah dibatalkan'],
    ];
    $config = $statusConfig[$order->status_pesan] ?? $statusConfig['Menunggu Konfirmasi'];
    ?>
    <div class="alert alert-<?php echo e($config['class']); ?> d-flex align-items-center mb-4" role="alert">
        <i class="bi <?php echo e($config['icon']); ?> fs-4 me-3"></i>
        <div>
            <h6 class="alert-heading fw-bold mb-0"><?php echo e($order->status_pesan); ?></h6>
            <small><?php echo e($config['desc']); ?></small>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-8">
            
            <div class="card-modern p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Pesanan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Tanggal Pesan</small>
                        <span class="fw-bold"><?php echo e($order->tgl_pesan->format('d F Y')); ?></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Metode Pembayaran</small>
                        <span class="fw-bold"><?php echo e($order->jenisPembayaran->metode_pembayaran ?? '-'); ?></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Catatan</small>
                        <span><?php echo e($order->catatan ?? 'Tidak ada'); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="card-modern p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-cart3 me-2"></i>Item Pesanan</h5>
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th>Paket</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->detailPemesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?php echo e($detail->paket->nama_paket ?? 'Paket Tidak Ditemukan'); ?></div>
                                    <small class="text-muted"><?php echo e($detail->paket->kategori ?? '-'); ?></small>
                                </td>
                                <td class="text-center"><?php echo e($detail->jumlah); ?></td>
                                <td class="text-end">Rp <?php echo e(number_format($detail->paket->harga_paket ?? 0, 0, ',', '.')); ?></td>
                                <td class="text-end fw-bold">Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <?php if($order->pengiriman): ?>
            <div class="card-modern p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-truck me-2"></i>Informasi Pengiriman</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Kurir</small>
                        <span class="fw-bold"><?php echo e($order->pengiriman->user->name ?? '-'); ?></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Tanggal Kirim</small>
                        <span><?php echo e($order->pengiriman->tgl_kirim?->format('d/m/Y H:i') ?? '-'); ?></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Estimasi Tiba</small>
                        <span><?php echo e($order->pengiriman->tgl_tiba?->format('d/m/Y H:i') ?? '-'); ?></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <small class="text-muted d-block">Status Kirim</small>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">
                            <?php echo e($order->pengiriman->status_kirim); ?>

                        </span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="col-lg-4">
            <div class="card-modern p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-3">Ringkasan Pembayaran</h5>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span>Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Pajak & Ongkir</span>
                    <span class="text-success">Gratis</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fs-5 fw-bold">Total</span>
                    <span class="fs-4 fw-bold text-primary">Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></span>
                </div>

                
                <div class="d-grid gap-2">
                    <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?>
                    <form action="<?php echo e(route('customer.order.cancel', $order->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn btn-danger w-100 rounded-pill">
                            <i class="bi bi-x-circle me-2"></i>Batalkan Pesanan
                        </button>
                    </form>
                    <?php endif; ?>
                    
                    <?php if($order->status_pesan == 'Selesai'): ?>
                    <button class="btn btn-success w-100 rounded-pill" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i>Cetak Struk
                    </button>
                    <?php endif; ?>
                    
                    <a href="https://wa.me/6285842517974?text=Halo%20Fakhri%20Kitchen,%20saya%20mau%20tanya%20tentang%20pesanan%20<?php echo e($order->no_resi); ?>" 
                       class="btn btn-outline-success w-100 rounded-pill" target="_blank">
                        <i class="bi bi-whatsapp me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('styles'); ?>
<style>
    .card-modern { background: white; border: none; border-radius: 20px; box-shadow: 0 5px 20px rgba(112, 144, 176, 0.08); }
    .table-modern { margin-bottom: 0; }
    .table-modern thead th { background: #f8f9fa; color: #a3aed0; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; padding: 1rem; border: none; }
    .table-modern tbody td { padding: 1rem; vertical-align: middle; color: #2b3674; font-weight: 500; border-bottom: 1px solid #f0f2f5; }
    .table-modern tbody tr:last-child td { border-bottom: none; }
    @media print {
        .no-print { display: none !important; }
        .card-modern { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/customer/order-detail.blade.php ENDPATH**/ ?>