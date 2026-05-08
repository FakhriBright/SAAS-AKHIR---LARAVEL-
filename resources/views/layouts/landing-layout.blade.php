<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fakhri Kitchen - Catering Premium')</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2d6a4f;
            --primary-light: #40916c;
            --primary-dark: #1b4332;
            --accent: #d4a373;
            --accent-light: #e9c46a;
            --cream: #fefae0;
            --dark: #1a1a2e;
            --text: #333;
            --text-light: #666;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }

        /* Navbar */
        .navbar-landing {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            transition: all 0.3s ease;
            box-shadow: none;
        }

        .navbar-landing.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .navbar-brand-custom {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark) !important;
        }

        .navbar-brand-custom i {
            color: var(--accent);
        }

        .nav-link-custom {
            color: var(--text) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: color 0.3s;
        }

        .nav-link-custom:hover {
            color: var(--primary) !important;
        }

        .btn-cta {
            background: var(--primary);
            color: white !important;
            border-radius: 50px;
            padding: 0.6rem 1.5rem !important;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-cta:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(45,106,79,0.3);
        }

        .btn-outline-cta {
            border: 2px solid var(--primary);
            color: var(--primary) !important;
            border-radius: 50px;
            padding: 0.5rem 1.3rem !important;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-cta:hover {
            background: var(--primary);
            color: white !important;
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(45,106,79,0.05) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-title span {
            color: var(--primary);
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-image-wrapper {
            position: relative;
        }

        .hero-image {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .hero-badge {
            position: absolute;
            bottom: -20px;
            left: -20px;
            background: var(--accent);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 15px;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(212,163,115,0.3);
        }

        /* Values Section */
        .values-section {
            background: var(--primary-dark);
            color: white;
            padding: 5rem 0;
        }

        .value-card {
            text-align: center;
            padding: 2rem;
        }

        .value-icon {
            font-size: 3rem;
            color: var(--accent-light);
            margin-bottom: 1rem;
        }

        .value-card h5 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .value-card p {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Offerings Section */
        .offerings-section {
            padding: 5rem 0;
            background: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            color: var(--text-light);
            margin-bottom: 3rem;
        }

        .offering-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .offering-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .offering-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .offering-card .card-body {
            padding: 1.5rem;
        }

        .offering-card h5 {
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        .offering-card p {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .btn-offering {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-offering:hover {
            background: var(--primary-dark);
            color: white;
        }

        /* Gallery Section */
        .gallery-section {
            padding: 5rem 0;
            background: var(--cream);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(2, 250px);
            gap: 1rem;
        }

        .gallery-item {
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-item:nth-child(1) {
            grid-column: span 2;
            grid-row: span 2;
        }

        /* Testimonials */
        .testimonials-section {
            padding: 5rem 0;
            background: white;
        }

        .testimonial-card {
            background: var(--cream);
            border-radius: 20px;
            padding: 2rem;
            height: 100%;
        }

        .testimonial-card p {
            font-style: italic;
            color: var(--text);
            margin-bottom: 1rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .testimonial-author h6 {
            margin: 0;
            color: var(--primary-dark);
        }

        .testimonial-author small {
            color: var(--text-light);
        }

        /* CTA Section */
        .cta-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .btn-cta-white {
            background: white;
            color: var(--primary-dark) !important;
            border-radius: 50px;
            padding: 0.8rem 2rem !important;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-cta-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* Footer */
        .footer-landing {
            background: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-brand i {
            color: var(--accent);
        }

        .footer-links h6 {
            color: var(--accent-light);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            margin-top: 2rem;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: auto;
            }

            .gallery-item:nth-child(1) {
                grid-column: span 2;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.8rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom" href="{{ url('/') }}">
                <i class="bi bi-cup-hot-fill"></i> Fakhri Kitchen
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#values">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#offerings">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#gallery">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#testimonials">Testimoni</a>
                    </li>
                    @auth('pelanggan')
                        <li class="nav-item ms-3">
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-cta">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a href="{{ route('login') }}" class="nav-link nav-link-custom">Login</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="{{ route('register') }}" class="btn btn-cta">Pesan Sekarang</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="footer-landing">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <i class="bi bi-cup-hot-fill"></i> Fakhri Kitchen
                    </div>
                    <p class="text-white-50">Catering premium untuk setiap momen spesial Anda. Dari prasmanan hingga meal box, kami siap melayani dengan cita rasa terbaik.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 footer-links">
                    <h6>Menu</h6>
                    <a href="#home">Beranda</a>
                    <a href="#offerings">Paket Catering</a>
                    <a href="#gallery">Galeri</a>
                    <a href="#testimonials">Testimoni</a>
                </div>
                <div class="col-lg-2 col-md-4 footer-links">
                    <h6>Layanan</h6>
                    <a href="#">Prasmanan</a>
                    <a href="#">Meal Box</a>
                    <a href="#">Snack Box</a>
                    <a href="#">Tumpeng</a>
                </div>
                <div class="col-lg-4 col-md-4 footer-links">
                    <h6>Kontak</h6>
                    <p class="text-white-50 mb-2"><i class="bi bi-geo-alt me-2"></i> Bogor, Jawa Barat, Indonesia</p>
                    <p class="text-white-50 mb-2"><i class="bi bi-telephone me-2"></i> +62 812-3456-7890</p>
                    <p class="text-white-50 mb-2"><i class="bi bi-envelope me-2"></i> info@fakhrikitchen.id</p>
                </div>
            </div>
            <div class="footer-bottom">
                <small class="text-white-50">&copy; {{ date('Y') }} Fakhri Kitchen. All rights reserved.</small>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    // Close mobile menu
                    const navCollapse = document.getElementById('navbarNav');
                    if (navCollapse.classList.contains('show')) {
                        new bootstrap.Collapse(navCollapse).hide();
                    }
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
