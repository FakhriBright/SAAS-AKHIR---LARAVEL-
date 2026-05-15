@extends('layouts.admin')

@section('title', 'Edit Pengiriman')

@section('content')
<div class="container py-4">
    <div class="card-modern p-4" style="max-width: 800px; margin: 0 auto;">
        <h4 class="fw-bold mb-4"><i class="bi bi-pencil me-2 text-warning"></i>Edit Pengiriman</h4>
        
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
        
        <form action="{{ route('pengirimans.update', $pengiriman->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Pesanan</label>
                <select name="pemesanan_id" class="form-select" required>
                    <option value="">-- Pilih Pesanan --</option>
                    @foreach($pemesanans as $pemesanan)
                    <option value="{{ $pemesanan->id }}" {{ old('pemesanan_id', $pengiriman->pemesanan_id) == $pemesanan->id ? 'selected' : '' }}>
                        {{ $pemesanan->no_resi }} - {{ $pemesanan->pelanggan->nama_pelanggan ?? 'Pelanggan' }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Kirim</label>
                    <input type="date" name="tgl_kirim" class="form-control" value="{{ old('tgl_kirim', $pengiriman->tgl_kirim?->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Tiba</label>
                    <input type="date" name="tgl_tiba" class="form-control" value="{{ old('tgl_tiba', $pengiriman->tgl_tiba?->format('Y-m-d')) }}">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Status Pengiriman</label>
                <select name="status_kirim" class="form-select" required>
                    <option value="Menunggu Kurir" {{ old('status_kirim', $pengiriman->status_kirim) == 'Menunggu Kurir' ? 'selected' : '' }}>Menunggu Kurir</option>
                    <option value="Sedang Dikirim" {{ old('status_kirim', $pengiriman->status_kirim) == 'Sedang Dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Bukti Foto</label>
                @if($pengiriman->bukti_foto)
                <div class="mb-2">
                    <img src="{{ Storage::url($pengiriman->bukti_foto) }}" alt="Bukti saat ini" class="img-thumbnail" style="max-width: 200px;">
                    <small class="text-muted d-block">Bukti saat ini</small>
                </div>
                @endif
                <input type="file" name="bukti_foto" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, PNG. Max: 2MB. Kosongkan jika tidak ingin mengubah.</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-pencil me-2"></i>Update
                </button>
                <a href="{{ route('pengirimans.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection