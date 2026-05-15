@extends('layouts.admin')

@section('title', 'Update Pengiriman')

@section('content')
<div class="container py-4">
    <div class="card-modern p-4" style="max-width: 600px; margin: 0 auto;">
        <h4 class="fw-bold mb-4">
            <i class="bi bi-truck me-2 text-primary"></i>Update Status Pengiriman
        </h4>
        
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        
        {{-- ✅ PASTIKAN ACTION BENAR --}}
        <form action="{{ route('kurir.pengirimans.update', $pengiriman->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label fw-bold">No. Resi</label>
                <input type="text" class="form-control" value="{{ $pengiriman->pemesanan->no_resi }}" disabled>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Status Saat Ini</label>
                <input type="text" class="form-control" value="{{ $pengiriman->status_kirim }}" disabled>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Update Status <span class="text-danger">*</span></label>
                <select name="status_kirim" class="form-select" required>
                    <option value="Tiba Ditujuan" {{ old('status_kirim') == 'Tiba Ditujuan' ? 'selected' : '' }}>
                        Tiba Ditujuan ✅
                    </option>
                </select>
                <small class="text-muted">Kurir hanya bisa update status "Tiba Ditujuan"</small>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Upload Bukti Foto <span class="text-danger">*</span></label>
                @if($pengiriman->bukti_foto)
                <div class="mb-2">
                    <img src="{{ Storage::url($pengiriman->bukti_foto) }}" class="img-thumbnail" style="max-width: 200px;">
                </div>
                @endif
                <input type="file" name="bukti_foto" class="form-control" accept="image/*" required>
                <small class="text-muted">Wajib upload foto sebagai bukti pengiriman</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-circle me-2"></i>Selesaikan Pengiriman
                </button>
                <a href="{{ route('kurir.pengirimans.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection