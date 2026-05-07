@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1"><i class="bi bi-receipt"></i> Detail Pesanan</h2>
                    <p class="text-muted mb-0">No. Resi: <strong>{{ $order->no_resi }}</strong></p>
                </div>
                <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            {{-- Status Card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block mb-2">
                                <i class="bi bi-calendar-check text-primary fs-2"></i>
                            </div>
                            <p class="text-muted mb-0 small">Tanggal Pesan</p>
                            <p class="fw-bold mb-0">{{ $order->tgl_pesan->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-inline-block mb-2">
                                <i class="bi bi-clock-history text-warning fs-2"></i>
                            </div>
                            <p class="text-muted mb-0 small">Status</p>
                            @if($order->status_pesan == 'Menunggu Konfirmasi')
                                <span class="badge bg-warning text-dark fs-6">Menunggu Konfirmasi</span>
                            @elseif($order->status_pesan == 'Sedang Diproses')
                                <span class="badge bg-info text-dark fs-6">Sedang Diproses</span>
                            @elseif($order->status_pesan == 'Menunggu Kurir')
                                <span class="badge bg-secondary fs-6">Menunggu Kurir</span>
                            @elseif($order->status_pesan == 'Selesai')
                                <span class="badge bg-success fs-6">Selesai</span>
                            @endif
                        </div>
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-block mb-2">
                                <i class="bi bi-cash-coin text-success fs-2"></i>
                            </div>
                            <p class="text-muted mb-0 small">Total Bayar</p>
                            <p class="fw-bold text-primary mb-0">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 d-inline-block mb-2">
                                <i class="bi bi-credit-card text-info fs-2"></i>
                            </div>
                            <p class="text-muted mb-0 small">Pembayaran</p>
                            <p class="fw-bold mb-0">{{ $order->jenisPembayaran->metode_pembayaran ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Pesanan --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-box-seam"></i> Detail Paket</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Nama Paket</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->detailPemesanans as $index => $detail)
                                <tr>
                                    <td class="ps-4">{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $detail->paket->nama_paket ?? '-' }}</strong>
                                        @if($detail->paket->deskripsi)
                                            <br><small class="text-muted">{{ Str::limit($detail->paket->deskripsi, 50) }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $detail->jumlah }}</span>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($detail->paket->harga ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold text-primary">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <th colspan="4" class="text-end ps-4">Total:</th>
                                    <th class="text-end pe-4 fs-5 fw-bold text-primary">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Informasi Pembayaran --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-wallet2"></i> Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Metode Pembayaran:</strong></p>
                            <p class="text-muted">{{ $order->jenisPembayaran->metode_pembayaran ?? '-' }}</p>
                        </div>
                        @if($order->no_rek_pembayaran)
                        <div class="col-md-6">
                            <p class="mb-2"><strong>No. Rekening Pengirim:</strong></p>
                            <p class="text-muted">{{ $order->no_rek_pembayaran }}</p>
                        </div>
                        @endif
                    </div>
                    @if($order->jenisPembayaran->detailJenisPembayarans->isNotEmpty())
                    <hr>
                    <div class="alert alert-info">
                        <h6 class="fw-bold"><i class="bi bi-info-circle"></i> Silakan transfer ke:</h6>
                        @foreach($order->jenisPembayaran->detailJenisPembayarans as $detail)
                        <div class="mb-2">
                            <strong>{{ $detail->tempat_bayar ?? 'Bank' }}</strong><br>
                            No. Rek: <strong>{{ $detail->no_rek }}</strong><br>
                            a.n Catering Admin
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Catatan --}}
            @if($order->catatan)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-chat-left-text"></i> Catatan</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $order->catatan }}</p>
                </div>
            </div>
            @endif

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-between gap-2">
                <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

                @if($order->status_pesan == 'Menunggu Konfirmasi')
                <form action="{{ route('customer.order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle"></i> Batalkan Pesanan
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
