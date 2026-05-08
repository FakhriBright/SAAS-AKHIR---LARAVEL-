<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Fakhri Kitchen Customer'); ?></title>
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --fk-primary: #2d6a4f;      /* Hijau Fakhri Kitchen */
            --fk-primary-dark: #1b4332; /* Hijau Gelap */
            --fk-light: #d8f3dc;        /* Hijau Muda */
            --fk-bg: #f8f9fa;           /* Background Abu-abu sangat muda */
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;
            --topbar-height: 70px;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: var(--fk-bg); color: #333; overflow-x: hidden; }
        
        /* --- SIDEBAR --- */
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: var(--sidebar-width);
            background: white; box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            z-index: 1050; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column;
        }
        
        .sidebar-brand {
            height: var(--topbar-height); display: flex; align-items: center; padding: 0 1.5rem;
            border-bottom: 1px solid #eee;
        }
        
        .sidebar-brand h4 {
            font-family: 'Playfair Display', serif; color: var(--fk-primary-dark);
            margin: 0; font-weight: 700; font-size: 1.2rem; white-space: nowrap;
        }
        .sidebar-brand i { font-size: 1.5rem; color: var(--fk-primary); margin-right: 10px; }
        
        .sidebar-menu { list-style: none; padding: 1.5rem 1rem; flex: 1; }
        .sidebar-menu li { margin-bottom: 0.5rem; }
        
        .sidebar-menu a {
            display: flex; align-items: center; padding: 0.9rem 1rem;
            color: #666; text-decoration: none; border-radius: 10px;
            transition: all 0.2s; font-weight: 500; font-size: 0.95rem;
        }
        
        .sidebar-menu a i { margin-right: 12px; font-size: 1.2rem; transition: margin 0.2s; }
        .sidebar-menu a:hover { background: var(--fk-light); color: var(--fk-primary); }
        .sidebar-menu a.active { background: var(--fk-primary); color: white; box-shadow: 0 4px 12px rgba(45,106,79,0.3); }
        .sidebar-menu a.active i { color: white; }
        
        /* --- MAIN CONTENT AREA --- */
        .main-content {
            margin-left: var(--sidebar-width); transition: all 0.3s;
            min-height: 100vh; display: flex; flex-direction: column;
        }
        
        /* --- TOP BAR --- */
        .topbar {
            height: var(--topbar-height); background: white; padding: 0 2rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 1040; box-shadow: 0 2px 5px rgba(0,0,0,0.03);
        }
        
        .toggle-sidebar {
            background: none; border: none; font-size: 1.5rem; color: #666; cursor: pointer;
        }
        
        .user-profile { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .user-avatar {
            width: 40px; height: 40px; border-radius: 50%; background: var(--fk-light);
            color: var(--fk-primary); display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 1rem;
        }
        .user-info { display: flex; flex-direction: column; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 0.9rem; color: #333; }
        .user-role { font-size: 0.75rem; color: #888; }
        
        /* --- CONTENT WRAPPER --- */
        .page-content { padding: 2rem; flex: 1; }
        
        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 240px; }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
            .overlay {
                position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1045; display: none;
            }
            .overlay.active { display: block; }
            .page-content { padding: 1.5rem; }
            .user-info { display: none; } /* Hide name on mobile */
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    
    <nav class="sidebar" id="sidebar">
        <a href="<?php echo e(route('home')); ?>" class="sidebar-brand text-decoration-none">
    <i class="bi bi-cup-hot-fill"></i>
    <h4>Fakhri Kitchen</h4>
</a>

        
        <ul class="sidebar-menu">
            <li>
        <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
            <i class="bi bi-house-door"></i> <span>Beranda</span>
        </a>
    </li>
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
            <li style="margin-top: auto;">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                    <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    
    <div class="main-content">
        
        <header class="topbar">
            <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            
            <div class="user-profile">
                <div class="text-end d-none d-md-block user-info">
                    <span class="user-name"><?php echo e(Auth::guard('pelanggan')->user()->nama_pelanggan); ?></span>
                    <span class="user-role">Pelanggan</span>
                </div>
                <div class="user-avatar">
                    <?php echo e(strtoupper(substr(Auth::guard('pelanggan')->user()->nama_pelanggan, 0, 1))); ?>

                </div>
            </div>
        </header>

        
        <div class="page-content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    
    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;"><?php echo csrf_field(); ?></form>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            } else {
                // Logic for desktop collapse if needed, but fixed is better for dashboards
            }
        }
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\SAAS-AKHIR---LARAVEL-\resources\views/layouts/customer.blade.php ENDPATH**/ ?>