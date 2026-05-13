@extends('layouts.app')

@section('title', 'Katalog Paket Catering')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Katalog Paket Catering</h2>
            <p class="text-muted mb-0">Pilih paket catering terbaik untuk acara Anda</p>
        </div>
        <a href="{{ route('customer.cart.index') }}" class="btn btn-fk-outline position-relative">
            <i class="bi bi-cart3 me-2"></i>Keranjang
            @php $count = \App\Models\Cart::where('id_pelanggan', auth()->guard('pelanggan')->id())->sum('jumlah'); @endphp
            @if($count > 0) 
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem;">
                    {{ $count > 99 ? '99+' : $count }}
                </span> 
            @endif
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($pakets->count() > 0)
    <div class="row g-4">
        @foreach($pakets as $paket)
        <div class="col-md-6 col-lg-4">
            <div class="card fk-card h-100">
                <div class="position-relative" style="height: 220px; overflow: hidden; background: #f8f9fa;">
                    {{-- Gambar dari Unsplash API berdasarkan kategori --}}
                    @php
                        $imageKeywords = [
                            'prasmanan' => 'buffet+catering+indonesian',
                            'meal box' => 'meal+box+lunch',
                            'snack box' => 'snack+box+indonesian',
                            'tumpeng' => 'tumpeng+indonesian+food',
                            'default' => 'catering+food+buffet'
                        ];
                        $kategori = strtolower($paket->kategori);
                        $keyword = $imageKeywords[$kategori] ?? $imageKeywords['default'];
                        $imageUrl = "https://source.unsplash.com/600x400/?{$keyword}";
                    @endphp
                    
                    @if($paket->foto1)
                        <img src="{{ asset('storage/' . $paket->foto1) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $paket->nama_paket }}">
                    @else
                      {{-- Ganti bagian gambar dengan ini --}}
<img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&h=400&fit=crop&{{ $paket->id }}" 
     class="w-100 h-100" 
     style="object-fit: cover;" 
     alt="{{ $paket->nama_paket }}">
                             onerror="this.src='https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=400&fit=crop'">
                    @endif
                    
                    <span class="position-absolute top-0 end-0 m-2 badge bg-primary">{{ $paket->jenis }}</span>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold mb-1">{{ $paket->nama_paket }}</h5>
                    <p class="text-muted small mb-2">
                        <i class="bi bi-tag me-1"></i>{{ $paket->kategori }}
                    </p>
                    <p class="card-text text-muted small mb-3 flex-grow-1">
                        {{ Str::limit($paket->deskripsi, 80) }}
                    </p>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-people text-primary me-2"></i>
                        <span class="fw-medium small">{{ $paket->jumlah_pax }} Pax</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Harga per paket</small>
                        <h4 class="text-success fw-bold mb-0">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</h4>
                    </div>
                    <form action="{{ route('customer.cart.add', $paket->id) }}" method="POST">
                        @csrf
                        <div class="input-group input-group-sm">
                            <input type="number" name="jumlah" class="form-control" value="1" min="1" style="max-width: 70px;">
                            <button type="submit" class="btn btn-fk-primary">
                                <i class="bi bi-cart-plus me-1"></i>Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-4">
        {{ $pakets->links('pagination::bootstrap-5') }}
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-box-seam fs-1 text-muted d-block mb-3"></i>
        <h5 class="text-muted">Belum ada paket tersedia</h5>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .fk-card { 
        border: none; 
        border-radius: 16px; 
        box-shadow: 0 5px 20px rgba(112, 144, 176, 0.08); 
        transition: all 0.3s;
        overflow: hidden;
    }
    .fk-card:hover { 
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }
    .btn-fk-primary { 
        background: #2d6a4f; 
        color: white; 
        border: none; 
        border-radius: 8px; 
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-fk-primary:hover { 
        background: #1b4332; 
        color: white;
        transform: translateY(-2px);
    }
    .btn-fk-outline { 
        border: 1px solid #2d6a4f; 
        color: #2d6a4f; 
        background: transparent; 
        border-radius: 8px; 
        font-weight: 500;
    }
    .btn-fk-outline:hover { 
        background: #2d6a4f; 
        color: white;
    }
</style>
@endpush