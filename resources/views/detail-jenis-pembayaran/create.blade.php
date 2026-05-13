@extends('layouts.admin')

@section('title', 'Tambah Detail Pembayaran')

@section('content')
<div class="container py-4">
    <div class="card-modern p-4" style="max-width: 800px; margin: 0 auto;">
        <h4 class="fw-bold mb-4">
            <i class="bi bi-plus-circle me-2 text-success"></i>Tambah Detail Pembayaran
        </h4>
        
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
        
        <form action="{{ route('detail-jenis-pembayaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">Jenis Pembayaran <span class="text-danger">*</span></label>
                <select name="id_jenis_pembayaran" class="form-select" required>
                    <option value="">Pilih Jenis Pembayaran</option>
                    @foreach($jenisPembayarans as $jp)
                    <option value="{{ $jp->id }}" {{ old('id_jenis_pembayaran') == $jp->id ? 'selected' : '' }}>
                        {{ $jp->metode_pembayaran }}
                    </option>
                    @endforeach
                </select>
                <small class="text-muted">Pilih jenis pembayaran yang sudah dibuat</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">No. Rekening / Kode <span class="text-danger">*</span></label>
                <input type="text" name="nomor_rekening" class="form-control" 
                       value="{{ old('nomor_rekening') }}" 
                       placeholder="Contoh: 1234567890" required>
                <small class="text-muted">Nomor rekening atau kode pembayaran</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Pemilik <span class="text-danger">*</span></label>
                <input type="text" name="nama_pemilik" class="form-control" 
                       value="{{ old('nama_pemilik') }}" 
                       placeholder="Contoh: Fakhri Kitchen" required>
                <small class="text-muted">Nama pemilik rekening</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Bank / Provider</label>
                <input type="text" name="bank" class="form-control" 
                       value="{{ old('bank') }}" 
                       placeholder="Contoh: BCA, Mandiri, GoPay, dll">
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Logo / Bukti Pembayaran</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-circle me-2"></i>Simpan
                </button>
                <a href="{{ route('detail-jenis-pembayaran.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection