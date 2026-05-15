@extends('layouts.admin')

@section('title', 'Tambah Pengiriman')

@section('content')
<div class="container py-4">
    <div class="card-modern p-4" style="max-width: 800px; margin: 0 auto;">
        <h4 class="fw-bold mb-4"><i class="bi bi-truck me-2 text-primary"></i>Tambah Pengiriman</h4>
        
        {{-- ✅ TAMBAH ERROR DISPLAY --}}
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <h6 class="fw-bold"><i class="bi bi-exclamation-triangle me-2"></i>Validasi Gagal:</h6>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        <form action="{{ route('pengirimans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Pesanan <span class="text-danger">*</span></label>
                <select name="pemesanan_id" class="form-select" required>
                    <option value="">-- Pilih Pesanan --</option>
                    @foreach($pemesanans as $pemesanan)
                    <option value="{{ $pemesanan->id }}" {{ old('pemesanan_id') == $pemesanan->id ? 'selected' : '' }}>
                        {{ $pemesanan->no_resi }} - {{ $pemesanan->pelanggan->nama_pelanggan ?? 'Pelanggan' }}
                    </option>
                    @endforeach
                </select>
                @error('pemesanan_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Kirim <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_kirim" class="form-control" value="{{ old('tgl_kirim', date('Y-m-d')) }}" required>
                    @error('tgl_kirim')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Tiba (Opsional)</label>
                    <input type="date" name="tgl_tiba" class="form-control" value="{{ old('tgl_tiba') }}">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Status Pengiriman <span class="text-danger">*</span></label>
                <select name="status_kirim" class="form-select" required>
                    <option value="Menunggu Kurir" {{ old('status_kirim') == 'Menunggu Kurir' ? 'selected' : '' }}>Menunggu Kurir</option>
                    <option value="Sedang Dikirim" {{ old('status_kirim') == 'Sedang Dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                </select>
                @error('status_kirim')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- ✅ HAPUS FIELD FOTO (Admin nggak perlu upload foto) --}}
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-2"></i>Simpan
                </button>
                <a href="{{ route('pengirimans.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection