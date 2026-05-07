@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Pelanggan: {{ $pelanggan->nama_pelanggan }}</h5>
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

                    <form action="{{ route('pelanggans.update', $pelanggan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama Lengkap --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pelanggan" class="form-control @error('nama_pelanggan') is-invalid @enderror"
                                   value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required placeholder="Contoh: Budi Santoso">
                            @error('nama_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $pelanggan->email) }}" required placeholder="contoh@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Email digunakan untuk login ke aplikasi</small>
                        </div>

                        {{-- Password (Opsional - Kosongkan jika tidak ingin ganti) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Baru (Opsional)</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 6 karakter. Kosongkan untuk tetap pakai password lama.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Ulangi password baru">
                        </div>

                        {{-- Telepon --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                   value="{{ old('telepon', $pelanggan->telepon) }}" required placeholder="081234567890">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat 1 (Wajib) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat1" class="form-control @error('alamat1') is-invalid @enderror"
                                      rows="2" required placeholder="Jl. Contoh No. 123, RT/RW 001/002">{{ old('alamat1', $pelanggan->alamat1) }}</textarea>
                            @error('alamat1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat 2 (Opsional) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Tambahan (Opsional)</label>
                            <input type="text" name="alamat2" class="form-control @error('alamat2') is-invalid @enderror"
                                   value="{{ old('alamat2', $pelanggan->alamat2) }}" placeholder="Kelurahan, Kecamatan">
                            @error('alamat2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat 3 (Opsional) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kota / Kabupaten (Opsional)</label>
                            <input type="text" name="alamat3" class="form-control @error('alamat3') is-invalid @enderror"
                                   value="{{ old('alamat3', $pelanggan->alamat3) }}" placeholder="Kota Bandung">
                            @error('alamat3')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kartu ID / KTP (Opsional) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">No. KTP / Kartu ID (Opsional)</label>
                            <input type="text" name="kartu_id" class="form-control @error('kartu_id') is-invalid @enderror"
                                   value="{{ old('kartu_id', $pelanggan->kartu_id) }}" placeholder="3201234567890001" maxlength="16">
                            @error('kartu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir (Opsional) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Lahir (Opsional)</label>
                            <input type="date" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror"
                                   value="{{ old('tgl_lahir', $pelanggan->tgl_lahir ? $pelanggan->tgl_lahir->format('Y-m-d') : '') }}">
                            @error('tgl_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Foto Profil (Opsional) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto Profil (Opsional)</label>

                            @if($pelanggan->foto)
                            <div class="mb-2">
                                <p class="small text-muted mb-1">Foto saat ini:</p>
                                <img src="{{ asset('storage/' . $pelanggan->foto) }}" alt="Foto {{ $pelanggan->nama_pelanggan }}"
                                     class="img-thumbnail" style="max-height: 150px; object-fit: cover;">
                            </div>
                            @endif

                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto. Maksimal 2MB (JPG, PNG, GIF).</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-check-circle"></i> Update Pelanggan
                            </button>
                            <a href="{{ route('pelanggans.index') }}" class="btn btn-outline-secondary">
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
        border: 2px solid #dee2e6;
    }
    .img-thumbnail:hover {
        transform: scale(1.02);
        border-color: #0d6efd;
    }
</style>
@endpush
