@extends('layouts.app')

@section('title', 'Edit Pesanan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Pesanan: {{ $pemesanan->no_resi }}</h5>
                </div>
                <div class="card-body p-4">
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

                    <form action="{{ route('pemesanans.update', $pemesanan->id) }}" method="POST" id="orderForm">
                        @csrf
                        @method('PUT')

                        {{-- Informasi Pelanggan & Pembayaran --}}
                        <div class="row g-4 mb-4">
                            {{-- Pilih Pelanggan --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Pelanggan <span class="text-danger">*</span></label>
                                <select name="id_pelanggan" class="form-select @error('id_pelanggan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    {{-- ✅ PAKAI $pelanggans (PLURAL) --}}
                                    @foreach($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}" 
                                        {{ (old('id_pelanggan', $pemesanan->id_pelanggan) == $pelanggan->id) ? 'selected' : '' }}>
                                        {{ $pelanggan->nama_pelanggan }} - {{ $pelanggan->telepon }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_pelanggan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pilih Metode Pembayaran --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select name="id_jenis_bayar" class="form-select @error('id_jenis_bayar') is-invalid @enderror" required>
                                    <option value="">-- Pilih Metode --</option>
                                    @foreach($jenisPembayarans as $jp)
                                    <option value="{{ $jp->id }}" 
                                        {{ (old('id_jenis_bayar', $pemesanan->id_jenis_bayar) == $jp->id) ? 'selected' : '' }}>
                                        {{ $jp->metode_pembayaran }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_jenis_bayar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tanggal Pesan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tanggal Pesan <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_pesan" class="form-control @error('tgl_pesan') is-invalid @enderror" 
                                   value="{{ old('tgl_pesan', $pemesanan->tgl_pesan->format('Y-m-d')) }}" required>
                            @error('tgl_pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Detail Paket --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Detail Paket <span class="text-danger">*</span></label>
                            <div id="paket-container">
                                @forelse($pemesanan->detailPemesanans as $index => $detail)
                                <div class="paket-item border rounded p-3 mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small">Pilih Paket</label>
                                            <select name="paket_id[]" class="form-select" required>
                                                <option value="">-- Pilih Paket --</option>
                                                @foreach($pakets as $paket)
                                                <option value="{{ $paket->id }}" data-harga="{{ $paket->harga }}"
                                                    {{ $detail->paket_id == $paket->id ? 'selected' : '' }}>
                                                    {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small">Jumlah</label>
                                            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" 
                                                   min="1" value="{{ old('jumlah.' . $index, $detail->jumlah) }}" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-danger w-100" onclick="removePaket(this)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="paket-item border rounded p-3 mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small">Pilih Paket</label>
                                            <select name="paket_id[]" class="form-select" required>
                                                <option value="">-- Pilih Paket --</option>
                                                @foreach($pakets as $paket)
                                                <option value="{{ $paket->id }}" data-harga="{{ $paket->harga }}">
                                                    {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small">Jumlah</label>
                                            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" value="1" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-danger w-100" onclick="removePaket(this)" style="display:none;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPaket()">
                                <i class="bi bi-plus"></i> Tambah Paket Lain
                            </button>
                        </div>

                        {{-- Status Pesanan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Pesanan <span class="text-danger">*</span></label>
                            <select name="status_pesan" class="form-select @error('status_pesan') is-invalid @enderror" required>
                                <option value="Menunggu Konfirmasi" {{ old('status_pesan', $pemesanan->status_pesan) == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="Sedang Diproses" {{ old('status_pesan', $pemesanan->status_pesan) == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                <option value="Menunggu Kurir" {{ old('status_pesan', $pemesanan->status_pesan) == 'Menunggu Kurir' ? 'selected' : '' }}>Menunggu Kurir</option>
                                <option value="Selesai" {{ old('status_pesan', $pemesanan->status_pesan) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status_pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" 
                                      rows="3" placeholder="Contoh: Acara ulang tahun, butuh 50 porsi...">{{ old('catatan', $pemesanan->catatan) }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Total Preview --}}
                        <div class="alert alert-info d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold">Estimasi Total:</span>
                            <span class="fs-4 fw-bold text-primary" id="total-preview">Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg" id="btn-submit">
                                <i class="bi bi-check-circle"></i> Update Pesanan
                            </button>
                            <a href="{{ route('pemesanans.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Tambah paket dinamis
    function addPaket() {
        const container = document.getElementById('paket-container');
        
        const newItem = document.createElement('div');
        newItem.className = 'paket-item border rounded p-3 mb-3';
        newItem.innerHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small">Pilih Paket</label>
                    <select name="paket_id[]" class="form-select" required>
                        <option value="">-- Pilih Paket --</option>
                        @foreach($pakets as $paket)
                        <option value="{{ $paket->id }}" data-harga="{{ $paket->harga }}">{{ $paket->nama_paket }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" value="1" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="removePaket(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        updateDeleteButtons();
    }

    // Hapus paket
    function removePaket(btn) {
        btn.closest('.paket-item').remove();
        updateDeleteButtons();
        calculateTotal();
    }

    // Update visibility delete buttons
    function updateDeleteButtons() {
        const items = document.querySelectorAll('.paket-item');
        items.forEach((item) => {
            const deleteBtn = item.querySelector('button.btn-danger');
            if (deleteBtn) {
                deleteBtn.style.display = items.length > 1 ? 'block' : 'none';
            }
        });
    }

    // Hitung total realtime
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('select[name="paket_id[]"]').forEach((select, i) => {
            const option = select.options[select.selectedIndex];
            const harga = parseInt(option?.dataset.harga) || 0;
            const jumlahInputs = document.querySelectorAll('input[name="jumlah[]"]');
            const jumlah = parseInt(jumlahInputs[i]?.value) || 0;
            total += harga * jumlah;
        });
        document.getElementById('total-preview').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Auto calculate on change
    document.addEventListener('change', function(e) {
        if (e.target.name === 'paket_id[]' || e.target.name === 'jumlah[]') {
            calculateTotal();
        }
    });

    // Loading state saat submit
    document.getElementById('orderForm')?.addEventListener('submit', function() {
        const btn = document.getElementById('btn-submit');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
        }
    });

    // Init
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();
        updateDeleteButtons();
    });
</script>
@endpush
@endsection