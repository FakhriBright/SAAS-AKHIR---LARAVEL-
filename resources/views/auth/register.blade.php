@extends('layouts.app')

@section('title', 'Daftar Akun Pelanggan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-4">
                    <h4 class="mb-0"><i class="bi bi-person-plus"></i> Daftar Akun Pelanggan</h4>
                    <small class="opacity-75">Silakan isi data untuk membuat akun</small>
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('register.process') }}" method="POST">
                        @csrf

                        {{-- Nama Lengkap --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required placeholder="contoh@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Telepon --}}
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                   value="{{ old('telepon') }}" required placeholder="08123456789">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                      rows="3" required placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   required placeholder="Minimal 6 karakter">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   required placeholder="Ulangi password">
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2">
                            <i class="bi bi-person-plus"></i> Daftar Sekarang
                        </button>
                    </form>
                </div>
                <div class="card-footer text-center py-3 bg-light">
                    <small>Sudah punya akun? <a href="{{ route('login') }}">Login disini</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
