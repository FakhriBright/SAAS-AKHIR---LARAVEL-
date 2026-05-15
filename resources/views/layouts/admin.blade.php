<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Fakhri Kitchen</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2d6a4f;
            --bg-body: #f4f7fe;
            --text-dark: #2b3674;
            --card-shadow: 0 5px 20px rgba(112, 144, 176, 0.08);
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-body); color: var(--text-dark); overflow-x: hidden; }
        
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 260px; background: white; box-shadow: 2px 0 30px rgba(0,0,0,0.03); z-index: 1000; padding: 1.5rem; }
        .sidebar .nav-link { color: #707eae; padding: 0.9rem 1rem; border-radius: 12px; margin-bottom: 0.5rem; font-weight: 500; transition: 0.3s; display: flex; align-items: center; gap: 1rem; }
        .sidebar .nav-link:hover { color: var(--primary); background: #f4f7fe; }
        .sidebar .nav-link.active { background: var(--primary); color: white; box-shadow: 0 8px 15px rgba(45, 106, 79, 0.3); }
        
        .main-content { margin-left: 260px; padding: 1.5rem 2rem; min-height: 100vh; }
        
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1rem 1.5rem; border-radius: 20px; box-shadow: var(--card-shadow); }
        
        .card-modern { background: white; border: none; border-radius: 20px; box-shadow: var(--card-shadow); transition: 0.3s; }
        .card-modern:hover { transform: translateY(-2px); }
        
        .table-modern { margin-bottom: 0; }
        .table-modern thead th { background: #f8f9fa; color: #a3aed0; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; padding: 1rem; border: none; }
        .table-modern tbody td { padding: 1rem; vertical-align: middle; color: var(--text-dark); font-weight: 500; border-bottom: 1px solid #f0f2f5; }
        .table-modern tbody tr:last-child td { border-bottom: none; }
        .table-modern tbody tr:hover { background: #f9fbfd; }
        
        .btn-logout { border: 1px solid #e0e0e0; color: #e74c3c; border-radius: 12px; width: 100%; padding: 0.8rem; font-weight: 600; transition: 0.3s; }
        .btn-logout:hover { background: #fff5f5; border-color: #e74c3c; }
    </style>
    @stack('styles')
</head>
<body>

    <div class="sidebar">
        <div class="mb-4 px-2">
            <h4 class="fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-cup-hot-fill text-success"></i> Fakhri Kitchen
            </h4>
        </div>
        
        <ul class="nav flex-column">
            @php $role = auth()->user()->role ?? ''; @endphp

            {{-- ✅ ADMIN: AKSES SEMUA --}}
            @if($role === 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pakets.*') ? 'active' : '' }}" href="{{ route('pakets.index') }}">
                        <i class="bi bi-box-seam-fill"></i> Kelola Paket
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pelanggans.*') ? 'active' : '' }}" href="{{ route('pelanggans.index') }}">
                        <i class="bi bi-people-fill"></i> Data Pelanggan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pemesanans.*') ? 'active' : '' }}" href="{{ route('pemesanans.index') }}">
                        <i class="bi bi-cart-check-fill"></i> Pemesanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pengirimans.*') ? 'active' : '' }}" href="{{ route('pengirimans.index') }}">
                        <i class="bi bi-truck-front-fill"></i> Pengiriman
                    </a>
                </li>
                <li class="nav-item">
<a class="nav-link d-flex justify-content-between align-items-center
    {{ request()->routeIs('jenis-pembayaran.*') || request()->routeIs('detail-jenis-pembayaran.*') ? 'active' : '' }}"
    data-bs-toggle="collapse"
    href="#paymentMenu">

    <span class="d-flex align-items-center gap-2 text-nowrap">
        <i class="bi bi-credit-card-2-front"></i>
        Pembayaran
    </span>

    <i class="bi bi-chevron-down small"></i>
</a>

    <div class="collapse {{ request()->routeIs('jenis-pembayaran.*') || request()->routeIs('detail-jenis-pembayaran.*') ? 'show' : '' }}"
        id="paymentMenu">
        
        <ul class="nav flex-column ms-3 mt-2">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('jenis-pembayaran.*') ? 'active' : '' }}"
                    href="{{ route('jenis-pembayaran.index') }}">
                    <i class="bi bi-wallet2"></i> Jenis Pembayaran
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('detail-jenis-pembayaran.*') ? 'active' : '' }}"
                    href="{{ route('detail-jenis-pembayaran.index') }}">
                    <i class="bi bi-receipt"></i> Detail Pembayaran
                </a>
            </li>
        </ul>
    </div>
</li>
            @endif

            {{-- ✅ OWNER: CUMA DASHBOARD + LAPORAN --}}
            @if($role === 'owner')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}" href="{{ route('owner.dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#ownerReportModal">
                        <i class="bi bi-file-earmark-pdf"></i> Laporan Bulanan
                    </a>
                </li>
            @endif

            {{-- ✅ KURIR: CUMA PENGIRIMAN (KONFIRMASI) --}}
            @if($role === 'kurir')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kurir.pengirimans.*') ? 'active' : '' }}" href="{{ route('kurir.pengirimans.index') }}">
                        <i class="bi bi-truck-front-fill"></i> Konfirmasi Pengiriman
                    </a>
                </li>
            @endif
        </ul>

        <div class="mt-auto pt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div>
                <h6 class="mb-0 fw-bold text-dark">Welcome back, {{ Auth::user()->name }}!</h6>
                <small class="text-muted">
                    @if($role === 'admin') Admin Catering
                    @elseif($role === 'owner') Owner
                    @elseif($role === 'kurir') Kurir Pengiriman
                    @else Admin Catering @endif
                </small>
            </div>
            <div class="badge bg-light text-dark p-2 rounded-pill">
                <i class="bi bi-calendar3 me-1"></i> {{ now()->format('d M Y') }}
            </div>
        </div>
        @yield('content')
    </div>

    {{-- ✅ MODAL LAPORAN UNTUK OWNER --}}
    @if($role === 'owner')
    <div class="modal fade" id="ownerReportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Download Laporan Bulanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('owner.report.download') }}" method="GET">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Bulan</label>
                            <select name="bulan" class="form-select">
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Tahun</label>
                            <select name="tahun" class="form-select">
                                @for($year = date('Y')-2; $year <= date('Y'); $year++)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Download PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>