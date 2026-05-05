@extends('layouts.app')

@section('title', 'Login Pelanggan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="mb-0"><i class="bi bi-box-seam"></i> Catering Customer</h4>
                    <small>Login untuk pesan catering</small>
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required autofocus placeholder="email@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   required placeholder="Masukkan password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <small class="text-muted">Belum punya akun?</small><br>
                        <a href="{{ route('register') }}" class="btn btn-outline-success btn-sm mt-2">
                            <i class="bi bi-person-plus"></i> Daftar Sekarang
                        </a>
                    </div>
                </div>
                <div class="card-footer text-center py-3 bg-light">
                    <small>Admin/Kurir? <a href="{{ route('login') }}">Login disini</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
