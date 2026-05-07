<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title><?php echo $__env->yieldContent('title', 'Catering Admin'); ?></title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .card:hover { transform: translateY(-3px); box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .btn { border-radius: 8px; font-weight: 500; }
        .table th { font-weight: 600; color: #666; font-size: 0.85rem; text-transform: uppercase; background-color: #f8f9fa !important; }
        .avatar { width: 32px; height: 32px; border-radius: 50%; background: #0d6efd; color: white; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo e(auth()->check() ? route('dashboard') : route('login')); ?>">
                <i class="bi bi-box-seam"></i> Catering<span class="text-light opacity-75">Admin</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if(auth()->guard()->check()): ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>

                    
                    <?php if(Auth::user()->level === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('pakets.*') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('pakets.index')); ?>">
                            <i class="bi bi-box-seam"></i> Paket
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('pelanggans.*') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('pelanggans.index')); ?>">
                            <i class="bi bi-people"></i> Pelanggan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('pemesanans.*') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('pemesanans.index')); ?>">
                            <i class="bi bi-cart"></i> Pemesanan
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo e(request()->routeIs('jenis-pembayaran.*', 'detail-jenis-pembayaran.*') ? 'active fw-bold' : ''); ?>" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-credit-card"></i> Pembayaran
                        </a>
                        <ul class="dropdown-menu shadow border-0">
                            <li><a class="dropdown-item" href="<?php echo e(route('jenis-pembayaran.index')); ?>">Jenis Pembayaran</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('detail-jenis-pembayaran.index')); ?>">Detail Pembayaran</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>

                    
                    <?php if(in_array(Auth::user()->level, ['admin', 'kurir'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('pengirimans.*') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('pengirimans.index')); ?>">
                            <i class="bi bi-truck"></i> Pengiriman
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>

                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="avatar"><?php echo e(substr(Auth::user()->name, 0, 1)); ?></div>
                            <span class="d-none d-lg-inline">
                                <?php echo e(Auth::user()->name); ?>

                                <small class="text-white-50">(<?php echo e(ucfirst(Auth::user()->level)); ?>)</small>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><h6 class="dropdown-header">Signed in as</h6></li>
                            <li><span class="dropdown-item-text small text-muted"><?php echo e(Auth::user()->email); ?></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                <?php else: ?>
                
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('login')); ?>"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('register')); ?>"><i class="bi bi-person-plus"></i> Register</a>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    
    <main class="py-4">
        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    
    <footer class="bg-white text-center py-4 mt-5 border-top">
        <div class="container">
            <small class="text-muted">&copy; <?php echo e(date('Y')); ?> Catering App. Built with <i class="bi bi-heart-fill text-danger"></i> & Laravel.</small>
        </div>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ✨ DISABLED - DataTables auto-init untuk menghindari error
        // Jika ingin pakai DataTables, uncomment kode di bawah
        /*
        $(document).ready(function() {
            $('.datatable').DataTable({
                order: [[0, 'desc']],
                language: { search: "", searchPlaceholder: "Cari data..." }
            });
        });
        */

        // Toast Notification System
        <?php if(session('success')): ?>
            Swal.fire({
                icon: 'success', title: 'Berhasil!', text: '<?php echo e(session('success')); ?>',
                timer: 3000, timerProgressBar: true, showConfirmButton: false,
                position: 'top-end', toast: true
            });
        <?php endif; ?>
// ✅ BENAR - Hanya tampilkan jika ada session
<?php if(session('error')): ?>
    Swal.fire({
        icon: 'error', title: 'Gagal!', text: '<?php echo e(session('error')); ?>',
        timer: 4000, timerProgressBar: true, showConfirmButton: false,
        position: 'top-end', toast: true
    });
<?php endif; ?>

        // Confirm Delete SweetAlert
        document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin hapus?', text: "Data tidak bisa dikembalikan!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) { this.submit(); }
                });
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\SAAS-AKHIR-LARAVEL\resources\views/layouts/app.blade.php ENDPATH**/ ?>