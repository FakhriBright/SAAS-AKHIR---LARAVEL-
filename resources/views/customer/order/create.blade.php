@extends('layouts.customer')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="container">
    {{-- Alert Error Validasi --}}
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Validasi Gagal:</h6>
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Alert Error Umum --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-9">
            {{-- Header --}}
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('customer.orders') }}" class="btn btn-fk-outline me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h2 class="fw-bold mb-1">Buat Pesanan Baru</h2>
                    <p class="text-muted mb-0">Pilih paket dan lengkapi data pemesanan Anda</p>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('customer.order.store') }}" method="POST" id="orderForm">
                @csrf
                
                {{-- Section: Pilih Paket --}}
                <div class="card fk-card mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-box-seam text-success me-2"></i>Pilih Paket</h5>
                    </div>
                    <div class="card-body p-4">
                        <div id="paket-container">
                            {{-- Row Pertama (Default) --}}
                            <div class="paket-item border rounded p-3 mb-3 bg-light">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-7">
                                        <label class="form-label small fw-medium">Paket Catering</label>
                                        <select name="paket_id[]" class="form-select paket-select" required>
                                            <option value="">-- Pilih Paket --</option>
                                            @foreach($pakets as $paket)
                                            <option value="{{ $paket->id }}" 
                                                    data-harga="{{ $paket->harga_paket }}"
                                                    {{ isset($selectedPaketId) && $selectedPaketId == $paket->id ? 'selected' : '' }}>
                                                {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga_paket, 0, ',', '.') }} 
                                                ({{ $paket->jumlah_pax }} Pax)
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-medium">Jumlah</label>
                                        <input type="number" name="jumlah[]" class="form-control qty-input" 
                                               min="1" value="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-row" 
                                                style="display:none;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-fk-outline btn-sm mt-2" id="add-paket">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Paket Lain
                        </button>
                    </div>
                </div>

                {{-- Section: Jadwal & Pembayaran --}}
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card fk-card h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-calendar-event text-success me-2"></i>Jadwal & Pembayaran
                                </h5>
                                <div class="mb-3">
                                    <label class="form-label small fw-medium">Tanggal Pesan *</label>
                                    <input type="date" name="tgl_pesan" class="form-control" 
                                           value="{{ old('tgl_pesan', date('Y-m-d')) }}" 
                                           min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label small fw-medium">Metode Pembayaran *</label>
                                    <select name="id_jenis_bayar" class="form-select" required>
                                        <option value="">-- Pilih Metode --</option>
                                        @foreach($jenisPembayarans as $jp)
                                        <option value="{{ $jp->id }}" {{ old('id_jenis_bayar') == $jp->id ? 'selected' : '' }}>
                                            {{ $jp->metode_pembayaran }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card fk-card h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-chat-left-text text-success me-2"></i>Catatan (Opsional)
                                </h5>
                                <textarea name="catatan" class="form-control" rows="4" 
                                          placeholder="Contoh: Acara ulang tahun, butuh 50 porsi, alergen kacang...">{{ old('catatan') }}</textarea>
                                <small class="text-muted">Informasi tambahan untuk pesanan Anda</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section: Estimasi Total --}}
                <div class="card fk-card bg-success bg-opacity-10 border-success mb-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-success">Estimasi Total:</h5>
                            <small class="text-muted">Harga dapat berubah sesuai konfirmasi admin</small>
                        </div>
                        <h3 class="mb-0 fw-bold text-success" id="total-preview">Rp 0</h3>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-fk-primary btn-lg flex-grow-1" id="btn-submit">
                        <i class="bi bi-check-circle me-2"></i> Konfirmasi & Pesan
                    </button>
                    <a href="{{ route('customer.orders') }}" class="btn btn-fk-outline btn-lg">
                        <i class="bi bi-x-circle me-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Data paket dari Laravel
    const paketData = @json($pakets);
    
    const paketContainer = document.getElementById('paket-container');
    const addBtn = document.getElementById('add-paket');

    // Fungsi populate dropdown paket
    function populatePaketDropdown(selectElement, selectedId = null) {
        selectElement.innerHTML = '<option value="">-- Pilih Paket --</option>';
        paketData.forEach(paket => {
            const option = document.createElement('option');
            option.value = paket.id;
            option.dataset.harga = paket.harga_paket;
            option.textContent = `${paket.nama_paket} - Rp ${new Intl.NumberFormat('id-ID').format(paket.harga_paket)} (${paket.jumlah_pax} Pax)`;
            if (selectedId && paket.id == selectedId) {
                option.selected = true;
            }
            selectElement.appendChild(option);
        });
    }

    // Template HTML untuk row baru
    function createNewRow() {
        const div = document.createElement('div');
        div.className = 'paket-item border rounded p-3 mb-3 bg-light';
        div.innerHTML = `
            <div class="row g-3 align-items-end">
                <div class="col-md-7">
                    <label class="form-label small fw-medium">Paket Catering</label>
                    <select name="paket_id[]" class="form-select paket-select" required>
                        <option value="">-- Pilih Paket --</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control qty-input" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger btn-sm w-100 remove-row">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        return div;
    }

    // Initialize dropdown pertama
    document.addEventListener('DOMContentLoaded', function() {
        const firstSelect = paketContainer.querySelector('.paket-select');
        if (firstSelect) {
            const selectedId = firstSelect.value || @json($selectedPaketId ?? null);
            populatePaketDropdown(firstSelect, selectedId);
        }
        updateRemoveButtons();
        calculateTotal();
    });

    // Tambah baris baru
    addBtn.addEventListener('click', () => {
        const newRow = createNewRow();
        paketContainer.appendChild(newRow);
        const newSelect = newRow.querySelector('.paket-select');
        populatePaketDropdown(newSelect);
        updateRemoveButtons();
    });

    // Hapus baris (Event Delegation)
    paketContainer.addEventListener('click', (e) => {
        if(e.target.closest('.remove-row')) {
            e.target.closest('.paket-item').remove();
            updateRemoveButtons();
            calculateTotal();
        }
    });

    // Update visibility tombol hapus
    function updateRemoveButtons() {
        const rows = paketContainer.querySelectorAll('.paket-item');
        rows.forEach(row => {
            const btn = row.querySelector('.remove-row');
            btn.style.display = rows.length > 1 ? 'block' : 'none';
        });
    }

    // Hitung total estimasi
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

    // Event listener untuk perubahan
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
</script>
@endpush