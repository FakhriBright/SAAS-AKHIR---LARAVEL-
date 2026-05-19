@extends('layouts.admin')

@section('title', 'Tambah Pesanan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Pesanan Baru</h5>
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

                    <form action="{{ route('pemesanans.store') }}" method="POST" id="orderForm">
                        @csrf

                        {{-- Informasi Pelanggan & Pembayaran --}}
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Pelanggan <span class="text-danger">*</span></label>
                                <select name="id_pelanggan" class="form-select @error('id_pelanggan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}" {{ old('id_pelanggan') == $pelanggan->id ? 'selected' : '' }}>
                                        {{ $pelanggan->nama_pelanggan }} - {{ $pelanggan->telepon }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_pelanggan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select name="id_jenis_bayar" class="form-select @error('id_jenis_bayar') is-invalid @enderror" required>
                                    <option value="">-- Pilih Metode --</option>
                                    @foreach($jenisPembayarans as $jp)
                                    <option value="{{ $jp->id }}" {{ old('id_jenis_bayar') == $jp->id ? 'selected' : '' }}>
                                        {{ $jp->metode_pembayaran }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_jenis_bayar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tanggal Pengiriman --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-calendar-event me-2"></i>
                                Tanggal Pengiriman <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tgl_pesan" class="form-control @error('tgl_pesan') is-invalid @enderror"
                                   value="{{ old('tgl_pesan', date('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                            @error('tgl_pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tanggal pengiriman pesanan</small>
                        </div>

                        {{-- Detail Paket --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Detail Paket <span class="text-danger">*</span></label>
                            <div id="paket-container">
                                <div class="paket-item border rounded p-3 mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small">Pilih Paket</label>
                                            <select name="paket_id[]" class="form-select paket-select" required>
                                                <option value="">-- Pilih Paket --</option>
                                                @foreach($pakets as $paket)
                                                <option value="{{ $paket->id }}" data-harga="{{ $paket->harga_paket }}">
                                                    {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small">Jumlah</label>
                                            <input type="number" name="jumlah[]" class="form-control qty-input" placeholder="Jumlah" min="1" value="1" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-danger w-100" onclick="removePaket(this)" style="display:none;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPaket()">
                                <i class="bi bi-plus"></i> Tambah Paket Lain
                            </button>
                        </div>

                        {{-- Status Pesanan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Pesanan <span class="text-danger">*</span></label>
                            <select name="status_pesan" class="form-select @error('status_pesan') is-invalid @enderror" required>
                                <option value="Menunggu Konfirmasi" {{ old('status_pesan') == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="Sedang Diproses" {{ old('status_pesan') == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                <option value="Menunggu Kurir" {{ old('status_pesan') == 'Menunggu Kurir' ? 'selected' : '' }}>Menunggu Kurir</option>
                                <option value="Selesai" {{ old('status_pesan') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Dibatalkan" {{ old('status_pesan') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            @error('status_pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror"
                                      rows="3" placeholder="Contoh: Acara ulang tahun, butuh 50 porsi...">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Total Preview --}}
                        <div class="alert alert-info d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold">Estimasi Total:</span>
                            <span class="fs-4 fw-bold text-primary" id="total-preview">Rp 0</span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-submit">
                                <i class="bi bi-check-circle"></i> Simpan Pesanan
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
    // Data paket
    const paketData = @json($pakets);

    // Fungsi populate dropdown
    function populatePaketDropdown(selectElement) {
        selectElement.innerHTML = '<option value="">-- Pilih Paket --</option>';
        paketData.forEach(paket => {
            const option = document.createElement('option');
            option.value = paket.id;
            option.dataset.harga = paket.harga_paket;
            option.textContent = `${paket.nama_paket} - Rp ${new Intl.NumberFormat('id-ID').format(paket.harga_paket)}`;
            selectElement.appendChild(option);
        });
    }

    // Tambah paket dinamis
    function addPaket() {
        const container = document.getElementById('paket-container');
        const newItem = document.createElement('div');
        newItem.className = 'paket-item border rounded p-3 mb-3';
        newItem.innerHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small">Pilih Paket</label>
                    <select name="paket_id[]" class="form-select paket-select" required>
                        <option value="">-- Pilih Paket --</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control qty-input" placeholder="Jumlah" min="1" value="1" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="removePaket(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);

        // Populate dropdown yang baru
        const newSelect = newItem.querySelector('.paket-select');
        populatePaketDropdown(newSelect);

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

    // Init
    document.addEventListener('DOMContentLoaded', function() {
        // Populate semua dropdown yang ada
        document.querySelectorAll('.paket-select').forEach(select => {
            if (!select.options.length || select.options.length === 1) {
                populatePaketDropdown(select);
            }
        });

        calculateTotal();
        updateDeleteButtons();
    });
</script>
@endpush
@endsection
