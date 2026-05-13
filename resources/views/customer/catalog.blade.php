@extends('layouts.app')

@section('title', 'Katalog Paket Catering')

@section('content')
<style>
    /* --- CONTAINER WIDTH FIX --- */
    .container {
        max-width: 1400px; /* Batasi lebar maksimal */
        margin: 0 auto;
        padding: 0 24px;
    }
    
    .catalog-container { 
        display: flex; 
        gap: 30px; 
        padding: 40px 0; 
        max-width: 100%;
    }
    
    .catalog-main { 
        flex: 1; 
        min-width: 0;
        max-width: calc(100% - 360px); /* Sisakan space untuk sidebar */
    }
    
    .catalog-sidebar { 
        width: 340px; 
        flex-shrink: 0; 
        display: flex; 
        flex-direction: column; 
        gap: 24px; 
    }
    
    /* --- FILTER TABS (PILL STYLE) --- */
    .filter-tabs { display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap; }
    .filter-tab {
        padding: 8px 18px;
        border-radius: 50px;
        border: 1px solid #e8e8e8;
        background: #fff;
        color: #666;
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .filter-tab:hover { border-color: #2d6a4f; color: #2d6a4f; }
    .filter-tab.active {
        background: #2d6a4f;
        color: white;
        border-color: #2d6a4f;
        box-shadow: 0 4px 12px rgba(45, 106, 79, 0.25);
    }
    
    /* --- PRODUCT GRID FIX --- */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* Fixed 3 kolom */
        gap: 24px;
        max-width: 100%;
    }
    
    /* --- PRODUCT CARD --- */
    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
        border: 1px solid #f3f3f3;
    }
    .product-card:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 12px 30px rgba(0,0,0,0.1);
        border-color: transparent;
    }
    .product-image { height: 220px; overflow: hidden; position: relative; }
    .product-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s; }
    .product-card:hover .product-image img { transform: scale(1.05); }
    
    .product-body { padding: 20px; }
    .product-name { font-weight: 700; font-size: 1.05rem; margin-bottom: 4px; color: #1a1a1a; }
    .product-category { color: #888; font-size: 0.8rem; margin-bottom: 10px; display: block; }
    .product-desc { color: #666; font-size: 0.85rem; margin-bottom: 14px; line-height: 1.5; height: 40px; overflow: hidden; }
    .product-pax { color: #2d6a4f; font-size: 0.85rem; font-weight: 600; margin-bottom: 10px; }
    .product-price { font-size: 1.25rem; font-weight: 800; color: #2d6a4f; margin-bottom: 18px; }
    
    /* --- QUANTITY & ADD BUTTON --- */
    .qty-control { 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        margin-bottom: 14px; 
        background: #f8f9fa; 
        width: fit-content; 
        padding: 4px; 
        border-radius: 8px;
    }
    .qty-btn {
        width: 28px; height: 28px;
        border-radius: 6px;
        border: none;
        background: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-weight: bold; color: #333;
        transition: 0.2s;
    }
    .qty-btn:hover { background: #2d6a4f; color: white; }
    .qty-input {
        width: 40px; height: 28px;
        border: none; background: transparent;
        text-align: center; font-weight: 600; font-size: 0.9rem;
    }
    .qty-input:focus { outline: none; }
    
    .btn-add-cart {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #2d6a4f 0%, #1b4332 100%);
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-add-cart:hover { 
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(45, 106, 79, 0.3); 
    }
    
    /* --- SIDEBAR STYLES --- */
/* --- UPDATE SIDEBAR SPACING --- */

/* Card Container */
.sidebar-card {
    background: white;
    border-radius: 20px;
    padding: 28px; /* Ditembak jadi lebih gede dari 24px */
    box-shadow: 0 8px 25px rgba(0,0,0,0.05);
    border: 1px solid #f0f0f0;
    margin-bottom: 24px; /* Jarak antar card */
}

/* Title */
.sidebar-title {
    font-weight: 700;
    margin-bottom: 24px; /* Jarak judul ke isi */
    padding-bottom: 16px; /* Garis bawah */
    border-bottom: 2px solid #f8f9fa; /* Garis pemisah tipis */
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 1.1rem;
}

/* Filter Section Wrapper */
.filter-section {
    margin-bottom: 28px; /* Jarak antar group filter (misal Harga vs Acara) */
}
.filter-section:last-child {
    margin-bottom: 0;
}

/* Labels */
.filter-label {
    font-weight: 700;
    margin-bottom: 12px; /* Jarak label ke opsi */
    font-size: 0.95rem;
    color: #333;
}

/* Inputs (Select, Radio, Checkbox) */
.filter-select {
    width: 100%;
    padding: 12px 16px; /* Padding input lebih lega */
    border-radius: 12px;
    border: 1px solid #e0e0e0;
    font-size: 0.95rem;
    background-color: #f9f9f9;
    cursor: pointer;
    outline: none;
    transition: all 0.2s;
}
.filter-select:focus {
    border-color: #2d6a4f;
    background-color: white;
    box-shadow: 0 0 0 4px rgba(45, 106, 79, 0.05);
}

/* Radio & Checkbox Items */
.radio-group, .checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 12px; /* Jarak antar pilihan */
}
.radio-item, .checkbox-item {
    display: flex;
    align-items: center;
    gap: 12px; /* Jarak bulatan ke teks */
    cursor: pointer;
    font-size: 0.95rem;
    color: #555;
    transition: 0.2s;
    padding: 4px 0; /* Sedikit padding biar area kliknya enak */
}
.radio-item:hover, .checkbox-item:hover {
    color: #2d6a4f;
    transform: translateX(4px); /* Efek geser dikit saat hover */
}

/* Custom Radio/Checkbox Inputs */
.radio-item input, .checkbox-item input {
    appearance: none;
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #ddd;
    border-radius: 50%;
    display: grid;
    place-content: center;
    transition: 0.2s;
    cursor: pointer;
    flex-shrink: 0; /* Biar input nggak gepeng */
}
.checkbox-item input { border-radius: 6px; }

.radio-item input:checked, .checkbox-item input:checked {
    border-color: #2d6a4f;
    background: #2d6a4f;
}
.radio-item input:checked::before {
    content: "";
    width: 8px; height: 8px;
    background: white;
    border-radius: 50%;
}
.checkbox-item input:checked::before {
    content: "✔";
    color: white;
    font-size: 12px;
}
    
    .filter-select {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        font-size: 0.9rem;
        background-color: #f9f9f9;
        cursor: pointer;
        outline: none;
    }
    .filter-select:focus { border-color: #2d6a4f; background-color: white; }
    
    /* --- CART SUMMARY ITEMS --- */
    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .cart-item:last-child { border-bottom: none; }
    .cart-item-name { font-size: 0.85rem; font-weight: 600; color: #333; }
    .cart-item-price { font-size: 0.8rem; color: #888; }
    
    .cart-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 14px;
        margin-top: 14px;
        border-top: 2px dashed #e0e0e0;
    }
    .cart-total-label { font-weight: 600; color: #555; }
    .cart-total-value { font-weight: 800; color: #2d6a4f; font-size: 1.2rem; }
    
    .btn-checkout {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        border: none;
        background: #2d6a4f;
        color: white;
        font-weight: 700;
        margin-top: 16px;
        cursor: pointer;
        transition: 0.3s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-checkout:hover { background: #1b4332; transform: translateY(-2px); }
    
    /* --- FLOATING CHAT --- */
    .floating-chat {
        position: fixed;
        bottom: 24px;
        right: 24px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        z-index: 1000;
    }
    .chat-btn {
        width: 56px; height: 56px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: transform 0.3s;
        text-decoration: none;
    }
    .chat-btn:hover { transform: scale(1.1); }
    .chat-whatsapp { background: #25D366; color: white; }
    .chat-phone { background: #2d6a4f; color: white; }
    
    /* --- SEARCH BAR --- */
    .search-bar {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 12px;
        padding: 10px 16px;
        border: 1px solid #e0e0e0;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .search-bar input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 0.95rem;
        padding: 4px 8px;
    }
    .search-bar i { color: #999; margin-right: 8px; }
    
    .empty-cart { text-align: center; padding: 20px 0; color: #999; }
    .empty-cart i { font-size: 2rem; margin-bottom: 8px; display: block; }
    
    /* --- RESPONSIVE --- */
    @media (max-width: 1024px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr); /* 2 kolom di tablet */
        }
    }
    
    @media (max-width: 992px) {
        .catalog-container { flex-direction: column; }
        .catalog-main { max-width: 100%; }
        .catalog-sidebar { width: 100%; }
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 640px) {
        .container { padding: 0 16px; }
        .product-grid {
            grid-template-columns: 1fr; /* 1 kolom di mobile */
        }
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Katalog Paket Catering</h2>
            <p class="text-muted mb-0">Pilih paket catering terbaik untuk acara Anda</p>
        </div>
    </div>

    <div class="catalog-container">
        {{-- MAIN CONTENT --}}
        <div class="catalog-main">
            {{-- Filter Tabs --}}
            <div class="filter-tabs">
                <button class="filter-tab active" data-category="all">Semua</button>
                <button class="filter-tab" data-category="snack box">Snack Box</button>
                <button class="filter-tab" data-category="meal box">Meal Box</button>
                <button class="filter-tab" data-category="prasmanan">Prasmanan</button>
                <button class="filter-tab" data-category="tumpeng">Tumpeng</button>
                <button class="filter-tab" data-category="rapat kantor">Rapat Kantor</button>
            </div>
            
            {{-- Search Bar --}}
            <div class="search-bar">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Cari paket catering...">
            </div>
            
            {{-- Product Grid --}}
            <div class="product-grid" id="productGrid">
                @forelse($pakets as $paket)
                <div class="product-card" 
                     data-category="{{ strtolower($paket->kategori) }}"
                     data-event="{{ strtolower($paket->jenis_acara ?? '') }}"
                     data-cuisine="{{ strtolower($paket->jenis_masakan ?? '') }}"
                     data-name="{{ strtolower($paket->nama_paket) }}"
                     data-price="{{ $paket->harga_paket }}">
                    <div class="product-image">
                        @if($paket->foto1 && file_exists(public_path('storage/' . $paket->foto1)))
                            <img src="{{ asset('storage/' . $paket->foto1) }}" alt="{{ $paket->nama_paket }}">
                        @else
                          @php
    $kategoriLower = strtolower($paket->kategori);
    $imageMap = [
        // SNACK BOX
        'snack box' => [
            'photo-1567620905732-2d1ec7ab744a', // Snack box tradisional
            'photo-1490806876867-3257dbb22933', // Cookies & snacks
            'photo-1558961363-fa8fdf82db35', // Pastries
        ],
        
        // MEAL BOX
        'meal box' => [
            'photo-1512621776951-a57141f2eefd', // Healthy meal box
            'photo-1546069901-ba9599a7e63c', // Salad bowl
            'photo-1540189549336-e6e99c3679fe', // Bento box
        ],
        
        // PRASMANAN
        'prasmanan' => [
            'photo-1555939594-58d7cb561ad1', // Buffet catering
            'photo-1414235077428-338989a2e8c0', // Catering spread
            'photo-1504674900247-0877df9cc836', // Food buffet
        ],
        
        // TUMPENG
        'tumpeng' => [
            'photo-1511690743698-d9d85f2fbf54', // Tumpeng traditional
            'photo-1553659971-f01207815844', // Indonesian rice cone
            'photo-1565557623262-b51c65246640', // Nasi tumpeng
        ],
        
        // RAPAT KANTOR
        'rapat kantor' => [
            'photo-1517502884422-59ea2f5b6b10', // Meeting catering
            'photo-1497935895203-76ed5c2f9f5d', // Business lunch
            'photo-1552566626-52f83d2a4c78', // Corporate event
        ],
        
        // DEFAULT
        'default' => 'photo-1414235077428-338989a2e8c0'
    ];
    
    // Pilih gambar random dari array kategori
    $images = $imageMap[$kategoriLower] ?? $imageMap['default'];
    $imageId = is_array($images) ? $images[array_rand($images)] : $images;
@endphp

<img src="https://images.unsplash.com/{{ $imageId }}?w=600&h=400&fit=crop" 
     alt="{{ $paket->nama_paket }}"
     onerror="this.src='https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=400&fit=crop'">
                        @endif
                        <span class="product-badge">{{ $paket->jenis }}</span>
                    </div>
                    <div class="product-body">
                        <h3 class="product-name">{{ $paket->nama_paket }}</h3>
                        <span class="product-category"><i class="bi bi-tag me-1"></i>{{ $paket->kategori }}</span>
                        <p class="product-desc">{{ Str::limit($paket->deskripsi, 60) }}</p>
                        <p class="product-pax"><i class="bi bi-people me-1"></i>{{ $paket->jumlah_pax }} Pax</p>
                        <div class="product-price">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</div>
                        
                        <div class="qty-control">
                            <button class="qty-btn" onclick="changeQty(this, -1)">−</button>
                            <input type="number" class="qty-input" value="1" min="1" max="100">
                            <button class="qty-btn" onclick="changeQty(this, 1)">+</button>
                        </div>
                        
                        <form action="{{ route('customer.cart.add', $paket->id) }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="jumlah" class="qty-hidden" value="1">
                            <button type="submit" class="btn-add-cart">
                                <i class="bi bi-cart-plus"></i> Tambahkan ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-box-seam fs-1 text-muted d-block mb-3"></i>
                    <h5 class="text-muted">Belum ada paket tersedia</h5>
                </div>
                @endforelse
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="catalog-sidebar">
            {{-- Ringkasan Pemesanan --}}
            <div class="sidebar-card">
                <div class="sidebar-title">
                    <span><i class="bi bi-cart3 me-2"></i>Ringkasan Pemesanan</span>
                    <span class="badge bg-success rounded-pill" id="cartCount" style="font-size: 0.75rem;">0</span>
                </div>
                
                <div id="cartItems">
                    <div class="empty-cart">
                        <i class="bi bi-cart-x d-block mb-2" style="font-size: 2rem; color: #ddd;"></i>
                        <small class="text-muted">Keranjang masih kosong</small>
                    </div>
                </div>
                
                <div id="cartSummary" style="display: none;">
                    <div class="cart-total">
                        <span class="cart-total-label">Total Sementara</span>
                        <span class="cart-total-value" id="cartTotal">Rp 0</span>
                    </div>
                    <a href="{{ route('customer.checkout') }}" class="btn-checkout">
                        <i class="bi bi-bag-check-fill"></i> Checkout Sekarang
                    </a>
                </div>
            </div>
            
            {{-- Filter Lanjutan --}}
            <div class="sidebar-card">
                <div class="sidebar-title"><i class="bi bi-funnel me-2"></i>Filter Lanjutan</div>
                
                <div class="filter-section">
                    <div class="filter-label">Urutkan berdasarkan Harga</div>
                    <select class="filter-select" id="sortSelect">
                        <option value="default">Rekomendasi</option>
                        <option value="low">Termurah</option>
                        <option value="high">Termahal</option>
                    </select>
                </div>
                
                <div class="filter-section">
                    <div class="filter-label">Jenis Acara</div>
                    <div class="radio-group">
                        <label class="radio-item">
                            <input type="radio" name="event_type" value="all" checked> Semua
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="event_type" value="wedding"> Wedding
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="event_type" value="syukuran"> Syukuran
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="event_type" value="rapat"> Rapat, dll
                        </label>
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="filter-label">Jenis Masakan</div>
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" name="cuisine_type" value="nusantara"> Nusantara
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="cuisine_type" value="internasional"> Internasional
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="cuisine_type" value="vegan"> Vegan, dll
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Floating Chat Buttons --}}
<div class="floating-chat">
    <a href="https://wa.me/6285842517974?text=Halo%20Fakhri%20Kitchen,%20saya%20butuh%20bantuan" class="chat-btn chat-whatsapp" target="_blank">
        <i class="bi bi-whatsapp fs-4"></i>
    </a>
    <a href="tel:085842517974" class="chat-btn chat-phone">
        <i class="bi bi-telephone-fill fs-4"></i>
    </a>
</div>

<script>
    // Quantity Control
    function changeQty(btn, delta) {
        const input = btn.parentElement.querySelector('.qty-input');
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        if (val > 100) val = 100;
        input.value = val;
        
        const form = btn.closest('.product-body').querySelector('.add-to-cart-form');
        form.querySelector('.qty-hidden').value = val;
    }
    
    // Filter Functions
    let currentCategory = 'all';
    let currentEvent = 'all';
    let currentCuisines = [];
    let currentSort = 'default';
    
    // Category Filter
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentCategory = this.dataset.category;
            applyFilters();
        });
    });
    
    // Event Type Filter
    document.querySelectorAll('input[name="event_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            currentEvent = this.value;
            applyFilters();
        });
    });
    
    // Cuisine Type Filter
    document.querySelectorAll('input[name="cuisine_type"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                currentCuisines.push(this.value);
            } else {
                currentCuisines = currentCuisines.filter(c => c !== this.value);
            }
            applyFilters();
        });
    });
    
    // Sort Filter
    document.getElementById('sortSelect').addEventListener('change', function() {
        currentSort = this.value;
        applyFilters();
    });
    
    // Search
    document.getElementById('searchInput').addEventListener('input', function() {
        applyFilters();
    });
    
    // Apply All Filters
// Apply All Filters
function applyFilters() {
    const cards = document.querySelectorAll('.product-card');
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    
    cards.forEach(card => {
        const category = (card.dataset.category || '').toLowerCase().trim();
        const event = (card.dataset.event || '').toLowerCase().trim();
        const cuisine = (card.dataset.cuisine || '').toLowerCase().trim();
        const name = card.dataset.name;
        
        // Category match (handle variations)
        let categoryMatch = false;
        if (currentCategory === 'all') {
            categoryMatch = true;
        } else {
            // Handle "prasmanan" vs "Prasmanan" vs "PRASMANAN"
            categoryMatch = category.includes(currentCategory.toLowerCase());
        }
        
        // Event match (handle "wedding" vs "prewedding")
        let eventMatch = false;
        if (currentEvent === 'all') {
            eventMatch = true;
        } else if (currentEvent === 'wedding') {
            // Match "wedding" OR "prewedding"
            eventMatch = event.includes('wedding');
        } else {
            eventMatch = event === currentEvent.toLowerCase();
        }
        
        // Cuisine match (if multiple selected, match any)
        const cuisineMatch = currentCuisines.length === 0 || 
                            currentCuisines.some(c => cuisine.includes(c.toLowerCase()));
        
        // Search match
        const searchMatch = name.includes(searchTerm);
        
        // Show/hide
        if (categoryMatch && eventMatch && cuisineMatch && searchMatch) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
    
    // Sort
    if (currentSort !== 'default') {
        sortProducts();
    }
    
    // Debug log
    console.log('Filter applied:', {
        category: currentCategory,
        event: currentEvent,
        cuisines: currentCuisines,
        visibleCards: document.querySelectorAll('.product-card[style="display: block;"]').length
    });
}
    
    // Sort Products
    function sortProducts() {
        const grid = document.getElementById('productGrid');
        const cards = Array.from(grid.querySelectorAll('.product-card'));
        
        cards.sort((a, b) => {
            const priceA = parseInt(a.dataset.price);
            const priceB = parseInt(b.dataset.price);
            
            if (currentSort === 'low') return priceA - priceB;
            if (currentSort === 'high') return priceB - priceA;
            return 0;
        });
        
        cards.forEach(card => grid.appendChild(card));
    }
    
    // Update Cart Summary
    function updateCartSummary() {
        fetch('/customer/cart', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            const cartCount = document.getElementById('cartCount');
            const cartItems = document.getElementById('cartItems');
            const cartSummary = document.getElementById('cartSummary');
            const cartTotal = document.getElementById('cartTotal');
            
            if (data.success && data.items && data.items.length > 0) {
                const totalItems = data.total_items || data.items.reduce((sum, item) => sum + (item.jumlah || item.quantity), 0);
                cartCount.textContent = totalItems;
                cartCount.classList.remove('bg-secondary');
                cartCount.classList.add('bg-success');
                
                const total = data.total || data.items.reduce((sum, item) => sum + (item.subtotal || 0), 0);
                if (cartTotal) {
                    cartTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
                }
                
                let itemsHtml = '';
                data.items.forEach(item => {
                    itemsHtml += `
                        <div class="cart-item">
                            <div>
                                <div class="cart-item-name">${item.jumlah || item.quantity}x ${item.nama_paket}</div>
                                <div class="cart-item-price">- Rp ${(item.subtotal || 0).toLocaleString('id-ID')}</div>
                            </div>
                        </div>
                    `;
                });
                
                cartItems.innerHTML = itemsHtml;
                cartSummary.style.display = 'block';
            } else {
                cartCount.textContent = '0';
                cartCount.classList.remove('bg-success');
                cartCount.classList.add('bg-secondary');
                
                cartItems.innerHTML = `
                    <div class="empty-cart">
                        <i class="bi bi-cart-x d-block mb-2" style="font-size: 2rem; color: #ddd;"></i>
                        <small class="text-muted">Keranjang masih kosong</small>
                    </div>
                `;
                cartSummary.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error fetching cart:', error);
        });
    }
    
    // Load cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartSummary();
        setInterval(updateCartSummary, 3000);
    });
    {{-- Debug Section (hapus setelah fix) --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== DEBUG CATALOG ===');
    
    // Log semua product cards
    document.querySelectorAll('.product-card').forEach((card, index) => {
        console.log(`Product ${index + 1}:`, {
            name: card.dataset.name,
            category: card.dataset.category,
            event: card.dataset.event,
            cuisine: card.dataset.cuisine,
            price: card.dataset.price
        });
    });
    
    // Log filter buttons
    document.querySelectorAll('.filter-tab').forEach(tab => {
        console.log('Filter button:', tab.dataset.category);
    });
});
</script>
@endpush
</script>
@endsection