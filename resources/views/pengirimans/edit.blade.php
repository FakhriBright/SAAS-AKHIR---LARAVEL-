@extends('layouts.app')

@section('title', 'Edit Pengiriman')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Pengiriman</h5>
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

                    {{-- ✅ PENTING: enctype untuk upload file --}}
                    <form action="{{ route('pengirimans.update', $pengiriman->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ✅ FIELD PESANAN_ID (Hidden) --}}
                        <input type="hidden" name="pemesanan_id" value="{{ $pengiriman->pemesanan_id }}">

                        {{-- Info Pesanan (Readonly) --}}
                        <div class="mb-3 p-3 bg-light rounded">
                            <label class="form-label fw-bold">Detail Pesanan</label>
                            <p class="mb-1"><strong>No. Resi:</strong> {{ $pengiriman->pemesanan->no_resi ?? '-' }}</p>
                            <p class="mb-1"><strong>Pelanggan:</strong> {{ $pengiriman->pemesanan->pelanggan->nama_pelanggan ?? '-' }}</p>
                            <p class="mb-1"><strong>Telepon:</strong> {{ $pengiriman->pemesanan->pelanggan->telepon ?? '-' }}</p>
                            <p class="mb-1"><strong>Status Pesanan:</strong>
                                <span class="badge bg-info">{{ $pengiriman->pemesanan->status_pesan }}</span>
                            </p>
                        </div>

                        {{-- Tanggal Kirim --}}
                        <div class="mb-3">
                            <label for="tgl_kirim" class="form-label">Tanggal Kirim <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_kirim" id="tgl_kirim"
                                   class="form-control @error('tgl_kirim') is-invalid @enderror"
                                   value="{{ old('tgl_kirim', $pengiriman->tgl_kirim ? \Carbon\Carbon::parse($pengiriman->tgl_kirim)->format('Y-m-d') : date('Y-m-d')) }}" required>
                            @error('tgl_kirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- UPLOAD BUKTI FOTO --}}
                        <div class="mb-3">
                            <label for="bukti_foto" class="form-label">Bukti Foto Pengiriman</label>

                            @if($pengiriman->bukti_foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $pengiriman->bukti_foto) }}" alt="Bukti Lama" class="img-thumbnail" style="max-height: 150px;">
                                    <br><small class="text-muted">Foto saat ini</small>
                                </div>
                            @endif

                            <input type="file" name="bukti_foto" id="bukti_foto"
                                   class="form-control @error('bukti_foto') is-invalid @enderror"
                                   accept="image/*">
                            @error('bukti_foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> Format: JPG/PNG. Max: 2MB.
                                <span class="text-danger">*Wajib jika status "Tiba Ditujuan"</span>
                            </small>
                        </div>

                        {{-- Status Kirim --}}
                        <div class="mb-4">
                            <label for="status_kirim" class="form-label">Status Pengiriman <span class="text-danger">*</span></label>
                            <select name="status_kirim" id="status_kirim"
                                    class="form-select @error('status_kirim') is-invalid @enderror" required>
                                <option value="Sedang Dikirim"
                                        {{ old('status_kirim', $pengiriman->status_kirim) == 'Sedang Dikirim' ? 'selected' : '' }}>
                                    🚚 Sedang Dikirim
                                </option>
                                <option value="Tiba Ditujuan"
                                        {{ old('status_kirim', $pengiriman->status_kirim) == 'Tiba Ditujuan' ? 'selected' : '' }}>
                                    ✅ Tiba Ditujuan
                                </option>
                            </select>
                            @error('status_kirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> Jika dipilih "Tiba Ditujuan", status pesanan akan otomatis berubah jadi "Selesai"
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save"></i> Update
                            </button>
                            <a href="{{ route('pengirimans.index') }}" class="btn btn-secondary">
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
