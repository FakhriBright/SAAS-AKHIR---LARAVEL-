<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Customer - Fakhri Kitchen'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2d6a4f;
            --primary-light: #40916c;
            --accent: #d4a373;
            --cream: #fefae0;
            --dark: #1a1a2e;
            --text: #333;
        }
        body { font-family: 'Poppins', sans-serif; background-color: #f9f9f9; color: var(--text); }
        h1, h2, h3, h4, h5 { font-family: 'Playfair Display', serif; }

        /* Navbar */
        .navbar-customer {
            background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);
            padding: 0.8rem 0; box-shadow: 0 2px 15px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000;
        }
        .navbar-brand { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary-dark) !important; font-size: 1.4rem; }
        .navbar-brand i { color: var(--accent); }
        .nav-link { color: var(--text) !important; font-weight: 500; margin: 0 0.5rem; }
        .nav-link:hover, .nav-link.active { color: var(--primary) !important; }
        .btn-nav-cta { background: var(--primary); color: white !important; border-radius: 50px; padding: 0.4rem 1.2rem !important; font-weight: 500; }
        .btn-nav-cta:hover { background: var(--primary-light); }

        /* Main Content */
        .customer-wrapper { min-height: calc(100vh - 150px); padding: 2rem 0; }

        /* Cards & Components */
        .fk-card { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); transition: all 0.3s; }
        .fk-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .fk-badge { background: var(--accent); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }

        /* Buttons */
        .btn-fk-primary { background: var(--primary); color: white; border: none; border-radius: 50px; padding: 0.6rem 1.5rem; font-weight: 500; }
        .btn-fk-primary:hover { background: var(--primary-light); color: white; }
        .btn-fk-outline { border: 2px solid var(--primary); color: var(--primary); background: transparent; border-radius: 50px; padding: 0.5rem 1.3rem; font-weight: 500; }
        .btn-fk-outline:hover { background: var(--primary); color: white; }

        /* Footer */
        .footer-customer { background: var(--dark); color: white; padding: 2rem 0; text-align: center; margin-top: auto; }
        .footer-customer a { color: rgba(255,255,255,0.7); text-decoration: none; }
        .footer-customer a:hover { color: white; }

        /* Responsive */
        @media (max-width: 768px) {
            .customer-wrapper { padding: 1rem 0; }
            .navbar-collapse { background: white; padding: 1rem; border-radius: 12px; margin-top: 0.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-customer">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>"><i class="bi bi-cup-hot-fill"></i> Fakhri Kitchen</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('customer.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('customer.dashboard')); ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('customer.catalog') ? 'active' : ''); ?>" href="<?php echo e(route('customer.catalog')); ?>">Katalog</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('customer.orders') ? 'active' : ''); ?>" href="<?php echo e(route('customer.orders')); ?>">Riwayat</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('customer.profile') ? 'active' : ''); ?>" href="<?php echo e(route('customer.profile')); ?>">Profil</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <?php if(Auth::guard('pelanggan')->check()): ?>
                        <div class="dropdown">
                            <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:0.8rem;">
                                    <?php echo e(strtoupper(substr(Auth::guard('pelanggan')->user()->nama_pelanggan, 0, 1))); ?>

                                </div>
                                <span class="d-none d-md-inline fw-medium text-dark"><?php echo e(Auth::guard('pelanggan')->user()->nama_pelanggan); ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item" href="<?php echo e(route('customer.profile')); ?>"><i class="bi bi-person me-2"></i>Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-fk-outline btn-sm">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-fk-primary btn-sm">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="customer-wrapper">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="footer-customer">
        <div class="container">
            <small>&copy; <?php echo e(date('Y')); ?> <strong>Fakhri Kitchen</strong>. All rights reserved.</small>
        </div>
    </footer>

    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display:none;"><?php echo csrf_field(); ?></form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\SAAS-AKHIR-LARAVEL\resources\views/layouts/customer.blade.php ENDPATH**/ ?>