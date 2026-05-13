@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card-modern p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-2">Login</h3>
                    <p class="text-muted">Masuk ke akun Anda</p>
                </div>

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </form>

                <div class="text-center mt-3">
                    <small>Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a></small>
                </div>

                <hr class="my-4">

                <div class="text-center">
                    <small class="text-muted">Login sebagai:</small><br>
                    <a href="#" class="btn btn-outline-primary btn-sm mt-2">
                        <i class="bi bi-person me-1"></i>Pelanggan
                    </a>
                    <a href="#" class="btn btn-outline-dark btn-sm mt-2">
                        <i class="bi bi-shield-lock me-1"></i>Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection