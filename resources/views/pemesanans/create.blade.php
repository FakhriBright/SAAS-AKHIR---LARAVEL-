@extends('layouts.app')

@section('title', 'Tambah Pemesanan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-cart-plus"></i> Tambah Pemesanan</h5>
                </div>
                <div class="card-body">
                    {{-- Tampilkan Error Validasi --}}
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

                    {{-- Tampilkan Error Umum --}}
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    {{-- ✅ FORM ACTION: Gunakan route plural 'pemesanans.store' --}}
                    <form action="{{ route('pemesanans.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Pilih Pelanggan --}}
                            <div class="col-md-6 mb-3">
                                <label for="id_pelanggan" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                                <select name="id_pelanggan" id="id_pelanggan" class="form-select @error('id_pelanggan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach($pelanggan as $p)
                                        <option value="{{ $p->id }}" {{ old('id_pelanggan') == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_pelanggan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_pelanggan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pilih Jenis Pembayaran --}}
                            <div class="col-md-6 mb-3">
                                <label for="id_jenis_bayar" class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                                <select name="id_jenis_bayar" id="id_jenis_bayar" class="form-select @error('id_jenis_bayar') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pembayaran --</option>
                                    @foreach($jenisPembayaran as $jp)
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

                        {{-- Dynamic Paket Input --}}
                        <div class="mb-3 p-3 bg-light rounded border">
                            <label class="form-label fw-bold">Pilih Paket <span class="text-danger">*</span></label>
                            <div id="paket-container">
                                {{-- Item Pertama --}}
                                <div class="paket-item row mb-2 align-items-end g-2">
                                    <div class="col-md-5">
                                        <select name="paket_id[]" class="form-select paket-select" required onchange="hitungTotal()">
                                            <option value="">-- Pilih Paket --</option>
                                            @foreach($paket as $pk)
                                                <option value="{{ $pk->id }}"
                                                        data-harga="{{ $pk->harga }}"
                                                        data-nama="{{ $pk->nama_paket }}">
                                                    {{ $pk->nama_paket }} - Rp {{ number_format($pk->harga, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="jumlah[]" class="form-control jumlah-input"
                                               placeholder="Jumlah" min="1" value="1" required oninput="hitungTotal()">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="hapusPaket(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-sm btn-success mt-2" onclick="tambahPaket()">
                                <i class="bi bi-plus-circle"></i> + Tambah Paket Lain
                            </button>
                        </div>

                        {{-- Tanggal Pesan --}}
                        <div class="mb-3">
                            <label for="tgl_pesan" class="form-label">Tanggal Pesan <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_pesan" id="tgl_pesan"
                                   class="form-control @error('tgl_pesan') is-invalid @enderror"
                                   value="{{ old('tgl_pesan', date('Y-m-d')) }}" required>
                            @error('tgl_pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Total Bayar (Readonly) --}}
                        <div class="mb-4">
                            <label for="total_display" class="form-label fw-bold">Total Bayar</label>
                            <input type="text" id="total_display" class="form-control form-control-lg bg-light fw-bold text-primary" readonly value="Rp 0">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save"></i> Simpan Pemesanan
                            </button>
                            {{-- ✅ ROUTE INDEX: Gunakan plural 'pemesanans.index' --}}
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

{{-- JavaScript untuk Dynamic Paket & Hitung Total --}}
<script>
function tambahPaket() {
    const container = document.getElementById('paket-container');
    const newItem = document.createElement('div');
    newItem.className = 'paket-item row mb-2 align-items-end g-2';
    newItem.innerHTML = `
        <div class="col-md-5">
            <select name="paket_id[]" class="form-select paket-select" required onchange="hitungTotal()">
                <option value="">-- Pilih Paket --</option>
                @foreach($paket as $pk)
                    <option value="{{ $pk->id }}"
                            data-harga="{{ $pk->harga }}"
                            data-nama="{{ $pk->nama_paket }}">
                        {{ $pk->nama_paket }} - Rp {{ number_format($pk->harga, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="jumlah[]" class="form-control jumlah-input"
                   placeholder="Jumlah" min="1" value="1" required oninput="hitungTotal()">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="hapusPaket(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newItem);
}

function hapusPaket(btn) {
    // Jangan hapus jika itu satu-satunya item
    const items = document.querySelectorAll('.paket-item');
    if (items.length > 1) {
        btn.closest('.paket-item').remove();
        hitungTotal();
    } else {
        alert('Minimal harus ada satu paket.');
    }
}

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.paket-item').forEach(item => {
        const select = item.querySelector('.paket-select');
        const jumlahInput = item.querySelector('.jumlah-input');

        // Ambil harga dari data attribute option yang dipilih
        const selectedOption = select.options[select.selectedIndex];
        const harga = selectedOption ? selectedOption.dataset.harga : 0;
        const qty = jumlahInput.value || 0;

        if (harga && qty) {
            total += parseInt(harga) * parseInt(qty);
        }
    });

    // Format Rupiah
    const formatted = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(total);

    document.getElementById('total_display').value = formatted;
}

// Hitung saat halaman pertama kali load
document.addEventListener('DOMContentLoaded', hitungTotal);
</script>
@endsection
