@extends('layouts.app')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-cart-plus"></i> Buat Pesanan Catering</h5>
                </div>
                <div class="card-body p-4">
                    {{-- ✅ TAMPILKAN ERROR VALIDASI DI ATAS FORM --}}
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4">
                        <h6 class="alert-heading fw-bold">⚠️ Terjadi Kesalahan:</h6>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('customer.order.store') }}" method="POST" id="orderForm">
                        @csrf

                        {{-- Pilih Paket --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih Paket <span class="text-danger">*</span></label>
                            <div id="paket-container">
                                <div class="paket-item border rounded p-3 mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-8">
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
                                            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" value="1" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPaket()">
                                <i class="bi bi-plus"></i> Tambah Paket Lain
                            </button>
                        </div>

                        {{-- Tanggal Pesan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tanggal Pesan <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_pesan" class="form-control" value="{{ old('tgl_pesan', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select name="id_jenis_bayar" id="metode-bayar" class="form-select" required>
                                <option value="">-- Pilih Metode --</option>
                                @foreach($jenisPembayarans as $jp)
                                <option value="{{ $jp->id }}" {{ old('id_jenis_bayar') == $jp->id ? 'selected' : '' }}>
                                    {{ $jp->metode_pembayaran }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- No. Rekening (Muncul jika Transfer) --}}
                        <div class="mb-4" id="no-rek-section" style="display: none;">
                            <label class="form-label fw-bold">No. Rekening Pengirim</label>
                            <input type="text" name="no_rek_pembayaran" class="form-control" value="{{ old('no_rek_pembayaran') }}" placeholder="Contoh: 1234567890">
                            <small class="text-muted">Untuk verifikasi pembayaran transfer</small>
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Acara ulang tahun, butuh 50 porsi...">{{ old('catatan') }}</textarea>
                        </div>

                        {{-- Total Preview --}}
                        <div class="alert alert-info d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Estimasi Total:</span>
                            <span class="fs-4 fw-bold text-primary" id="total-preview">Rp 0</span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-submit">
                                <i class="bi bi-check-circle"></i> Konfirmasi & Pesan
                            </button>
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">
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
    // Toggle No. Rekening
    document.getElementById('metode-bayar').addEventListener('change', function() {
        const text = this.options[this.selectedIndex].text.toLowerCase();
        document.getElementById('no-rek-section').style.display = (text.includes('transfer') || text.includes('bank')) ? 'block' : 'none';
    });

    // Tambah paket dinamis
    function addPaket() {
        const container = document.getElementById('paket-container');
        const newItem = document.createElement('div');
        newItem.className = 'paket-item border rounded p-3 mb-3';
        newItem.innerHTML = `
            <div class="row g-3">
                <div class="col-md-8">
                    <select name="paket_id[]" class="form-select" required>
                        <option value="">-- Pilih Paket --</option>
                        @foreach($pakets as $paket)
                        <option value="{{ $paket->id }}" data-harga="{{ $paket->harga }}">{{ $paket->nama_paket }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" value="1" required>
                    <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.paket-item').remove(); calculateTotal();">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
    }

    // Hitung total realtime
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('select[name="paket_id[]"]').forEach((select, i) => {
            const harga = parseInt(select.options[select.selectedIndex]?.dataset.harga) || 0;
            const jumlah = parseInt(document.querySelectorAll('input[name="jumlah[]"]')[i]?.value) || 0;
            total += harga * jumlah;
        });
        document.getElementById('total-preview').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.addEventListener('change', e => {
        if (e.target.name === 'paket_id[]' || e.target.name === 'jumlah[]') calculateTotal();
    });

    // Loading state saat submit
    document.getElementById('orderForm').addEventListener('submit', function() {
        const btn = document.getElementById('btn-submit');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
    });
</script>
@endpush
@endsection
