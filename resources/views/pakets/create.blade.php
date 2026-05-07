@extends('layouts.app')

@section('title', 'Tambah Paket Baru')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Paket Catering</h5>
                </div>
                <div class="card-body p-4">
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

                    <form action="{{ route('pakets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama Paket --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" name="nama_paket" class="form-control @error('nama_paket') is-invalid @enderror" 
                                   value="{{ old('nama_paket') }}" required placeholder="Contoh: Paket Premium">
                            @error('nama_paket')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                      rows="3" required placeholder="Deskripsi paket...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Harga & Jumlah Pax --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                                       value="{{ old('harga') }}" min="0" required placeholder="50000">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jumlah Pax <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_pax" class="form-control @error('jumlah_pax') is-invalid @enderror" 
                                       value="{{ old('jumlah_pax') }}" min="1" required placeholder="1">
                                @error('jumlah_pax')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Jumlah porsi/orang</small>
                            </div>
                        </div>

                        {{-- Jenis Paket --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Paket <span class="text-danger">*</span></label>
                            <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Prasmanan" {{ old('jenis') == 'Prasmanan' ? 'selected' : '' }}>Prasmanan</option>
                                <option value="Box" {{ old('jenis') == 'Box' ? 'selected' : '' }}>Box</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori (Opsional)</label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" 
                                   value="{{ old('kategori') }}" placeholder="Contoh: Prewedding, Ulang Tahun">
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pisahkan dengan koma jika lebih dari satu</small>
                        </div>

                        {{-- Upload Foto --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto Paket (Opsional)</label>
                            
                            <div class="mb-2">
                                <label class="form-label small">Foto Utama</label>
                                <input type="file" name="foto1" class="form-control @error('foto1') is-invalid @enderror" accept="image/*">
                                @error('foto1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-2">
                                <label class="form-label small">Foto 2</label>
                                <input type="file" name="foto2" class="form-control @error('foto2') is-invalid @enderror" accept="image/*">
                                @error('foto2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-2">
                                <label class="form-label small">Foto 3</label>
                                <input type="file" name="foto3" class="form-control @error('foto3') is-invalid @enderror" accept="image/*">
                                @error('foto3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Simpan Paket
                            </button>
                            <a href="{{ route('pakets.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection