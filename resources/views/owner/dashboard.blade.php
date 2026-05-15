@extends('layouts.admin')

@section('title', 'Dashboard Owner')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard Owner</h4>
        <p class="text-muted mb-0">Overview bisnis Fakhri Kitchen</p>
    </div>
    {{-- ✅ OWNER BISA DOWNLOAD LAPORAN --}}
    <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#downloadModal">
        <i class="bi bi-file-earmark-pdf me-2"></i>Download Laporan
    </button>
</div>

{{-- Stats Cards (sama seperti dashboard admin) --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card-modern p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 small fw-bold">Total Pendapatan</p>
                    <h4 class="fw-bold mb-0 text-success">Rp {{ number_format($pendapatanTotal ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div class="bg-success bg-opacity-10 rounded-3 p-2">
                    <i class="bi bi-wallet2 text-success fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    {{-- ... cards lainnya ...--}}
</div>

{{-- Modal Download (sama seperti di dashboard admin) --}}
<div class="modal fade" id="downloadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Download Laporan Bulanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('owner.report.download') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Bulan</label>
                        <select name="bulan" class="form-select">
                            @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Tahun</label>
                        <select name="tahun" class="form-select">
                            @for($year = date('Y')-2; $year <= date('Y'); $year++)
                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Download PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection