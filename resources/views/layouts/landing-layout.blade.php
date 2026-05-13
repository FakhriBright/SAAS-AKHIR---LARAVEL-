<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fakhri Kitchen')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2d6a4f;
            --secondary: #1b4332;
            --bg-light: #fffcf2;
            --text-dark: #1a1a1a;
            --text-muted: #666;
        }
        
        body { font-family: 'Poppins', sans-serif; background: var(--bg-light); color: var(--text-dark); overflow-x: hidden; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', serif; font-weight: 700; }
        
        /* Navbar */
        .navbar { background: white; box-shadow: 0 2px 20px rgba(0,0,0,0.04); padding: 1rem 0; }
        .navbar-brand { font-weight: 700; color: var(--primary); font-size: 1.5rem; }
        .nav-link { color: #555; font-weight: 500; font-size: 0.95rem; margin: 0 0.5rem; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: var(--primary); }
        
        /* Cart & Profile */
        .cart-icon { position: relative; color: #333; font-size: 1.2rem; margin-right: 12px; }
        .cart-badge { position: absolute; top: -5px; right: -8px; background: #dc3545; color: white; font-size: 0.65rem; padding: 2px 5px; border-radius: 50%; }
        .profile-trigger { cursor: pointer; display: flex; align-items: center; gap: 8px; padding: 4px 10px 4px 4px; border-radius: 30px; border: 1px solid #eee; background: white; }
        .profile-trigger:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .avatar { width: 32px; height: 32px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.8rem; }
        
        /* Hero */
        .hero-section { padding: 4rem 0 6rem; background: var(--bg-light); }
        .hero-title { font-size: 3.5rem; line-height: 1.2; margin-bottom: 1.5rem; }
        .hero-title span { color: var(--primary); font-style: italic; }
        .hero-subtitle { font-size: 1.05rem; color: var(--text-muted); line-height: 1.8; margin-bottom: 2rem; }
        
        .hero-image-wrapper { position: relative; display: inline-block; }
        .hero-image { border-radius: 24px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); width: 100%; max-width: 500px; }
        .hero-badge { position: absolute; bottom: -20px; left: 30px; background: #0d6efd; color: white; padding: 10px 20px; border-radius: 50px; font-weight: 600; font-size: 0.9rem; box-shadow: 0 10px 20px rgba(13,110,253,0.3); white-space: nowrap; }
        
        /* Values Section */
        .values-section { background: var(--primary); padding: 5rem 0; }
        .value-card { background: rgba(255,255,255,0.1); padding: 2.5rem 1.5rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); text-align: center; height: 100%; transition: 0.3s; }
        .value-card:hover { background: rgba(255,255,255,0.2); transform: translateY(-5px); }
        .value-icon-wrapper { width: 60px; height: 60px; margin: 0 auto 1.5rem; background: rgba(255,255,255,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .value-icon-wrapper i { font-size: 1.8rem; color: #ffc107; }
        
        /* Offerings */
        #offerings { padding: 5rem 0; }
        .offering-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eee; height: 100%; display: flex; flex-direction: column; transition: 0.3s; }
        .offering-card:hover { transform: translateY(-8px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .offering-card img { width: 100%; height: 220px; object-fit: cover; }
        .offering-card .card-body { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; }
        .offering-card h5 { font-size: 1.25rem; margin-bottom: 0.5rem; }
        .offering-card p { color: var(--text-muted); font-size: 0.9rem; flex-grow: 1; }
        .btn-offering { align-self: flex-start; background: var(--primary); color: white; border-radius: 50px; padding: 0.5rem 1.5rem; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: 0.3s; border: none; }
        .btn-offering:hover { background: var(--secondary); color: white; }
        
        /* Gallery */
        .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); grid-template-rows: repeat(2, 200px); gap: 1rem; }
        .gallery-item { border-radius: 16px; overflow: hidden; }
        .gallery-item:first-child { grid-column: 1; grid-row: 1 / 3; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .gallery-item:hover img { transform: scale(1.05); }
        
        /* Testimonials */
        #testimonials { padding: 5rem 0; background: white; }
        .testimonial-card { background: var(--bg-light); padding: 2rem; border-radius: 20px; border: 1px solid #eee; height: 100%; text-align: center; }
        .testimonial-card p { font-style: italic; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.7; }
        .testimonial-avatar { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; margin: 0 auto 1rem; border: 3px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .testimonial-author h6 { margin-bottom: 0.2rem; font-weight: 700; font-family: 'Poppins', sans-serif; }
        .testimonial-author small { color: var(--primary); font-weight: 500; }
        
        /* CTA */
        .cta-section { background: linear-gradient(rgba(27,67,50,0.9), rgba(27,67,50,0.9)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1200') center/cover; padding: 6rem 0; color: white; text-align: center; }
        .btn-cta { background: var(--primary); color: white; border-radius: 50px; padding: 0.9rem 2rem; font-weight: 600; border: none; transition: 0.3s; }
        .btn-cta:hover { background: var(--secondary); color: white; transform: translateY(-2px); }
        .btn-outline-cta { border: 2px solid #ccc; color: #333; border-radius: 50px; padding: 0.9rem 2rem; font-weight: 600; transition: 0.3s; }
        .btn-outline-cta:hover { border-color: var(--primary); color: var(--primary); }
        
        /* Footer */
        footer { background: #111; color: #aaa; padding: 4rem 0 2rem; font-size: 0.9rem; }
        footer h5, footer h6 { color: white; margin-bottom: 1.5rem; }
        footer a { color: #aaa; text-decoration: none; }
        footer a:hover { color: white; }
        
        @media (max-width: 768px) {
            .hero-title { font-size: 2.2rem; }
            .gallery-grid { grid-template-columns: 1fr; grid-template-rows: auto; }
            .gallery-item:first-child { grid-column: span 1; grid-row: span 1; height: 200px; }
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-cup-hot-fill me-2"></i>Fakhri Kitchen
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#values">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="#offerings">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Testimoni</a></li>
                </ul>
                
                <div class="d-flex align-items-center gap-2">
                    @auth('pelanggan')
                        {{-- Cart Icon --}}
                        <a href="{{ route('customer.cart.index') }}" class="cart-icon">
                            <i class="bi bi-cart3"></i>
                            @php $count = \App\Models\Cart::where('id_pelanggan', auth()->guard('pelanggan')->id())->sum('jumlah'); @endphp
                            @if($count > 0)<span class="cart-badge">{{ $count }}</span>@endif
                        </a>
                        
                        {{-- Profile Dropdown --}}
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
                        <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm px-3 me-2" style="border-radius: 50px;">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-success btn-sm px-3" style="border-radius: 50px;">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-cup-hot-fill me-2"></i>Fakhri Kitchen</h5>
                    <p>Premium catering service untuk acara spesial Anda. Menghadirkan cita rasa terbaik dengan pelayanan kelas satu sejak 2024.</p>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Kontak Kami</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2 text-success"></i>Jl. Cikampak Cicadas, Bogor</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2 text-success"></i>0858-4251-7974</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2 text-success"></i>info@fakhrikitchen.com</li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Jam Operasional</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">Senin - Jumat: 08.00 - 17.00</li>
                        <li class="mb-2">Sabtu: 08.00 - 15.00</li>
                        <li class="mb-2">Minggu: Libur</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: #333;">
            <div class="text-center">
                <small>&copy; {{ date('Y') }} Fakhri Kitchen. All rights reserved.</small>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Smooth Scroll Script --}}
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>