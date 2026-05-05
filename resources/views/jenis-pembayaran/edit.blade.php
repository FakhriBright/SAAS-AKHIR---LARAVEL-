@extends('layouts.app')

@section('title', 'Edit Jenis Pembayaran')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Jenis Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('jenis-pembayaran.update', $jenisPembayaran->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <input type="text" name="metode_pembayaran" id="metode_pembayaran"
                                   class="form-control"
                                   value="{{ old('metode_pembayaran', $jenisPembayaran->metode_pembayaran) }}" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Update
                            </button>
                            <a href="{{ route('jenis-pembayaran.index') }}" class="btn btn-secondary">
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
