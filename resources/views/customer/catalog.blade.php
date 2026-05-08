@extends('layouts.customer')

@section('title', 'Katalog Paket - Fakhri Kitchen')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Paket Catering Kami</h2>
        <p class="text-muted">Pilih paket catering terbaik untuk acara Anda</p>
    </div>

    <div class="row g-4">
        @forelse($pakets as $paket)
        <div class="col-lg-4 col-md-6">
            <div class="card fk-card h-100 overflow-hidden">
                <img src="{{ $paket->foto1 ? asset('storage/' . $paket->foto1) : 'https://via.placeholder.com/400x250?text=Fakhri+Kitchen' }}" class="card-img-top" alt="{{ $paket->nama_paket }}" style="height: 220px; object-fit: cover;">
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0">{{ $paket->nama_paket }}</h5>
                        <span class="badge bg-success">{{ $paket->jenis ?? 'Box' }}</span>
                    </div>
                    <p class="text-muted small flex-grow-1">{{ Str::limit($paket->deskripsi, 80) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted d-block">Mulai dari</small>
                            <h4 class="fw-bold text-success mb-0">Rp {{ number_format($paket->harga, 0, ',', '.') }}</h4>
                        </div>
                        <a href="{{ route('customer.order.create') }}?paket={{ $paket->id }}" class="btn btn-fk-primary btn-sm">
                            <i class="bi bi-cart-plus me-1"></i> Pesan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-box-seam fs-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted">Belum ada paket tersedia.</h5>
        </div>
        @endforelse
    </div>
</div>
@endsection
