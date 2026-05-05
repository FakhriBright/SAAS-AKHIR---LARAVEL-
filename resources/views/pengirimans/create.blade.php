@extends('layouts.app')

@section('title', 'Tambah Pengiriman')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-truck"></i> Tambah Pengiriman</h5>
                </div>
                <div class="card-body">
                    {{-- Error Validasi --}}
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

                    {{-- Error Umum --}}
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('pengirimans.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Pesanan --}}
                        <div class="mb-3">
                            <label for="pemesanan_id" class="form-label">Pilih Pesanan <span class="text-danger">*</span></label>
                            <select name="pemesanan_id" id="pemesanan_id"
                                    class="form-select @error('pemesanan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pesanan --</option>
                                @forelse($pemesanan as $p)
                                    <option value="{{ $p->id }}" {{ old('pemesanan_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->pelanggan->nama_pelanggan ?? 'Tanpa Nama' }}
                                        - {{ $p->no_resi ?? '' }}
                                        ({{ $p->tgl_pesan?->format('d/m/Y') ?? '' }})
                                        <small class="text-muted">[{{ $p->status_pesan }}]</small>
                                    </option>
                                @empty
                                    <option value="" disabled>Tidak ada pesanan yang siap dikirim</option>
                                @endforelse
                            </select>
                            @error('pemesanan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($pemesanan->isEmpty())
                                <small class="text-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Pastikan ada pemesanan dengan status "Sedang Diproses" atau "Menunggu Kurir"
                                </small>
                            @endif
                        </div>

                        {{-- Tanggal Kirim --}}
                        <div class="mb-3">
                            <label for="tgl_kirim" class="form-label">Tanggal Kirim <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_kirim" id="tgl_kirim"
                                   class="form-control @error('tgl_kirim') is-invalid @enderror"
                                   value="{{ old('tgl_kirim', date('Y-m-d')) }}" required>
                            @error('tgl_kirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status Kirim --}}
                        <div class="mb-4">
                            <label for="status_kirim" class="form-label">Status Pengiriman <span class="text-danger">*</span></label>
                            <select name="status_kirim" id="status_kirim"
                                    class="form-select @error('status_kirim') is-invalid @enderror" required>
                                <option value="Sedang Dikirim" {{ old('status_kirim') == 'Sedang Dikirim' ? 'selected' : '' }}>
                                    🚚 Sedang Dikirim
                                </option>
                                {{-- ✅ Pastikan opsi Tiba Ditujuan ada --}}
                                <option value="Tiba Ditujuan" {{ old('status_kirim') == 'Tiba Ditujuan' ? 'selected' : '' }}>
                                    ✅ Tiba Ditujuan
                                </option>
                            </select>
                            @error('status_kirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save"></i> Simpan
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
