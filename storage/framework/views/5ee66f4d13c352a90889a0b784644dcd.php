

<?php $__env->startSection('title', 'Detail Pesanan #' . $order->no_resi); ?>

<?php $__env->startSection('content'); ?>
<style>
    .order-detail-container { padding: 40px 0; max-width: 1200px; margin: 0 auto; }
    
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #666;
        text-decoration: none;
        margin-bottom: 24px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .back-button:hover { color: #2d6a4f; }
    
    .order-header-card {
        background: linear-gradient(135deg, #2d6a4f 0%, #1b4332 100%);
        color: white;
        padding: 32px;
        border-radius: 20px;
        margin-bottom: 24px;
        box-shadow: 0 8px 25px rgba(45, 106, 79, 0.2);
    }
    .order-header-card h2 { margin: 0 0 8px; font-weight: 700; }
    .order-header-card .resi { font-size: 1.1rem; opacity: 0.9; margin-bottom: 24px; }
    
    .status-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: rgba(255,255,255,0.2);
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
    
    .card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        border: 1px solid #f0f0f0;
        margin-bottom: 24px;
    }
    .card-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    .info-item h4 { margin: 0 0 4px; font-size: 0.85rem; color: #666; font-weight: 500; }
    .info-item p { margin: 0; font-weight: 600; color: #333; }
    
    .order-items-table { width: 100%; border-collapse: collapse; }
    .order-items-table th {
        text-align: left;
        padding: 12px;
        background: #f8f9fa;
        font-size: 0.85rem;
        color: #666;
        font-weight: 600;
        border-bottom: 2px solid #e0e0e0;
    }
    .order-items-table td {
        padding: 16px 12px;
        border-bottom: 1px solid #f0f0f0;
    }
    .order-items-table tr:last-child td { border-bottom: none; }
    .item-name { font-weight: 600; color: #333; }
    .item-desc { font-size: 0.85rem; color: #888; margin-top: 4px; }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .summary-row:last-child { border-bottom: none; }
    .summary-label { color: #666; }
    .summary-value { font-weight: 600; color: #333; }
    .summary-total {
        display: flex;
        justify-content: space-between;
        padding: 20px 0 0;
        margin-top: 12px;
        border-top: 2px solid #2d6a4f;
        font-size: 1.2rem;
        font-weight: 700;
        color: #2d6a4f;
    }
    
    .action-buttons { display: flex; flex-direction: column; gap: 12px; }
    .btn-action {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }
    .btn-primary { background: #2d6a4f; color: white; }
    .btn-primary:hover { background: #1b4332; transform: translateY(-2px); }
    .btn-danger { background: #dc3545; color: white; }
    .btn-danger:hover { background: #b02a37; transform: translateY(-2px); }
    .btn-outline { background: white; color: #2d6a4f; border: 2px solid #2d6a4f; }
    .btn-outline:hover { background: #f8f9fa; }
    
    /* ✅ PAYMENT DETAILS CARD */
    .payment-info-card {
        border: 2px solid #2d6a4f;
        background: linear-gradient(135deg, #f0f7f4 0%, #ffffff 100%);
    }
    .payment-info-card .card-title { color: #2d6a4f; }
    
    .payment-account-item {
        background: white;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .payment-account-item:last-child { margin-bottom: 0; }
    
    .account-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
    }
    .account-label { color: #666; font-size: 0.9rem; }
    .account-value { font-weight: 600; color: #333; }
    .account-value.rekening {
        background: #2d6a4f;
        color: white;
        padding: 6px 16px;
        border-radius: 8px;
        font-family: monospace;
        font-size: 1.1rem;
        letter-spacing: 1px;
    }
    
    .cod-info {
        text-align: center;
        padding: 20px;
        background: linear-gradient(135deg, #2d6a4f, #1b4332);
        border-radius: 12px;
        color: white;
    }
    .cod-info i { font-size: 2rem; margin-bottom: 12px; }
    .cod-info .cod-text { font-size: 1.2rem; font-weight: 700; margin-bottom: 8px; }
    .cod-info small { opacity: 0.9; }
    
    .payment-note {
        margin-top: 16px;
        padding: 12px;
        background: #fff3cd;
        border-radius: 8px;
        border-left: 4px solid #ffc107;
    }
    .payment-note small { color: #856404; }
    
    @media (max-width: 992px) {
        .content-grid { grid-template-columns: 1fr; }
        .info-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="container order-detail-container">
    
    <a href="<?php echo e(route('customer.orders')); ?>" class="back-button">
        <i class="bi bi-arrow-left"></i> Kembali ke Pesanan
    </a>

    
    <div class="order-header-card">
        <h2>Detail Pesanan</h2>
        <div class="resi">No. Resi: <?php echo e($order->no_resi); ?></div>
        <div class="status-badge-large">
            <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?>
                <i class="bi bi-hourglass-split fs-4"></i>
            <?php elseif($order->status_pesan == 'Sedang Diproses'): ?>
                <i class="bi bi-gear fs-4"></i>
            <?php elseif($order->status_pesan == 'Menunggu Kurir'): ?>
                <i class="bi bi-truck fs-4"></i>
            <?php elseif($order->status_pesan == 'Selesai'): ?>
                <i class="bi bi-check-circle fs-4"></i>
            <?php else: ?>
                <i class="bi bi-x-circle fs-4"></i>
            <?php endif; ?>
            <?php echo e($order->status_pesan); ?>

        </div>
    </div>

    <div class="content-grid">
        
        <div>
            
            <div class="card">
                <div class="card-title">
                    <i class="bi bi-info-circle"></i> Informasi Pesanan
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <h4>Tanggal Pesan</h4>
                        <p><?php echo e($order->tgl_pesan->format('d F Y')); ?></p>
                    </div>
                    <div class="info-item">
                        <h4>Metode Pembayaran</h4>
                        <p><?php echo e($order->jenisPembayaran->metode_pembayaran ?? 'COD (Bayar di Tempat)'); ?></p>
                    </div>
                    <div class="info-item">
                        <h4>Catatan</h4>
                        <p><?php echo e($order->catatan ?? '-'); ?></p>
                    </div>
                </div>
            </div>

            
            <?php if(isset($paymentDetails) && $paymentDetails->count() > 0): ?>
            <div class="card payment-info-card">
                <div class="card-title">
                    <i class="bi bi-credit-card"></i> Informasi Pembayaran
                </div>
                <p style="margin-bottom: 16px; color: #666;">
                    Silakan transfer sesuai nominal total pesanan ke rekening berikut:
                </p>
                
                <?php $__currentLoopData = $paymentDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $isCOD = $detail->nomor_rekening && 
                        (str_contains(strtolower($detail->nomor_rekening), 'bayar') || 
                         str_contains(strtolower($detail->nomor_rekening), 'tempat') ||
                         ($detail->nama_pemilik && str_contains(strtolower($detail->nama_pemilik), 'tempat')));
                ?>
                
                <?php if($isCOD): ?>
                <div class="payment-account-item">
                    <div class="cod-info">
                        <i class="bi bi-cash-coin"></i>
                        <div class="cod-text"><?php echo e($detail->nomor_rekening); ?></div>
                        <small><?php echo e($detail->nama_pemilik ?? 'Silakan siapkan uang pas saat kurir tiba'); ?></small>
                    </div>
                </div>
                <?php else: ?>
                <div class="payment-account-item">
                    <div class="account-row">
                        <span class="account-label">👤 Atas Nama</span>
                        <span class="account-value"><?php echo e($detail->nama_pemilik ?? '-'); ?></span>
                    </div>
                    <div class="account-row">
                        <span class="account-label">🔢 No. Rekening</span>
                        <span class="account-value rekening"><?php echo e($detail->nomor_rekening); ?></span>
                    </div>
                    <?php if($detail->bank): ?>
                    <div class="account-row">
                        <span class="account-label">🏦 Bank</span>
                        <span class="account-value"><?php echo e($detail->bank); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="payment-note">
                    <small>
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <strong>Penting:</strong> Transfer sesuai total pesanan: 
                        <strong>Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></strong>. 
                        Simpan bukti transfer Anda.
                    </small>
                </div>
            </div>
            <?php endif; ?>

            
            <div class="card">
                <div class="card-title">
                    <i class="bi bi-cart3"></i> Item Pesanan
                </div>
                <table class="order-items-table">
                    <thead>
                        <tr>
                            <th>Paket</th>
                            <th style="text-align: center;">Jumlah</th>
                            <th style="text-align: right;">Harga</th>
                            <th style="text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $order->detailPemesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="item-name"><?php echo e($detail->paket->nama_paket); ?></div>
                                <div class="item-desc"><?php echo e($detail->paket->kategori); ?></div>
                            </td>
                            <td style="text-align: center;"><?php echo e($detail->jumlah); ?></td>
                            <td style="text-align: right;">Rp <?php echo e(number_format($detail->paket->harga_paket, 0, ',', '.')); ?></td>
                            <td style="text-align: right; font-weight: 700; color: #2d6a4f;">
                                Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div>
            
            <div class="card">
                <div class="card-title">
                    <i class="bi bi-receipt"></i> Ringkasan Pembayaran
                </div>
                <div class="summary-row">
                    <span class="summary-label">Subtotal</span>
                    <span class="summary-value">Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Pajak & Ongkir</span>
                    <span class="summary-value" style="color: #2d6a4f;">Gratis</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></span>
                </div>
            </div>

            
            <div class="card">
                <div class="action-buttons">
                    <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?>
                    <form action="<?php echo e(route('customer.order.cancel', $order->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn-action btn-danger">
                            <i class="bi bi-x-circle"></i> Batalkan Pesanan
                        </button>
                    </form>
                    <?php endif; ?>
                    
                    <?php if($order->status_pesan == 'Selesai'): ?>
                    <button class="btn-action btn-outline" onclick="window.print()">
                        <i class="bi bi-printer"></i> Cetak Struk
                    </button>
                    <?php endif; ?>
                    
                    <a href="https://wa.me/6285842517974?text=Halo%20Fakhri%20Kitchen,%20saya%20mau%20tanya%20tentang%20pesanan%20<?php echo e($order->no_resi); ?>" 
                       class="btn-action btn-primary" target="_blank">
                        <i class="bi bi-whatsapp"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/customer/order-detail.blade.php ENDPATH**/ ?>