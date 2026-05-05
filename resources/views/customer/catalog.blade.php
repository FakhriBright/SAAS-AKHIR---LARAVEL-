@extends('layouts.app')

@section('title', 'Katalog Paket Catering')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">Paket Catering Kami</h1>
        <p class="lead text-muted">Pilih paket catering terbaik untuk acara Anda</p>
        @guest
        <div class="d-flex justify-content-center gap-2 mt-3">
            <a href="{{ route('customer.login') }}" class="btn btn-outline-primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang</a>
        </div>
        @endguest
    </div>

    <div class="row g-4">
        @forelse($pakets as $paket)
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                @if($paket->foto1)
                <img src="{{ asset('storage/' . $paket->foto1) }}" class="card-img-top" alt="{{ $paket->nama_paket }}" style="height: 250px; object-fit: cover;">
                @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                    <i class="bi bi-image display-4 text-muted"></i>
                </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <h5 class="card-title fw-bold mb-0">{{ $paket->nama_paket }}</h5>
                        <span class="badge bg-primary mt-1">{{ ucfirst($paket->jenis) }}</span>
                    </div>
                    <p class="text-muted small mb-2"><i class="bi bi-people"></i> {{ $paket->jumlah_pax }} Pax</p>
                    <p class="card-text text-muted small flex-grow-1">{{ Str::limit($paket->deskripsi, 80) }}</p>

                    <h4 class="text-primary fw-bold mb-3">Rp {{ number_format($paket->harga, 0, ',', '.') }}</h4>

                    {{-- ✅ TOMBOL INI YANG MENGARAH KE FORM PEMESANAN --}}
                    <a href="{{ route('customer.order.create') }}" class="btn btn-primary w-100 mt-auto">
                        <i class="bi bi-cart-plus"></i> Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <p class="mt-3">Belum ada paket tersedia</p>
        </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    .hover-card { transition: transform 0.3s, box-shadow 0.3s; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important; }
</style>
@endpush
@endsection
