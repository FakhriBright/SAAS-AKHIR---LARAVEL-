@extends('layouts.app')

@section('title', 'Tambah Paket')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-gift"></i> Tambah Paket</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('pakets.store') }}" method="POST">
                        @csrf

                        {{-- Nama Paket --}}
                        <div class="mb-3">
                            <label for="nama_paket" class="form-label">Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" name="nama_paket" id="nama_paket"
                                   class="form-control @error('nama_paket') is-invalid @enderror"
                                   value="{{ old('nama_paket') }}" required>
                            @error('nama_paket')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                       {{-- Harga --}}
<div class="mb-3">
    <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
    <input type="number"
           name="harga"        {{-- ✅ NAME="harga" --}}
           id="harga"
           class="form-control @error('harga') is-invalid @enderror"
           value="{{ old('harga') }}"
           min="0"
           required>
    @error('harga')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Jumlah Porsi --}}
<div class="mb-3">
    <label for="jumlah_porsi" class="form-label">Jumlah Porsi <span class="text-danger">*</span></label>
    <input type="number"
           name="jumlah_porsi"  {{-- ✅ NAME="jumlah_porsi" (BUKAN jumlah_pax) --}}
           id="jumlah_porsi"
           class="form-control @error('jumlah_porsi') is-invalid @enderror"
           value="{{ old('jumlah_porsi') }}"
           min="1"
           required>
    @error('jumlah_porsi')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" id="kategori"
                                    class="form-select @error('kategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Prewedding" {{ old('kategori') == 'Prewedding' ? 'selected' : '' }}>Prewedding</option>
                                <option value="Selamatan" {{ old('kategori') == 'Selamatan' ? 'selected' : '' }}>Selamatan</option>
                                <option value="Ulang Tahun" {{ old('kategori') == 'Ulang Tahun' ? 'selected' : '' }}>Ulang Tahun</option>
                                <option value="Syukuran" {{ old('kategori') == 'Syukuran' ? 'selected' : '' }}>Syukuran</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="{{ route('pakets.index') }}" class="btn btn-secondary">
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
