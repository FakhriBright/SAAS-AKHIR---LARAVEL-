@extends('layouts.app')

@section('title', 'Tambah Detail Pembayaran')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Detail Pembayaran</h5>
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

                    <form action="{{ route('detail-jenis-pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Pilih Jenis Pembayaran (Dropdown) --}}
                        <div class="mb-3">
                            <label for="id_jenis_pembayaran" class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                            <select name="id_jenis_pembayaran" id="id_jenis_pembayaran"
                                    class="form-select @error('id_jenis_pembayaran') is-invalid @enderror" required>
                                <option value="">-- Pilih Metode --</option>
                                @foreach($jenisPembayarans as $jp)
                                    <option value="{{ $jp->id }}" {{ old('id_jenis_pembayaran') == $jp->id ? 'selected' : '' }}>
                                        {{ $jp->metode_pembayaran }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jenis_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih jenis pembayaran yang sudah dibuat</small>
                        </div>

                        {{-- No. Rekening --}}
                        <div class="mb-3">
                            <label for="no_rek" class="form-label">No. Rekening / Kode</label>
                            <input type="text" name="no_rek" id="no_rek"
                                   class="form-control @error('no_rek') is-invalid @enderror"
                                   value="{{ old('no_rek') }}"
                                   placeholder="Contoh: 123-456-7890 (BCA) / COD-001">
                            @error('no_rek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tempat Bayar --}}
                        <div class="mb-3">
                            <label for="tempat_bayar" class="form-label">Tempat / Instruksi Bayar</label>
                            <textarea name="tempat_bayar" id="tempat_bayar"
                                      class="form-control @error('tempat_bayar') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Contoh: Transfer ke BCA a.n. PT Catering Sejahtera">{{ old('tempat_bayar') }}</textarea>
                            @error('tempat_bayar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload Logo --}}
                        <div class="mb-4">
                            <label for="logo" class="form-label">Logo / Bukti Pembayaran</label>
                            <input type="file" name="logo" id="logo"
                                   class="form-control @error('logo') is-invalid @enderror"
                                   accept="image/*">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="{{ route('detail-jenis-pembayaran.index') }}" class="btn btn-secondary">
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
