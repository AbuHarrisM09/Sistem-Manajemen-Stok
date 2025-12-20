@extends('layouts.app')

@section('title', 'Manajemen Pegawai - J Stok')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col d-flex justify-content-between align-items-center">
            <h2 class="fw-bold mb-0" style="font-size:1.25rem;">
                <i class="bi bi-people-fill me-2 text-primary"></i>Manajemen Pegawai
            </h2>
            <a href="{{ route('admin.pegawai.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus-fill me-1"></i>Tambah Pegawai
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3 py-2">Username</th>
                            <th class="py-2">Nama Lengkap</th>
                            <th class="py-2">Dibuat</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pegawais as $p)
                        <tr>
                            <td class="px-3"><strong>{{ $p->username }}</strong></td>
                            <td>{{ $p->nama ?? '-' }}</td>
                            <td class="text-muted">{{ optional($p->created_at)->format('d M Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.pegawai.edit', $p) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.pegawai.destroy', $p) }}" method="POST"
                                          onsubmit="return confirm('Hapus pegawai {{ $p->username }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-4 d-block mb-2"></i>Tidak ada pegawai.
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