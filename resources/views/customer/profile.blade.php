@extends('layouts.customer-nav')
@section('title', 'Profil Saya')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('customer.orders') }}" class="btn btn-fk-outline me-3"><i class="bi bi-arrow-left"></i></a>
                <div>
                    <h2 class="fw-bold mb-1">Profil Saya</h2>
                    <p class="text-muted mb-0">Kelola informasi akun dan alamat Anda</p>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            <div class="card fk-card">
                <div class="card-body p-4">
                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap *</label>
                                <input type="text" name="nama_pelanggan" class="form-control @error('nama_pelanggan') is-invalid @enderror" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required>
                                @error('nama_pelanggan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $pelanggan->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Telepon *</label>
                                <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $pelanggan->telepon) }}" required>
                                @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Alamat Lengkap *</label>
                                <input type="text" name="alamat1" class="form-control mb-2 @error('alamat1') is-invalid @enderror" value="{{ old('alamat1', $pelanggan->alamat1) }}" placeholder="Jalan, No. Rumah" required>
                                <input type="text" name="alamat2" class="form-control mb-2" value="{{ old('alamat2', $pelanggan->alamat2) }}" placeholder="Kecamatan, Kelurahan">
                                <input type="text" name="alamat3" class="form-control" value="{{ old('alamat3', $pelanggan->alamat3) }}" placeholder="Kota, Kode Pos">
                                @error('alamat1')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <hr class="my-4">
                                <h6 class="fw-bold text-muted mb-3">Ganti Password (Opsional)</h6>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin ganti">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                            </div>
                        </div>
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-fk-primary flex-grow-1"><i class="bi bi-check-circle me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection