@extends('layouts.app')

@section('title', 'Edit Paket')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Paket: {{ $paket->nama_paket }}</h5>
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

                    <form action="{{ route('pakets.update', $paket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama Paket --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" name="nama_paket" class="form-control @error('nama_paket') is-invalid @enderror" 
                                   value="{{ old('nama_paket', $paket->nama_paket) }}" required placeholder="Contoh: Paket Premium">
                            @error('nama_paket')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                      rows="3" required placeholder="Deskripsi paket...">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Harga & Jumlah Pax --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                                       value="{{ old('harga', $paket->harga) }}" min="0" required placeholder="50000">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jumlah Pax <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_pax" class="form-control @error('jumlah_pax') is-invalid @enderror" 
                                       value="{{ old('jumlah_pax', $paket->jumlah_pax) }}" min="1" required placeholder="1">
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
                                <option value="Prasmanan" {{ old('jenis', $paket->jenis) == 'Prasmanan' ? 'selected' : '' }}>Prasmanan</option>
                                <option value="Box" {{ old('jenis', $paket->jenis) == 'Box' ? 'selected' : '' }}>Box</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori (Opsional)</label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" 
                                   value="{{ old('kategori', $paket->kategori) }}" placeholder="Contoh: Prewedding, Ulang Tahun">
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pisahkan dengan koma jika lebih dari satu</small>
                        </div>

                        {{-- Preview Foto Saat Ini --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto Saat Ini</label>
                            <div class="row g-2">
                                @if($paket->foto1)
                                <div class="col-4">
                                    <img src="{{ asset('storage/' . $paket->foto1) }}" class="img-thumbnail" alt="Foto 1" style="height: 80px; object-fit: cover;">
                                    <small class="d-block text-center">Foto 1</small>
                                </div>
                                @endif
                                @if($paket->foto2)
                                <div class="col-4">
                                    <img src="{{ asset('storage/' . $paket->foto2) }}" class="img-thumbnail" alt="Foto 2" style="height: 80px; object-fit: cover;">
                                    <small class="d-block text-center">Foto 2</small>
                                </div>
                                @endif
                                @if($paket->foto3)
                                <div class="col-4">
                                    <img src="{{ asset('storage/' . $paket->foto3) }}" class="img-thumbnail" alt="Foto 3" style="height: 80px; object-fit: cover;">
                                    <small class="d-block text-center">Foto 3</small>
                                </div>
                                @endif
                                @if(!$paket->foto1 && !$paket->foto2 && !$paket->foto3)
                                <p class="text-muted small">Belum ada foto</p>
                                @endif
                            </div>
                        </div>

                        {{-- Upload Foto Baru --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload Foto Baru (Opsional)</label>
                            <small class="text-muted d-block mb-2">Kosongkan jika tidak ingin mengganti foto</small>
                            
                            <div class="mb-2">
                                <label class="form-label small">Ganti Foto Utama</label>
                                <input type="file" name="foto1" class="form-control @error('foto1') is-invalid @enderror" accept="image/*">
                                @error('foto1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-2">
                                <label class="form-label small">Ganti Foto 2</label>
                                <input type="file" name="foto2" class="form-control @error('foto2') is-invalid @enderror" accept="image/*">
                                @error('foto2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-2">
                                <label class="form-label small">Ganti Foto 3</label>
                                <input type="file" name="foto3" class="form-control @error('foto3') is-invalid @enderror" accept="image/*">
                                @error('foto3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-check-circle"></i> Update Paket
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

@push('styles')
<style>
    .img-thumbnail {
        transition: transform 0.2s;
    }
    .img-thumbnail:hover {
        transform: scale(1.05);
    }
</style>
@endpush