@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Detail Rekening</h4>
        <p class="text-muted mb-0">Kelola detail rekening untuk transfer</p>
    </div>
    <a href="{{ route('detail-jenis-pembayaran.create') }}" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-circle me-2"></i>Tambah Detail
    </a>
</div>

<div class="card-modern p-4">
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th class="ps-4">No</th>
                    <th>Jenis Pembayaran</th>
                    <th>No. Rekening / Kode</th>
                    <th>Nama Pemilik</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detailPembayarans as $index => $detail)
                <tr>
                    <td class="ps-4 fw-bold text-muted small">{{ $index + 1 }}</td>
                    <td class="fw-bold">{{ $detail->jenisPembayaran->metode_pembayaran ?? '-' }}</td>
                    {{-- ✅ FIX: Pakai nama kolom yang bener --}}
                    <td><span class="bg-light px-2 py-1 rounded text-dark fw-bold font-monospace">{{ $detail->no_rek ?? $detail->nomor_rekening ?? '-' }}</span></td>
                    <td>{{ $detail->tempat_bayar ?? $detail->nama_pemilik ?? '-' }}</td>
                    <td class="pe-4 text-end">
                        <div class="btn-group">
                            <a href="{{ route('detail-jenis-pembayaran.edit', $detail->id) }}" class="btn btn-sm btn-light text-warning"><i class="bi bi-pencil-fill"></i></a>
                            <form action="{{ route('detail-jenis-pembayaran.destroy', $detail->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus detail ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash-fill"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada detail rekening</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection