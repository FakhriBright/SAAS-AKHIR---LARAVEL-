

<?php $__env->startSection('title', 'Checkout Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .checkout-container { padding: 40px 0; max-width: 1200px; margin: 0 auto; }
    
    .page-header { margin-bottom: 32px; }
    .page-header h2 { font-weight: 700; margin-bottom: 4px; }
    .page-header p { color: #666; margin: 0; }
    
    .checkout-grid { display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px; }
    
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
    
    /* Form Styles */
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-weight: 600; margin-bottom: 8px; color: #333; }
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #ddd;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: #2d6a4f;
        box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
    }
    textarea.form-control { min-height: 100px; resize: vertical; }
    
    /* Order Items */
    .checkout-item {
        display: flex;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .checkout-item:last-child { border-bottom: none; }
    .item-image {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .item-image img { width: 100%; height: 100%; object-fit: cover; }
    .item-details { flex: 1; }
    .item-name { font-weight: 600; margin-bottom: 4px; }
    .item-desc { font-size: 0.85rem; color: #666; margin-bottom: 8px; }
    .item-qty { font-size: 0.9rem; color: #888; }
    .item-price { font-weight: 700; color: #2d6a4f; font-size: 1.05rem; }
    
    /* Summary */
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
    
    /* Payment Methods */
    .payment-methods { display: flex; flex-direction: column; gap: 12px; }
    .payment-method {
        display: flex;
        align-items: center;
        padding: 16px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .payment-method:hover { border-color: #2d6a4f; }
    .payment-method input[type="radio"] {
        margin-right: 12px;
        accent-color: #2d6a4f;
    }
    .payment-method.active {
        border-color: #2d6a4f;
        background: #f0f7f4;
    }
    .payment-icon {
        width: 40px;
        height: 40px;
        background: #f0f7f4;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1.2rem;
    }
    .payment-info { flex: 1; }
    .payment-name { font-weight: 600; margin-bottom: 2px; }
    .payment-desc { font-size: 0.85rem; color: #666; }
    
    /* ✅ PAYMENT DETAILS BOX */
    .payment-details-box {
        margin-top: 16px;
        padding: 16px;
        background: #f0f7f4;
        border-radius: 12px;
        border-left: 4px solid #2d6a4f;
        display: none;
    }
    .payment-details-box.show { display: block; animation: slideDown 0.3s ease; }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .payment-details-title {
        font-weight: 700;
        color: #2d6a4f;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .payment-detail-item {
        padding: 12px;
        background: white;
        border-radius: 8px;
        margin-bottom: 8px;
        border: 1px solid #e0e0e0;
    }
    .payment-detail-item:last-child { margin-bottom: 0; }
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 4px 0;
    }
    .detail-label { color: #666; font-size: 0.9rem; }
    .detail-value {
        font-weight: 600;
        color: #333;
    }
    .detail-value.rekening {
        background: #2d6a4f;
        color: white;
        padding: 4px 12px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 1.05rem;
    }
    .cod-badge {
        background: linear-gradient(135deg, #2d6a4f, #1b4332);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    /* Submit Button */
    .btn-checkout-submit {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #2d6a4f 0%, #1b4332 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 24px;
    }
    .btn-checkout-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(45, 106, 79, 0.3);
    }
    .btn-checkout-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #666;
        text-decoration: none;
        margin-bottom: 20px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .back-link:hover { color: #2d6a4f; }
    
    @media (max-width: 992px) {
        .checkout-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="container checkout-container">
    <a href="<?php echo e(route('customer.cart.index')); ?>" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke Keranjang
    </a>
    
    <div class="page-header">
        <h2>Checkout Pesanan</h2>
        <p>Lengkapi informasi pengiriman dan pembayaran Anda</p>
    </div>

    <form action="<?php echo e(route('customer.order.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="checkout-grid">
            
            <div>
                
                <div class="card">
                    <div class="card-title">
                        <i class="bi bi-truck"></i> Informasi Pengiriman
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tanggal Pengiriman <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_pesan" class="form-control" 
                               value="<?php echo e(old('tgl_pesan', date('Y-m-d'))); ?>" 
                               min="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="3" 
                                  placeholder="Masukkan alamat lengkap pengiriman..." required><?php echo e(old('alamat', auth()->guard('pelanggan')->user()->alamat1 ?? '')); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Catatan Pesanan</label>
                        <textarea name="catatan" class="form-control" rows="2" 
                                  placeholder="Catatan tambahan untuk pesanan Anda..."><?php echo e(old('catatan')); ?></textarea>
                    </div>
                </div>

                
                <div class="card">
                    <div class="card-title">
                        <i class="bi bi-credit-card"></i> Metode Pembayaran
                    </div>
                    
                    <div class="payment-methods">
                        <?php $__currentLoopData = $jenisPembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="payment-method <?php echo e($loop->first ? 'active' : ''); ?>" 
                               data-method-id="<?php echo e($jp->id); ?>">
                            <input type="radio" name="id_jenis_bayar" value="<?php echo e($jp->id); ?>" 
                                   <?php echo e($loop->first ? 'checked' : ''); ?> required>
                            <div class="payment-icon">
                                <?php if(str_contains(strtolower($jp->metode_pembayaran), 'cod') || str_contains(strtolower($jp->metode_pembayaran), 'bayar')): ?>
                                    <i class="bi bi-cash-coin"></i>
                                <?php elseif(str_contains(strtolower($jp->metode_pembayaran), 'transfer')): ?>
                                    <i class="bi bi-bank"></i>
                                <?php else: ?>
                                    <i class="bi bi-wallet2"></i>
                                <?php endif; ?>
                            </div>
                            <div class="payment-info">
                                <div class="payment-name"><?php echo e($jp->metode_pembayaran); ?></div>
                                <div class="payment-desc"><?php echo e($jp->deskripsi ?? 'Pembayaran ' . $jp->metode_pembayaran); ?></div>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    
                    <div id="payment-details-box" class="payment-details-box">
                        <div class="payment-details-title">
                            <i class="bi bi-info-circle"></i>
                            <span>Informasi Pembayaran</span>
                        </div>
                        <div id="payment-details-content"></div>
                    </div>
                </div>
            </div>

            
            <div>
                <div class="card">
                    <div class="card-title">
                        <i class="bi bi-receipt"></i> Ringkasan Pesanan
                    </div>
                    
                    
                    <div class="checkout-items">
                        <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="checkout-item">
                            <div class="item-image">
                                <?php if($cart->paket->foto1 && file_exists(public_path('storage/' . $cart->paket->foto1))): ?>
                                    <img src="<?php echo e(asset('storage/' . $cart->paket->foto1)); ?>" alt="<?php echo e($cart->paket->nama_paket); ?>">
                                <?php else: ?>
                                    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=200&h=200&fit=crop" alt="<?php echo e($cart->paket->nama_paket); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="item-details">
                                <div class="item-name"><?php echo e($cart->paket->nama_paket); ?></div>
                                <div class="item-desc"><?php echo e(Str::limit($cart->paket->deskripsi, 40)); ?></div>
                                <div class="item-qty"><?php echo e($cart->jumlah); ?> x Rp <?php echo e(number_format($cart->paket->harga_paket, 0, ',', '.')); ?></div>
                            </div>
                            <div class="item-price">Rp <?php echo e(number_format($cart->subtotal ?? ($cart->jumlah * $cart->paket->harga_paket), 0, ',', '.')); ?></div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    
                    <div class="summary-row">
                        <span class="summary-label">Total Item</span>
                        <span class="summary-value"><?php echo e($carts->sum('jumlah')); ?> paket</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Pajak & Ongkir</span>
                        <span class="summary-value" style="color: #2d6a4f;">Gratis</span>
                    </div>
                    <div class="summary-total">
                        <span>Total Pembayaran</span>
                        <span>Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                    </div>
                    
                    <button type="submit" class="btn-checkout-submit">
                        <i class="bi bi-check-circle"></i> Konfirmasi Pesanan
                    </button>
                    
                    <p style="text-align: center; margin-top: 16px; font-size: 0.85rem; color: #666;">
                        <i class="bi bi-shield-check"></i> Pesanan Anda aman dan terenkripsi
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentDetailsData = <?php echo json_encode($paymentDetails ?? [], 15, 512) ?>;
    const paymentMethods = document.querySelectorAll('.payment-method');
    const paymentDetailsBox = document.getElementById('payment-details-box');
    const paymentDetailsContent = document.getElementById('payment-details-content');
    
    function showPaymentDetails(methodId) {
        const details = paymentDetailsData[String(methodId)] || paymentDetailsData[methodId] || [];
        const detailsArray = Array.isArray(details) ? details : [details];
        
        if (!detailsArray.length || (detailsArray.length === 1 && !detailsArray[0].no_rek && !detailsArray[0].nomor_rekening)) {
            paymentDetailsBox.classList.remove('show');
            return;
        }
        
        let html = '';
        
        detailsArray.forEach(function(detail) {
            const noRek = detail.no_rek || detail.nomor_rekening || '';
            const namaPemilik = detail.tempat_bayar || detail.nama_pemilik || '';
            const bank = detail.bank || '';
            
            // Cek apakah COD
            const isCOD = noRek && (noRek.toLowerCase().includes('bayar') || noRek.toLowerCase().includes('tempat'));
            
            if (isCOD) {
                html += `
                    <div class="payment-detail-item" style="text-align: center; padding: 20px;">
                        <div style="background: linear-gradient(135deg, #2d6a4f, #1b4332); color: white; padding: 16px; border-radius: 12px;">
                            <i class="bi bi-cash-coin" style="font-size: 2.5rem;"></i>
                            <div style="font-size: 1.3rem; font-weight: 700; margin: 12px 0;">
                                💵 ${noRek}
                            </div>
                            <small style="opacity: 0.9;">${namaPemilik || 'Siapkan uang pas saat kurir tiba'}</small>
                        </div>
                    </div>
                `;
            } else {
                html += `
                    <div class="payment-detail-item" style="background: white; border-radius: 8px; padding: 12px; margin-bottom: 8px; border: 1px solid #e0e0e0;">
                        <div style="display: flex; justify-content: space-between; padding: 6px 0;">
                            <span style="color: #666;">👤 Atas Nama</span>
                            <span style="font-weight: 600;">${namaPemilik || '-'}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 6px 0;">
                            <span style="color: #666;">🔢 No. Rekening</span>
                            <span style="background: #2d6a4f; color: white; padding: 4px 12px; border-radius: 6px; font-family: monospace; font-size: 1.05rem;">${noRek}</span>
                        </div>
                        ${bank ? `<div style="display: flex; justify-content: space-between; padding: 6px 0;"><span style="color: #666;">🏦 Bank</span><span style="font-weight: 600;">${bank}</span></div>` : ''}
                    </div>
                `;
            }
        });
        
        html += `
            <div style="margin-top: 16px; padding: 12px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
                <small style="color: #856404;">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Transfer sesuai total pesanan: <strong>Rp <?php echo e(number_format($total, 0, ',', '.')); ?></strong>
                </small>
            </div>
        `;
        
        paymentDetailsContent.innerHTML = html;
        paymentDetailsBox.classList.add('show');
    }
    
    // Event listeners
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            paymentMethods.forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            
            const radioInput = this.querySelector('input[type="radio"]');
            const methodId = radioInput.value;
            showPaymentDetails(methodId);
        });
    });
    
    // Trigger on load
    const selectedMethod = document.querySelector('.payment-method input[type="radio"]:checked');
    if (selectedMethod) {
        const methodId = selectedMethod.value;
        setTimeout(() => showPaymentDetails(methodId), 100);
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/customer/checkout.blade.php ENDPATH**/ ?>