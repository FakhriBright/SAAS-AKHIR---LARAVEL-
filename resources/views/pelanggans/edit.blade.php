@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Pelanggan</h5>
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

                    <form action="{{ route('pelanggans.update', $pelanggan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama Pelanggan --}}
                        <div class="mb-3">
                            <label for="nama_pelanggan" class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="nama_pelanggan"
                                   id="nama_pelanggan"
                                   class="form-control @error('nama_pelanggan') is-invalid @enderror"
                                   value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}"
                                   required>
                            @error('nama_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $pelanggan->email) }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- No. Telepon --}}
                        <div class="mb-3">
                            <label for="telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="telepon"
                                   id="telepon"
                                   class="form-control @error('telepon') is-invalid @enderror"
                                   value="{{ old('telepon', $pelanggan->telepon) }}"
                                   required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="mb-3">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date"
                                   name="tgl_lahir"
                                   id="tgl_lahir"
                                   class="form-control @error('tgl_lahir') is-invalid @enderror"
                                   value="{{ old('tgl_lahir', $pelanggan->tgl_lahir?->format('Y-m-d')) }}">
                            @error('tgl_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat 1 --}}
                        <div class="mb-3">
                            <label for="alamat1" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat1"
                                      id="alamat1"
                                      class="form-control @error('alamat1') is-invalid @enderror"
                                      rows="2"
                                      required>{{ old('alamat1', $pelanggan->alamat1) }}</textarea>
                            @error('alamat1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat 2 --}}
                        <div class="mb-3">
                            <label for="alamat2" class="form-label">Alamat Lanjutan (Opsional)</label>
                            <input type="text"
                                   name="alamat2"
                                   id="alamat2"
                                   class="form-control @error('alamat2') is-invalid @enderror"
                                   value="{{ old('alamat2', $pelanggan->alamat2) }}">
                            @error('alamat2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat 3 --}}
                        <div class="mb-3">
                            <label for="alamat3" class="form-label">Kecamatan/Kelurahan (Opsional)</label>
                            <input type="text"
                                   name="alamat3"
                                   id="alamat3"
                                   class="form-control @error('alamat3') is-invalid @enderror"
                                   value="{{ old('alamat3', $pelanggan->alamat3) }}">
                            @error('alamat3')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kartu ID --}}
                        <div class="mb-3">
                            <label for="kartu_id" class="form-label">No. Kartu Identitas</label>
                            <input type="text"
                                   name="kartu_id"
                                   id="kartu_id"
                                   class="form-control @error('kartu_id') is-invalid @enderror"
                                   value="{{ old('kartu_id', $pelanggan->kartu_id) }}">
                            @error('kartu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 8 karakter">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Update
                            </button>
                            <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">
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
