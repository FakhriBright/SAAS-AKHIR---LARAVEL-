<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fakhri Kitchen')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2d6a4f; --primary-dark: #1b4332; --light: #f8f9fa; }
        body { font-family: 'Poppins', sans-serif; background: var(--light); color: #333; }
        
        /* Navbar */
        .navbar { background: white; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 1rem 0; }
        .navbar-brand { font-weight: 700; color: var(--primary-dark); font-size: 1.4rem; }
        .nav-link { color: #555; font-weight: 500; transition: 0.2s; }
        .nav-link:hover, .nav-link.active { color: var(--primary); }
        
        .cart-icon { position: relative; color: #333; font-size: 1.3rem; }
        .cart-badge { position: absolute; top: -6px; right: -8px; background: #dc3545; color: white; font-size: 0.65rem; padding: 2px 5px; border-radius: 50%; font-weight: 600; }
        
        .profile-trigger { cursor: pointer; display: flex; align-items: center; gap: 8px; }
        .avatar { width: 36px; height: 36px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.9rem; }
        
        /* Main Content */
        .main-content { min-height: calc(100vh - 180px); padding-top: 2.5rem; padding-bottom: 4rem; }
        .section-title { font-weight: 700; color: #222; margin-bottom: 1.5rem; }
        
        /* Footer */
        .app-footer { background: white; border-top: 1px solid #eee; padding: 1.5rem 0; text-align: center; color: #666; font-size: 0.9rem; }
    </style>
    @stack('styles')
</head>
<body>

    {{-- NAVBAR (Sama dengan Landing Page) --}}
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-cup-hot-fill me-2"></i>Fakhri Kitchen
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('customer.catalog') ? 'active' : '' }}" href="{{ route('customer.catalog') }}">Katalog</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('customer.orders') ? 'active' : '' }}" href="{{ route('customer.orders') }}">Pesanan Saya</a></li>
                </ul>
                <div class="d-flex align-items-center gap-4">
                    {{-- Cart --}}
                    <a href="{{ route('customer.cart.index') }}" class="cart-icon">
                        <i class="bi bi-cart3"></i>
                        @php $count = \App\Models\Cart::where('id_pelanggan', auth()->guard('pelanggan')->id())->sum('jumlah'); @endphp
                        @if($count > 0) <span class="cart-badge">{{ $count }}</span> @endif
                    </a>
                    
                    {{-- Profile Dropdown --}}
                    <div class="dropdown">
                        <div class="profile-trigger" data-bs-toggle="dropdown">
                            <div class="avatar">{{ strtoupper(substr(auth()->guard('pelanggan')->user()->nama_pelanggan, 0, 1)) }}</div>
                            <span class="d-none d-md-inline fw-medium">{{ auth()->guard('pelanggan')->user()->nama_pelanggan }}</span>
                            <i class="bi bi-chevron-down small"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><h6 class="dropdown-header">Akun Saya</h6></li>
                            <li><a class="dropdown-item" href="{{ route('customer.profile') }}"><i class="bi bi-person me-2"></i>Profil & Alamat</a></li>
                            <li><a class="dropdown-item" href="{{ route('customer.orders') }}"><i class="bi bi-receipt me-2"></i>Riwayat Pesanan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="app-footer">
        <div class="container">
            &copy; {{ date('Y') }} Fakhri Kitchen. Premium Catering Service.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>