@extends('layouts.app')

@section('title', 'Edit Pemesanan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Pemesanan</h5>
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

                    <form action="{{ route('pemesanans.update', $pemesanan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Pelanggan --}}
                            <div class="col-md-6 mb-3">
                                <label for="id_pelanggan" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                                <select name="id_pelanggan" id="id_pelanggan" class="form-select" required disabled>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach($pelanggan as $p)
                                        <option value="{{ $p->id }}"
                                                {{ old('id_pelanggan', $pemesanan->id_pelanggan) == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_pelanggan }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="id_pelanggan" value="{{ $pemesanan->id_pelanggan }}">
                                <small class="text-muted">Pelanggan tidak dapat diubah setelah pemesanan dibuat</small>
                            </div>

                            {{-- Jenis Pembayaran --}}
                            <div class="col-md-6 mb-3">
                                <label for="id_jenis_bayar" class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                                <select name="id_jenis_bayar" id="id_jenis_bayar" class="form-select" required>
                                    <option value="">-- Pilih Pembayaran --</option>
                                    @foreach($jenisPembayaran as $jp)
                                        <option value="{{ $jp->id }}"
                                                {{ old('id_jenis_bayar', $pemesanan->id_jenis_bayar) == $jp->id ? 'selected' : '' }}>
                                            {{ $jp->metode_pembayaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Status Pemesanan --}}
                        <div class="mb-3">
                            <label for="status_pesan" class="form-label">Status Pemesanan <span class="text-danger">*</span></label>
                            <select name="status_pesan" id="status_pesan" class="form-select" required>
                                <option value="Menunggu Konfirmasi"
                                        {{ old('status_pesan', $pemesanan->status_pesan) == 'Menunggu Konfirmasi' ? 'selected' : '' }}>
                                    Menunggu Konfirmasi
                                </option>
                                <option value="Sedang Diproses"
                                        {{ old('status_pesan', $pemesanan->status_pesan) == 'Sedang Diproses' ? 'selected' : '' }}>
                                    Sedang Diproses
                                </option>
                                <option value="Menunggu Kurir"
                                        {{ old('status_pesan', $pemesanan->status_pesan) == 'Menunggu Kurir' ? 'selected' : '' }}>
                                    Menunggu Kurir
                                </option>
                                {{-- ✅ TAMBAHKAN OPSI SELESAI --}}
                                <option value="Selesai"
                                        {{ old('status_pesan', $pemesanan->status_pesan) == 'Selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                            </select>
                            @error('status_pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Info Pemesanan (Readonly) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Detail Pemesanan</label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-1"><strong>No. Resi:</strong> {{ $pemesanan->no_resi }}</p>
                                    <p class="mb-1"><strong>Tanggal Pesan:</strong> {{ $pemesanan->tgl_pesan?->format('d/m/Y') }}</p>
                                    <p class="mb-1"><strong>Total Bayar:</strong> Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}</p>
                                    <hr>
                                    <p class="mb-2"><strong>Paket Dipesan:</strong></p>
                                    <ul class="mb-0 ps-3">
                                        @foreach($pemesanan->detailPemesanans as $detail)
                                            <li>
                                                {{ $detail->paket->nama_paket ?? 'Paket Dihapus' }}
                                                <span class="text-muted small">(Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save"></i> Update
                            </button>
                            <a href="{{ route('pemesanans.index') }}" class="btn btn-secondary">
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
