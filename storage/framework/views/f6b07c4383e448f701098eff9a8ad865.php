<?php $__env->startSection('title', 'Pesanan Saya'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .orders-container { padding: 40px 0; max-width: 1400px; margin: 0 auto; }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .page-title h2 { font-weight: 700; margin-bottom: 4px; }
    .page-title p { color: #666; margin: 0; }
    
    .btn-pesan-baru {
        background: linear-gradient(135deg, #2d6a4f 0%, #1b4332 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        text-decoration: none;
    }
    .btn-pesan-baru:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(45, 106, 79, 0.3);
        color: white;
    }
    
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        border: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
    }
    .stat-icon.all { background: #e3f2fd; color: #2196f3; }
    .stat-icon.pending { background: #fff3e0; color: #ff9800; }
    .stat-icon.process { background: #e8f5e9; color: #4caf50; }
    .stat-icon.completed { background: #f3e5f5; color: #9c27b0; }
    .stat-info h3 { margin: 0; font-size: 1.5rem; font-weight: 700; }
    .stat-info p { margin: 0; color: #666; font-size: 0.9rem; }
    
    /* Order Cards */
    .orders-list { display: flex; flex-direction: column; gap: 16px; }
    .order-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        border: 1px solid #f0f0f0;
        transition: all 0.3s;
    }
    .order-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .order-info h4 { margin: 0 0 4px; font-weight: 700; color: #1a1a1a; }
    .order-meta { color: #666; font-size: 0.9rem; display: flex; gap: 16px; flex-wrap: wrap; }
    .order-meta span { display: flex; align-items: center; gap: 4px; }
    
    .order-status {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-menunggu-konfirmasi { background: #fff3cd; color: #856404; }
    .status-sedang-diproses { background: #d1ecf1; color: #0c5460; }
    .status-menunggu-kurir { background: #e2e3e5; color: #383d41; }
    .status-selesai { background: #d4edda; color: #155724; }
    .status-dibatalkan { background: #f8d7da; color: #721c24; }
    
    .order-items {
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        padding: 16px 0;
        margin-bottom: 16px;
    }
    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
    }
    .item-name { font-weight: 600; color: #333; }
    .item-qty { color: #666; font-size: 0.9rem; }
    .item-price { font-weight: 700; color: #2d6a4f; }
    
    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    .order-total {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2d6a4f;
    }
    .order-total span { color: #666; font-size: 0.9rem; font-weight: 400; margin-right: 8px; }
    
    .order-actions { display: flex; gap: 8px; }
    .btn-order {
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: white;
        color: #333;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
    }
    .btn-order:hover { background: #f8f9fa; border-color: #2d6a4f; color: #2d6a4f; }
    .btn-order.primary {
        background: #2d6a4f;
        color: white;
        border-color: #2d6a4f;
    }
    .btn-order.primary:hover { background: #1b4332; }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    }
    .empty-state i { font-size: 4rem; color: #ddd; margin-bottom: 16px; }
    .empty-state h3 { color: #333; margin-bottom: 8px; }
    .empty-state p { color: #666; margin-bottom: 24px; }
    
    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .stats-grid { grid-template-columns: 1fr; }
        .order-header { flex-direction: column; }
        .order-footer { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="container orders-container">
    
    <div class="page-header">
        <div class="page-title">
            <h2>Pesanan Saya</h2>
            <p>Kelola semua pesanan catering Anda</p>
        </div>
        <a href="<?php echo e(route('customer.catalog')); ?>" class="btn-pesan-baru">
            <i class="bi bi-plus-circle"></i> Pesan Baru
        </a>
    </div>

    <?php if($orders->count() > 0): ?>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon all">
                <i class="bi bi-bag"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($orders->count()); ?></h3>
                <p>Total Pesanan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="bi bi-clock"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($orders->where('status_pesan', 'Menunggu Konfirmasi')->count()); ?></h3>
                <p>Menunggu Konfirmasi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon process">
                <i class="bi bi-gear"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($orders->whereIn('status_pesan', ['Sedang Diproses', 'Menunggu Kurir'])->count()); ?></h3>
                <p>Dalam Proses</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon completed">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($orders->where('status_pesan', 'Selesai')->count()); ?></h3>
                <p>Selesai</p>
            </div>
        </div>
    </div>

    
    <div class="orders-list">
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="order-card">
            <div class="order-header">
                <div class="order-info">
                    <h4><?php echo e($order->no_resi); ?></h4>
                    <div class="order-meta">
                        <span><i class="bi bi-calendar"></i> <?php echo e($order->tgl_pesan->format('d F Y')); ?></span>
                        <span><i class="bi bi-clock"></i> <?php echo e($order->created_at->format('H:i')); ?> WIB</span>
                    </div>
                </div>
                <div class="order-status status-<?php echo e(strtolower(str_replace(' ', '-', $order->status_pesan))); ?>">
                    <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?>
                        <i class="bi bi-hourglass-split"></i>
                    <?php elseif($order->status_pesan == 'Sedang Diproses'): ?>
                        <i class="bi bi-gear"></i>
                    <?php elseif($order->status_pesan == 'Menunggu Kurir'): ?>
                        <i class="bi bi-truck"></i>
                    <?php elseif($order->status_pesan == 'Selesai'): ?>
                        <i class="bi bi-check-circle"></i>
                    <?php else: ?>
                        <i class="bi bi-x-circle"></i>
                    <?php endif; ?>
                    <?php echo e($order->status_pesan); ?>

                </div>
            </div>

            <div class="order-items">
                <?php $__currentLoopData = $order->detailPemesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="order-item">
                    <div>
                        <div class="item-name"><?php echo e($detail->paket->nama_paket); ?></div>
                        <div class="item-qty"><?php echo e($detail->jumlah); ?> x Rp <?php echo e(number_format($detail->paket->harga_paket, 0, ',', '.')); ?></div>
                    </div>
                    <div class="item-price">Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="order-footer">
                <div class="order-total">
                    <span>Total Pembayaran</span>
                    Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?>

                </div>
                <div class="order-actions">
                    <a href="<?php echo e(route('customer.order.show', $order->id)); ?>" class="btn-order primary">
                        <i class="bi bi-eye"></i> Detail Pesanan
                    </a>
                    <?php if($order->status_pesan == 'Menunggu Konfirmasi'): ?>
                    <form action="<?php echo e(route('customer.order.cancel', $order->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn-order">
                            <i class="bi bi-x-circle"></i> Batalkan
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    
    <div class="empty-state">
        <i class="bi bi-bag-x"></i>
        <h3>Belum Ada Pesanan</h3>
        <p>Yuk pesan catering untuk acara Anda sekarang!</p>
        <a href="<?php echo e(route('customer.catalog')); ?>" class="btn-pesan-baru">
            <i class="bi bi-grid"></i> Lihat Katalog
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\saas-akhir\resources\views/customer/orders.blade.php ENDPATH**/ ?>