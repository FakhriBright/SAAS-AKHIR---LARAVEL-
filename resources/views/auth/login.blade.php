@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-4">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0">
                        <i class="bi bi-box-seam"></i> Catering Admin
                    </h3>
                    <small>Silakan masuk ke akun Anda</small>
                </div>

                <div class="card-body p-4">
                    {{-- ✅ TAMPILKAN ERROR JIKA ADA --}}
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

                    {{-- ✅ FORM DENGAN ACTION & METHOD YANG BENAR --}}
                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf

                        {{-- Email Field --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   placeholder="nama@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password Field --}}
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   required
                                   placeholder="••••••••">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center py-3">
                    <small>Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Remove alert on close
    document.querySelectorAll('.alert .btn-close').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.alert').remove();
        });
    });
</script>
@endpush
