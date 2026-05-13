@extends('layouts.admin')

@section('title', 'Edit Paket Catering')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Paket Catering</h5>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0 ps-3">
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
                        
                        <div class="mb-3">
                            <label for="nama_paket" class="form-label fw-bold">Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_paket') is-invalid @enderror" 
                                   id="nama_paket" name="nama_paket" value="{{ old('nama_paket', $paket->nama_paket) }}" required>
                            @error('nama_paket')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga_paket" class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('harga_paket') is-invalid @enderror" 
                                       id="harga_paket" name="harga_paket" value="{{ old('harga_paket', $paket->harga_paket) }}" 
                                       min="0" required>
                                @error('harga_paket')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_pax" class="form-label fw-bold">Jumlah Pax <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('jumlah_pax') is-invalid @enderror" 
                                       id="jumlah_pax" name="jumlah_pax" value="{{ old('jumlah_pax', $paket->jumlah_pax) }}" 
                                       min="1" required>
                                @error('jumlah_pax')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="jenis" class="form-label fw-bold">Jenis Paket <span class="text-danger">*</span></label>
                            <select name="jenis" id="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Paket --</option>
                                <option value="Prasmanan" {{ old('jenis', $paket->jenis) == 'Prasmanan' ? 'selected' : '' }}>Prasmanan</option>
                                <option value="Meal Box" {{ old('jenis', $paket->jenis) == 'Meal Box' ? 'selected' : '' }}>Meal Box</option>
                                <option value="Snack Box" {{ old('jenis', $paket->jenis) == 'Snack Box' ? 'selected' : '' }}>Snack Box</option>
                                <option value="Tumpeng" {{ old('jenis', $paket->jenis) == 'Tumpeng' ? 'selected' : '' }}>Tumpeng</option>
                            </select>
                            @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                      <div class="mb-3">
    <label for="kategori" class="form-label fw-bold">Kategori (Opsional)</label>
    <input type="text" 
           class="form-control @error('kategori') is-invalid @enderror" 
           id="kategori" 
           name="kategori" 
           value="{{ old('kategori', $paket->kategori) }}" 
           placeholder="Contoh: Prewedding, Corporate, Ulang Tahun">
    <small class="text-muted">Bebas isi kategori sesuai kebutuhan acara</small>
    @error('kategori')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Paket (Opsional)</label>
                            <div class="mb-2">
                                <label for="foto1" class="form-label small">Foto Utama</label>
                                @if($paket->foto1)
                                    <div class="mb-2"><img src="{{ asset('storage/' . $paket->foto1) }}" alt="Foto 1" class="img-thumbnail" style="max-height: 100px;"></div>
                                @endif
                                <input type="file" class="form-control @error('foto1') is-invalid @enderror" 
                                       id="foto1" name="foto1" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                                @error('foto1')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-2">
                                <label for="foto2" class="form-label small">Foto 2</label>
                                @if($paket->foto2)
                                    <div class="mb-2"><img src="{{ asset('storage/' . $paket->foto2) }}" alt="Foto 2" class="img-thumbnail" style="max-height: 100px;"></div>
                                @endif
                                <input type="file" class="form-control @error('foto2') is-invalid @enderror" 
                                       id="foto2" name="foto2" accept="image/*">
                                @error('foto2')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="foto3" class="form-label small">Foto 3</label>
                                @if($paket->foto3)
                                    <div class="mb-2"><img src="{{ asset('storage/' . $paket->foto3) }}" alt="Foto 3" class="img-thumbnail" style="max-height: 100px;"></div>
                                @endif
                                <input type="file" class="form-control @error('foto3') is-invalid @enderror" 
                                       id="foto3" name="foto3" accept="image/*">
                                @error('foto3')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning flex-grow-1">
                                <i class="bi bi-check-circle me-2"></i>Update Paket
                            </button>
                            <a href="{{ route('pakets.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection