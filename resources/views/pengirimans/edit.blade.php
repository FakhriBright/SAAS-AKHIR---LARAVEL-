@extends('layouts.admin')

@section('title', 'Edit Pengiriman')

@section('content')
<div class="container py-4">
    <div class="card-modern p-4" style="max-width: 800px; margin: 0 auto;">
        <h4 class="fw-bold mb-4"><i class="bi bi-pencil me-2 text-warning"></i>Edit Pengiriman</h4>
        
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        <form action="{{ route('pengirimans.update', $pengiriman->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Pesanan</label>
                <select name="id_pemesanan" class="form-select" required>
                    <option value="">-- Pilih Pesanan --</option>
                    @foreach($pemesanans as $pemesanan)
                    <option value="{{ $pemesanan->id }}" {{ old('id_pemesanan', $pengiriman->id_pemesanan) == $pemesanan->id ? 'selected' : '' }}>
                        {{ $pemesanan->no_resi }} - {{ $pemesanan->pelanggan->nama_pelanggan ?? 'Pelanggan' }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Kurir</label>
                <select name="id_kurir" class="form-select" required>
                    <option value="">-- Pilih Kurir --</option>
                    @foreach($kurirs as $kurir)
                    <option value="{{ $kurir->id }}" {{ old('id_kurir', $pengiriman->id_kurir) == $kurir->id ? 'selected' : '' }}>
                        {{ $kurir->name ?? $kurir->nama_kurir }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Kirim</label>
                    <input type="date" name="tanggal_kirim" class="form-control" value="{{ old('tanggal_kirim', $pengiriman->tanggal_kirim?->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status Pengiriman</label>
                    <select name="status_pengiriman" class="form-select">
                        <option value="Menunggu Kurir" {{ old('status_pengiriman', $pengiriman->status_pengiriman) == 'Menunggu Kurir' ? 'selected' : '' }}>Menunggu Kurir</option>
                        <option value="Sedang Dikirim" {{ old('status_pengiriman', $pengiriman->status_pengiriman) == 'Sedang Dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                        <option value="Tiba Ditujuan" {{ old('status_pengiriman', $pengiriman->status_pengiriman) == 'Tiba Ditujuan' ? 'selected' : '' }}>Tiba Ditujuan</option>
                    </select>
                </div>
            </div>
            
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-check-circle me-2"></i>Update
                </button>
                <a href="{{ route('pengirimans.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection