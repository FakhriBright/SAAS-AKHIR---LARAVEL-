@extends('layouts.app')

@section('title', 'Edit Detail Pembayaran')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Detail Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('detail-jenis-pembayaran.update', $detailJenisPembayaran->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id_jenis_pembayaran" class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                            <select name="id_jenis_pembayaran" id="id_jenis_pembayaran"
                                    class="form-select" required>
                                <option value="">-- Pilih Metode --</option>
                                @foreach($jenisPembayarans as $jp)
                                    <option value="{{ $jp->id }}" {{ old('id_jenis_pembayaran', $detailJenisPembayaran->id_jenis_pembayaran) == $jp->id ? 'selected' : '' }}>
                                        {{ $jp->metode_pembayaran }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="no_rek" class="form-label">No. Rekening / Kode</label>
                            <input type="text" name="no_rek" id="no_rek"
                                   class="form-control"
                                   value="{{ old('no_rek', $detailJenisPembayaran->no_rek) }}">
                        </div>

                        <div class="mb-3">
                            <label for="tempat_bayar" class="form-label">Tempat / Instruksi Bayar</label>
                            <textarea name="tempat_bayar" id="tempat_bayar"
                                      class="form-control"
                                      rows="3">{{ old('tempat_bayar', $detailJenisPembayaran->tempat_bayar) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo / Bukti Pembayaran</label>
                            @if($detailJenisPembayaran->logo)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($detailJenisPembayaran->logo) }}" alt="Logo saat ini"
                                         class="img-thumbnail" style="max-width: 100px;">
                                    <small class="text-muted d-block">Logo saat ini</small>
                                </div>
                            @endif
                            <input type="file" name="logo" id="logo"
                                   class="form-control"
                                   accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah logo</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Update
                            </button>
                            <a href="{{ route('detail-jenis-pembayaran.index') }}" class="btn btn-secondary">
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
