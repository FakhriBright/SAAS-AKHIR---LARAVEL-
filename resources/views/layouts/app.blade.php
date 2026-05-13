<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fakhri Kitchen - Catering Premium')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2d6a4f; --primary-dark: #1b4332; --light: #fff9f0; }
        body { font-family: 'Poppins', sans-serif; background: var(--light); color: #333; }
        
        .navbar { background: white; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 0.8rem 0; }
        .navbar-brand { font-weight: 700; color: var(--primary-dark); font-size: 1.4rem; }
        .nav-link { color: #555; font-weight: 500; transition: 0.2s; padding: 0.5rem 1rem; }
        .nav-link:hover, .nav-link.active { color: var(--primary); }
        
        .cart-icon { position: relative; color: #333; font-size: 1.2rem; padding: 0.5rem; }
        .cart-badge { position: absolute; top: 2px; right: 0; background: #dc3545; color: white; font-size: 0.6rem; padding: 2px 5px; border-radius: 50%; font-weight: 600; min-width: 16px; text-align: center; }
        
        .profile-trigger { cursor: pointer; display: flex; align-items: center; gap: 6px; padding: 0.3rem 0.5rem; border-radius: 20px; transition: 0.2s; }
        .profile-trigger:hover { background: var(--light); }
        .avatar { width: 32px; height: 32px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.8rem; }
        
        .main-content { min-height: calc(100vh - 200px); padding-top: 2rem; padding-bottom: 4rem; }
        .app-footer { background: white; border-top: 1px solid #eee; padding: 1.5rem 0; text-align: center; color: #666; font-size: 0.85rem; }
        
        .fk-card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.04); }
        .btn-fk-primary { background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 500; }
        .btn-fk-primary:hover { background: var(--primary-dark); color: white; }
        .btn-fk-outline { border: 1px solid var(--primary); color: var(--primary); background: transparent; border-radius: 8px; font-weight: 500; }
        .btn-fk-outline:hover { background: var(--primary); color: white; }
    </style>
    @stack('styles')
</head>
<body>

    {{-- NAVBAR (Clean: No customer links in main nav) --}}
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
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('testimoni') ? 'active' : '' }}" href="{{ route('testimoni') }}">Testimoni</a></li>
                    {{-- ❌ HAPUS: Katalog & Pesanan Saya dari navbar utama --}}
                </ul>
                <div class="d-flex align-items-center gap-3">
                    @auth('pelanggan')
                        {{-- Cart Icon --}}
                        <a href="{{ route('customer.cart.index') }}" class="cart-icon text-decoration-none">
                            <i class="bi bi-cart3"></i>
                            @php $count = \App\Models\Cart::where('id_pelanggan', auth()->guard('pelanggan')->id())->sum('jumlah'); @endphp
                            @if($count > 0) <span class="cart-badge">{{ $count > 99 ? '99+' : $count }}</span> @endif
                        </a>
                        
                        {{-- Profile Dropdown (Katalog & Pesanan Saya ada DI SINI) --}}
                        <div class="dropdown">
                            <div class="profile-trigger" data-bs-toggle="dropdown">
                                <div class="avatar">{{ strtoupper(substr(auth()->guard('pelanggan')->user()->nama_pelanggan, 0, 1)) }}</div>
                                <span class="d-none d-md-inline small fw-medium">{{ auth()->guard('pelanggan')->user()->nama_pelanggan }}</span>
                                <i class="bi bi-chevron-down small"></i>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item" href="{{ route('customer.profile') }}"><i class="bi bi-person me-2"></i>Akun Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.orders') }}"><i class="bi bi-receipt me-2"></i>Pesanan Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.catalog') }}"><i class="bi bi-grid me-2"></i>Katalog Paket</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-success btn-sm">Daftar</a>
                    @endauth
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
            <p class="mb-1">&copy; {{ date('Y') }} Fakhri Kitchen. Premium Catering Service.</p>
            <small>Melayani dengan cinta dan kualitas terbaik sejak 2024</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>