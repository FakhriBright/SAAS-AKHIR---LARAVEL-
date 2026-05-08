<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Fakhri Kitchen - Admin Panel'); ?></title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --sidebar-width: 260px;
            --sidebar-collapsed: 70px;
            --topbar-height: 70px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; overflow-x: hidden; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: var(--sidebar-width);
            background: linear-gradient(180deg, #0d6efd 0%, #0a58ca 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); z-index: 1050;
            overflow-y: auto; overflow-x: hidden; box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar.collapsed { width: var(--sidebar-collapsed); }
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 10px; }

        .sidebar-brand {
            padding: 1.5rem; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .sidebar-brand i { font-size: 1.8rem; color: #fff; }
        .sidebar-brand h4 { color: #fff; font-weight: 700; margin: 0; font-size: 1.25rem; white-space: nowrap; }
        .sidebar.collapsed .sidebar-brand h4 { display: none; }

        .sidebar-menu { padding: 1rem 0; list-style: none; }
        .sidebar-menu li { margin: 0.25rem 0; }
        .sidebar-menu a {
            display: flex; align-items: center; padding: 0.8rem 1.5rem; color: rgba(255,255,255,0.85);
            text-decoration: none; transition: all 0.2s; border-left: 3px solid transparent;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255,255,255,0.12); color: #fff; border-left-color: #fff;
        }
        .sidebar-menu a i { font-size: 1.25rem; margin-right: 1rem; width: 24px; text-align: center; flex-shrink: 0; }
        .sidebar.collapsed .sidebar-menu a span { display: none; }
        .sidebar.collapsed .sidebar-menu a { justify-content: center; padding: 0.9rem; }
        .sidebar.collapsed .sidebar-menu a i { margin-right: 0; }

        /* Main Content */
        .main-content { margin-left: var(--sidebar-width); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); min-height: 100vh; display: flex; flex-direction: column; }
        .sidebar.collapsed ~ .main-content { margin-left: var(--sidebar-collapsed); }

        /* Top Navbar */
        .top-navbar {
            height: var(--topbar-height); background: #fff; padding: 0 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 1040;
        }
        .sidebar-toggle {
            background: none; border: none; font-size: 1.5rem; color: #495057; cursor: pointer; padding: 0.5rem;
            border-radius: 8px; transition: all 0.2s;
        }
        .sidebar-toggle:hover { background: #f8f9fa; color: var(--primary-color); }

        .user-menu { display: flex; align-items: center; gap: 1rem; }
        .user-avatar {
            width: 42px; height: 42px; border-radius: 50%; background: var(--primary-color);
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 1.1rem; flex-shrink: 0;
        }
        .dropdown-menu { border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 12px; padding: 0.5rem; }
        .dropdown-item { padding: 0.6rem 1rem; border-radius: 8px; font-size: 0.95rem; }
        .dropdown-item:hover { background: #f8f9fa; }

        /* Content Wrapper */
        .content-wrapper { flex: 1; padding: 2rem; }

        /* Footer */
        .footer {
            background: #fff; padding: 1.25rem; text-align: center; border-top: 1px solid #e9ecef;
            font-size: 0.85rem; color: #6c757d;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
            .top-navbar { padding: 0 1rem; }
            .content-wrapper { padding: 1.5rem; }
            .overlay {
                position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.4); z-index: 1045; display: none;
            }
            .overlay.active { display: block; }
        }

        /* Utility */
        .text-small { font-size: 0.8rem; }
        .fw-medium { font-weight: 500; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    
    <div class="overlay" id="sidebarOverlay"></div>

    
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-cup-hot-fill"></i>
            <h4>Fakhri Kitchen</h4>
        </div>

        <ul class="sidebar-menu">
            <?php if(Auth::guard('web')->check()): ?>
                
                <li>
                    <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>

                <?php if(Auth::guard('web')->user()->level === 'admin'): ?>
                <li>
                    <a href="<?php echo e(route('pakets.index')); ?>" class="<?php echo e(request()->routeIs('pakets.*') ? 'active' : ''); ?>">
                        <i class="bi bi-box-seam"></i> <span>Kelola Paket</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('pelanggans.index')); ?>" class="<?php echo e(request()->routeIs('pelanggans.*') ? 'active' : ''); ?>">
                        <i class="bi bi-people"></i> <span>Data Pelanggan</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('pemesanans.index')); ?>" class="<?php echo e(request()->routeIs('pemesanans.*') ? 'active' : ''); ?>">
                        <i class="bi bi-cart-check"></i> <span>Pemesanan</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="<?php echo e(request()->routeIs('jenis-pembayaran.*', 'detail-jenis-pembayaran.*') ? 'active' : ''); ?>" data-bs-toggle="collapse" data-bs-target="#paymentMenu" aria-expanded="false">
                        <i class="bi bi-credit-card"></i> <span>Pembayaran</span> <i class="bi bi-chevron-down ms-auto small"></i>
                    </a>
                    <ul class="collapse <?php echo e(request()->routeIs('jenis-pembayaran.*', 'detail-jenis-pembayaran.*') ? 'show' : ''); ?> list-unstyled" id="paymentMenu">
                        <li><a href="<?php echo e(route('jenis-pembayaran.index')); ?>" style="padding-left: 3.5rem;"><span>Jenis Pembayaran</span></a></li>
                        <li><a href="<?php echo e(route('detail-jenis-pembayaran.index')); ?>" style="padding-left: 3.5rem;"><span>Detail Pembayaran</span></a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if(in_array(Auth::guard('web')->user()->level, ['admin', 'kurir'])): ?>
                <li>
                    <a href="<?php echo e(route('pengirimans.index')); ?>" class="<?php echo e(request()->routeIs('pengirimans.*') ? 'active' : ''); ?>">
                        <i class="bi bi-truck"></i> <span>Pengiriman</span>
                    </a>
                </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(Auth::guard('pelanggan')->check()): ?>
                
                <li>
                    <a href="<?php echo e(route('customer.dashboard')); ?>" class="<?php echo e(request()->routeIs('customer.dashboard') ? 'active' : ''); ?>">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('customer.catalog')); ?>" class="<?php echo e(request()->routeIs('customer.catalog') ? 'active' : ''); ?>">
                        <i class="bi bi-grid-3x3"></i> <span>Katalog Paket</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('customer.orders')); ?>" class="<?php echo e(request()->routeIs('customer.orders', 'customer.order.*') ? 'active' : ''); ?>">
                        <i class="bi bi-clock-history"></i> <span>Riwayat Pesanan</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('customer.profile')); ?>" class="<?php echo e(request()->routeIs('customer.profile') ? 'active' : ''); ?>">
                        <i class="bi bi-person-circle"></i> <span>Profil Saya</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(auth()->guard('web')->guest()): ?>
            <?php if(auth()->guard('pelanggan')->guest()): ?>
                
                <li>
                    <a href="<?php echo e(route('home')); ?>">
                        <i class="bi bi-house"></i> <span>Beranda</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('login')); ?>">
                        <i class="bi bi-box-arrow-in-right"></i> <span>Login</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('register')); ?>">
                        <i class="bi bi-person-plus"></i> <span>Register</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php endif; ?>
        </ul>
    </nav>

    
    <div class="main-content">
        
        <nav class="top-navbar">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                <i class="bi bi-list"></i>
            </button>

            <div class="user-menu">
                <?php if(Auth::guard('web')->check()): ?>
                    <div class="dropdown">
                        <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center gap-2 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar"><?php echo e(strtoupper(substr(Auth::guard('web')->user()->name, 0, 1))); ?></div>
                            <div class="d-none d-md-flex flex-column align-items-start">
                                <span class="fw-semibold text-dark text-small"><?php echo e(Auth::guard('web')->user()->name); ?></span>
                                <span class="text-muted text-small" style="font-size: 0.75rem;"><?php echo e(ucfirst(Auth::guard('web')->user()->level)); ?></span>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout
                            </a></li>
                        </ul>
                    </div>
                <?php elseif(Auth::guard('pelanggan')->check()): ?>
                    <div class="dropdown">
                        <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center gap-2 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar"><?php echo e(strtoupper(substr(Auth::guard('pelanggan')->user()->nama_pelanggan, 0, 1))); ?></div>
                            <div class="d-none d-md-flex flex-column align-items-start">
                                <span class="fw-semibold text-dark text-small"><?php echo e(Auth::guard('pelanggan')->user()->nama_pelanggan); ?></span>
                                <span class="text-muted text-small" style="font-size: 0.75rem;">Pelanggan</span>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="<?php echo e(route('customer.profile')); ?>">
                                <i class="bi bi-person me-2"></i> Profil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout
                            </a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">Login</a>
                <?php endif; ?>
            </div>
        </nav>

        
        <div class="content-wrapper">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        
        <footer class="footer">
            &copy; <?php echo e(date('Y')); ?> <strong>Fakhri Kitchen</strong>. All rights reserved. Built with <i class="bi bi-heart-fill text-danger"></i> & Laravel.
        </footer>
    </div>

    
    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Toggle Logic
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('active');
            } else {
                sidebar.classList.toggle('collapsed');
            }
        }

        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('active');
        });

        // Active Link Highlighting
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
                // Auto expand parent collapse if needed
                const parentCollapse = link.closest('.collapse');
                if (parentCollapse) {
                    new bootstrap.Collapse(parentCollapse, { toggle: true });
                }
            }
        });

        // Close sidebar on resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                overlay.classList.remove('active');
            }
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/layouts/app.blade.php ENDPATH**/ ?>