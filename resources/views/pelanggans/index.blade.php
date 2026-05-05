@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-people"></i> Data Pelanggan</h2>
            <p class="text-muted mb-0">Kelola data pelanggan catering</p>
        </div>
        <a href="{{ route('pelanggans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pelanggan
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Pelanggan</th>
                            <th width="20%">Email</th>
                            <th width="12%">No. Telepon</th>
                            <th width="28%">Alamat</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggans as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $p->nama_pelanggan }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->telepon }}</td>
                            <td>
                                {{-- Tampilkan alamat lengkap --}}
                                {{ $p->alamat1 }}
                                @if($p->alamat2), {{ $p->alamat2 }}@endif
                                @if($p->alamat3), {{ $p->alamat3 }}@endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('pelanggans.edit', $p->id) }}"
                                       class="btn btn-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('pelanggans.destroy', $p->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada data pelanggan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
</style>
@endpush
