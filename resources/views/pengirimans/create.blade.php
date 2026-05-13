@extends('layouts.admin')

@section('title', 'Tambah Pengiriman')

@section('content')
<div class="container py-4">
    <div class="card-modern p-4" style="max-width: 800px; margin: 0 auto;">
        <h4 class="fw-bold mb-4"><i class="bi bi-truck me-2 text-primary"></i>Tambah Pengiriman</h4>
        
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
        
        <form action="{{ route('pengirimans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Pesanan <span class="text-danger">*</span></label>
                {{-- ✅ FIX: name="pemesanan_id" --}}
                <select name="pemesanan_id" class="form-select" required>
                    <option value="">-- Pilih Pesanan --</option>
                    @foreach($pemesanans as $pemesanan)
                    <option value="{{ $pemesanan->id }}" {{ old('pemesanan_id') == $pemesanan->id ? 'selected' : '' }}>
                        {{ $pemesanan->no_resi }} - {{ $pemesanan->pelanggan->nama_pelanggan ?? 'Pelanggan' }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Kurir <span class="text-danger">*</span></label>
                {{-- ✅ FIX: name="id_user" --}}
                <select name="id_user" class="form-select" required>
                    <option value="">-- Pilih Kurir --</option>
                    @foreach($kurirs as $kurir)
                    <option value="{{ $kurir->id }}" {{ old('id_user') == $kurir->id ? 'selected' : '' }}>
                        {{ $kurir->name ?? $kurir->nama_kurir ?? $kurir->nama_pelanggan ?? 'Kurir' }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    {{-- ✅ FIX: name="tgl_kirim" --}}
                    <label class="form-label fw-bold">Tanggal Kirim <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_kirim" class="form-control" value="{{ old('tgl_kirim', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    {{-- ✅ FIX: name="tgl_tiba" --}}
                    <label class="form-label fw-bold">Tanggal Tiba (Opsional)</label>
                    <input type="date" name="tgl_tiba" class="form-control" value="{{ old('tgl_tiba') }}">
                </div>
            </div>
            
            <div class="mb-3">
                {{-- ✅ FIX: name="status_kirim" --}}
                <label class="form-label fw-bold">Status Pengiriman</label>
                <select name="status_kirim" class="form-select">
                    <option value="Menunggu Kurir" {{ old('status_kirim') == 'Menunggu Kurir' ? 'selected' : '' }}>Menunggu Kurir</option>
                    <option value="Sedang Dikirim" {{ old('status_kirim') == 'Sedang Dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                    <option value="Tiba Ditujuan" {{ old('status_kirim') == 'Tiba Ditujuan' ? 'selected' : '' }}>Tiba Ditujuan</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Bukti Foto (Opsional)</label>
                <input type="file" name="bukti_foto" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
            </div>
            
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