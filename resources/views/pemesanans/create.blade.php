@extends('layouts.admin')

@section('title', 'Tambah Pesanan Catering')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-cart-plus me-2"></i>Tambah Pesanan Catering
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('pemesanans.store') }}" method="POST" id="orderForm">
                        @csrf

                        <div class="row g-3">
                            {{-- Pelanggan --}}
                            <div class="col-md-6">
                                <label for="id_pelanggan" class="form-label fw-bold">Pelanggan <span class="text-danger">*</span></label>
                                <select name="id_pelanggan" id="id_pelanggan" class="form-select @error('id_pelanggan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}" {{ old('id_pelanggan') == $pelanggan->id ? 'selected' : '' }}>
                                        {{ $pelanggan->nama_pelanggan }} - {{ $pelanggan->telepon }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_pelanggan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Metode Pembayaran --}}
                            <div class="col-md-6">
                                <label for="id_jenis_bayar" class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select name="id_jenis_bayar" id="id_jenis_bayar" class="form-select @error('id_jenis_bayar') is-invalid @enderror" required>
                                    <option value="">-- Pilih Metode --</option>
                                    @foreach($jenisPembayarans as $jp)
                                    <option value="{{ $jp->id }}" {{ old('id_jenis_bayar') == $jp->id ? 'selected' : '' }}>
                                        {{ $jp->metode_pembayaran }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_jenis_bayar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Tanggal Pesan --}}
                            <div class="col-12">
                                <label for="tgl_pesan" class="form-label fw-bold">Tanggal Pesan <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_pesan" id="tgl_pesan" class="form-control @error('tgl_pesan') is-invalid @enderror"
                                       value="{{ old('tgl_pesan', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                                @error('tgl_pesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Detail Paket --}}
                            <div class="col-12">
                                <label class="form-label fw-bold">Detail Paket <span class="text-danger">*</span></label>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div id="paket-container">
                                            {{-- Row Pertama --}}
                                            <div class="paket-item border rounded p-3 mb-3">
                                                <div class="row g-3 align-items-end">
                                                    <div class="col-md-8">
                                                        <label class="form-label small">Pilih Paket</label>
                                                        <select name="paket_id[]" class="form-select paket-select" required>
                                                            <option value="">-- Pilih Paket --</option>
                                                            @foreach($pakets as $paket)
                                                            <option value="{{ $paket->id }}"
                                                                    data-harga="{{ $paket->harga_paket }}">
                                                                {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                                                                ({{ $paket->jumlah_pax }} Pax)
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small">Jumlah</label>
                                                        <input type="number" name="jumlah[]" class="form-control qty-input"
                                                               min="1" value="1" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-row"
                                                                style="display:none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-paket">
                                            <i class="bi bi-plus-circle me-1"></i> Tambah Paket Lain
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Catatan --}}
                            <div class="col-12">
                                <label for="catatan" class="form-label fw-bold">Catatan (Opsional)</label>
                                <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror"
                                          rows="3" placeholder="Contoh: Acara ulang tahun, butuh 50 porsi...">{{ old('catatan') }}</textarea>
                                @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Estimasi Total --}}
                            <div class="col-12">
                                <div class="alert alert-info d-flex justify-content-between align-items-center mb-0">
                                    <h5 class="mb-0 fw-bold">Estimasi Total:</h5>
                                    <h3 class="mb-0 fw-bold text-primary" id="total-preview">Rp 0</h3>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary flex-grow-1 btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Simpan Pesanan
                            </button>
                            <a href="{{ route('pemesanans.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle me-2"></i>Batal
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
    // Data paket dari Laravel ke JavaScript
    const paketData = @json($pakets);

    const paketContainer = document.getElementById('paket-container');
    const addBtn = document.getElementById('add-paket');

    // Fungsi populate dropdown
    function populatePaketDropdown(selectElement) {
        // Clear existing options except first
        selectElement.innerHTML = '<option value="">-- Pilih Paket --</option>';

        paketData.forEach(paket => {
            const option = document.createElement('option');
            option.value = paket.id;
            option.dataset.harga = paket.harga_paket;
            option.textContent = `${paket.nama_paket} - Rp ${new Intl.NumberFormat('id-ID').format(paket.harga_paket)} (${paket.jumlah_pax} Pax)`;
            selectElement.appendChild(option);
        });
    }

    // Template HTML untuk row baru
    function createNewRow() {
        const div = document.createElement('div');
        div.className = 'paket-item border rounded p-3 mb-3';
        div.innerHTML = `
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label small">Pilih Paket</label>
                    <select name="paket_id[]" class="form-select paket-select" required>
                        <option value="">-- Pilih Paket --</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control qty-input" min="1" value="1" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-row">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        return div;
    }

    // Initialize dropdown pertama
    const firstSelect = paketContainer.querySelector('.paket-select');
    if (firstSelect) {
        populatePaketDropdown(firstSelect);
    }

    // Tambah baris baru
    addBtn.addEventListener('click', () => {
        const newRow = createNewRow();
        paketContainer.appendChild(newRow);
        const newSelect = newRow.querySelector('.paket-select');
        populatePaketDropdown(newSelect);
        updateRemoveButtons();
    });

    // Hapus baris
    paketContainer.addEventListener('click', (e) => {
        if(e.target.closest('.remove-row')) {
            const row = e.target.closest('.paket-item');
            row.remove();
            updateRemoveButtons();
            calculateTotal();
        }
    });

    // Update tombol hapus
    function updateRemoveButtons() {
        const rows = paketContainer.querySelectorAll('.paket-item');
        rows.forEach((row, index) => {
            const btn = row.querySelector('.remove-row');
            btn.style.display = rows.length > 1 ? 'block' : 'none';
        });
    }

    // Hitung total
    function calculateTotal() {
        let total = 0;
        const rows = paketContainer.querySelectorAll('.paket-item');

        rows.forEach(row => {
            const select = row.querySelector('.paket-select');
            const qtyInput = row.querySelector('.qty-input');

            const selectedOption = select.options[select.selectedIndex];
            const harga = parseInt(selectedOption?.dataset.harga) || 0;
            const qty = parseInt(qtyInput.value) || 0;

            total += harga * qty;
        });

        document.getElementById('total-preview').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Event listeners
    paketContainer.addEventListener('change', (e) => {
        if(e.target.matches('.paket-select, .qty-input')) {
            calculateTotal();
        }
    });

    paketContainer.addEventListener('input', (e) => {
        if(e.target.matches('.qty-input')) {
            calculateTotal();
        }
    });

    // Init
    updateRemoveButtons();
    calculateTotal();
</script>
@endpush
@endsection
