<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan - <?php echo e($namaBulan); ?> <?php echo e($tahun); ?></title>
    <style>
        @page {
            margin: 2cm;
            size: A4;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #333;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #2d6a4f;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24pt;
            color: #2d6a4f;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 16pt;
            color: #666;
            font-weight: normal;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 11pt;
            color: #999;
        }
        
        .report-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .report-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .report-info td {
            padding: 5px;
            vertical-align: top;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .stat-box {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        
        .stat-box h3 {
            margin: 0;
            font-size: 28pt;
            color: #2d6a4f;
            font-weight: bold;
        }
        
        .stat-box p {
            margin: 5px 0 0;
            font-size: 10pt;
            color: #666;
        }
        
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #2d6a4f;
            border-bottom: 2px solid #2d6a4f;
            padding-bottom: 5px;
            margin: 30px 0 15px;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10pt;
        }
        
        table.data-table th {
            background: #2d6a4f;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #1b4332;
        }
        
        table.data-table td {
            padding: 8px 10px;
            border: 1px solid #dee2e6;
        }
        
        table.data-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        table.data-table tr:hover {
            background: #e9ecef;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9pt;
            font-weight: bold;
        }
        
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-info { background: #d1ecf1; color: #0c5460; }
        .badge-secondary { background: #d6d8db; color: #383d41; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        
        .status-summary {
            margin-top: 20px;
        }
        
        .status-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .status-summary td {
            padding: 8px;
            border: 1px solid #dee2e6;
        }
        
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 10pt;
        }
        
        .signature {
            margin-top: 60px;
            text-align: center;
            width: 200px;
            float: right;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    
    <div class="header">
        <h1>FAKHRI KITCHEN</h1>
        <h2>Laporan Bulanan Pemesanan Catering</h2>
        <p>Jl. Cikampak Cicadas, Bogor | Telp: 0858-4251-7974</p>
    </div>
    
    
    <div class="report-info">
        <table>
            <tr>
                <td width="50%">
                    <strong>Periode Laporan:</strong><br>
                    <?php echo e($namaBulan); ?> <?php echo e($tahun); ?>

                </td>
                <td width="50%">
                    <strong>Tanggal Cetak:</strong><br>
                    <?php echo e(date('d F Y')); ?>

                </td>
            </tr>
        </table>
    </div>
    
    
    <div class="stats-grid">
        <div class="stat-box">
            <h3><?php echo e($totalPesanan); ?></h3>
            <p>Total Pesanan</p>
        </div>
        <div class="stat-box">
            <h3>Rp <?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?></h3>
            <p>Total Pendapatan</p>
        </div>
        <div class="stat-box">
            <h3><?php echo e($totalPelanggan); ?></h3>
            <p>Total Pelanggan</p>
        </div>
        <div class="stat-box">
            <h3><?php echo e(number_format($totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0, 0, ',', '.')); ?></h3>
            <p>Rata-rata per Order</p>
        </div>
    </div>
    
    
    <div class="section-title">Ringkasan Status Pesanan</div>
    <div class="status-summary">
        <table>
            <tr style="background: #2d6a4f; color: white;">
                <th>Status</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Persentase</th>
            </tr>
            <tr>
                <td><span class="badge badge-warning">Menunggu Konfirmasi</span></td>
                <td class="text-center"><?php echo e($statusData['Menunggu Konfirmasi']); ?></td>
                <td class="text-center"><?php echo e($totalPesanan > 0 ? round(($statusData['Menunggu Konfirmasi'] / $totalPesanan) * 100, 1) : 0); ?>%</td>
            </tr>
            <tr>
                <td><span class="badge badge-info">Sedang Diproses</span></td>
                <td class="text-center"><?php echo e($statusData['Sedang Diproses']); ?></td>
                <td class="text-center"><?php echo e($totalPesanan > 0 ? round(($statusData['Sedang Diproses'] / $totalPesanan) * 100, 1) : 0); ?>%</td>
            </tr>
            <tr>
                <td><span class="badge badge-secondary">Menunggu Kurir</span></td>
                <td class="text-center"><?php echo e($statusData['Menunggu Kurir']); ?></td>
                <td class="text-center"><?php echo e($totalPesanan > 0 ? round(($statusData['Menunggu Kurir'] / $totalPesanan) * 100, 1) : 0); ?>%</td>
            </tr>
            <tr>
                <td><span class="badge badge-success">Selesai</span></td>
                <td class="text-center"><?php echo e($statusData['Selesai']); ?></td>
                <td class="text-center"><?php echo e($totalPesanan > 0 ? round(($statusData['Selesai'] / $totalPesanan) * 100, 1) : 0); ?>%</td>
            </tr>
            <tr>
                <td><span class="badge badge-danger">Dibatalkan</span></td>
                <td class="text-center"><?php echo e($statusData['Dibatalkan']); ?></td>
                <td class="text-center"><?php echo e($totalPesanan > 0 ? round(($statusData['Dibatalkan'] / $totalPesanan) * 100, 1) : 0); ?>%</td>
            </tr>
        </table>
    </div>
    
    
    <div class="section-title">Detail Pesanan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>No. Resi</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Telepon</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pemesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><?php echo e($order->no_resi); ?></td>
                <td><?php echo e($order->tgl_pesan->format('d/m/Y')); ?></td>
                <td><?php echo e($order->pelanggan->nama_pelanggan ?? '-'); ?></td>
                <td><?php echo e($order->pelanggan->telepon ?? '-'); ?></td>
                <td class="text-right"><strong>Rp <?php echo e(number_format($order->total_bayar, 0, ',', '.')); ?></strong></td>
                <td class="text-center">
                    <?php
                    $badgeClass = match($order->status_pesan) {
                        'Menunggu Konfirmasi' => 'warning',
                        'Sedang Diproses' => 'info',
                        'Menunggu Kurir' => 'secondary',
                        'Selesai' => 'success',
                        'Dibatalkan' => 'danger',
                        default => 'secondary'
                    };
                    ?>
                    <span class="badge badge-<?php echo e($badgeClass); ?>"><?php echo e($order->status_pesan); ?></span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="text-center">Tidak ada data pemesanan pada bulan ini.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    
    <div class="clearfix">
        <div class="footer">
            <p>Laporan ini dibuat secara otomatis oleh sistem.</p>
        </div>
        
        <div class="signature">
            <div class="signature-line">
                <strong>Admin Fakhri Kitchen</strong>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\SAAS-AKHIR\resources\views/reports/monthly-report.blade.php ENDPATH**/ ?>