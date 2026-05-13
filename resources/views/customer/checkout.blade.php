@extends('layouts.app')
@section('title', 'Checkout Pesanan')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4"><i class="bi bi-bag-check me-2"></i>Checkout Pesanan</h2>
    
    @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('customer.order.store') }}" method="POST">
        @csrf
        <input type="hidden" name="cart_ids" value="{{ implode(',', $carts->pluck('id')->toArray()) }}">
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card fk-card mb-4">
                    <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold">Item Dipesan</h5></div>
                    <div class="card-body">
                        @foreach($carts as $cart)
                        <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                            <div><span class="fw-bold">{{ $cart->paket->nama_paket }}</span> <span class="text-muted">x{{ $cart->jumlah }}</span></div>
                            <span class="fw-bold text-success">Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="card fk-card">
                    <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold">Informasi Pengiriman & Pembayaran</h5></div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Pesan</label>
                            <input type="date" name="tgl_pesan" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Metode Pembayaran</label>
                            <select name="id_jenis_bayar" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                @foreach($jenisPembayarans as $jp)
                                <option value="{{ $jp->id }}">{{ $jp->metode_pembayaran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Acara ulang tahun, butuh 50 porsi..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card fk-card sticky-top" style="top: 90px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Total Pembayaran</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fs-5">Total</span>
                            <span class="fs-4 fw-bold text-primary">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</span>
                        </div>
                        <button type="submit" class="btn btn-fk-primary w-100 btn-lg mb-2">
                            <i class="bi bi-check-circle me-2"></i>Bayar Sekarang
                        </button>
                        <a href="{{ route('customer.cart.index') }}" class="btn btn-fk-outline w-100">Kembali ke Keranjang</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection