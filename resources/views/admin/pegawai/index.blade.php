@extends('layouts.app')

@section('title', 'Manajemen Pegawai - J Stok')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); overflow:hidden;">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3 py-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle p-3" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                            <i class="bi bi-people-fill text-white" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h2 class="text-white fw-bold mb-1">Manajemen Pegawai</h2>
                            <p class="text-white text-opacity-75 mb-0 small">Kelola akun pegawai dengan cepat dan aman</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-white text-opacity-90 text-end">
                            <p class="mb-1 small">Total Pegawai</p>
                            <h3 class="fw-bold mb-0">{{ $pegawais->count() }}</h3>
                        </div>
                        <a href="{{ route('admin.pegawai.create') }}" class="btn btn-light text-primary shadow-sm">
                            <i class="bi bi-person-plus-fill me-2"></i>Tambah Pegawai
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0 fw-bold d-flex align-items-center">
                <i class="bi bi-table me-2 text-primary"></i>Daftar Pegawai
            </h5>
            <span class="badge bg-light text-dark border">{{ $pegawais->count() }} akun</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 modern-table">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">Username</th>
                            <th class="py-3">Nama Lengkap</th>
                            <th class="py-3">Dibuat</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pegawais as $p)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center gap-3">
                                    @php
                                        $initial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($p->nama ?: $p->username, 0, 1));
                                    @endphp
                                    <div class="icon-wrapper text-white fw-bold" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 12px; border-radius: 12px; width: 46px; height: 46px; display:flex; align-items:center; justify-content:center;">
                                        {{ $initial }}
                                    </div>
                                    <div>
                                        <strong class="d-block">{{ $p->username }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $p->nama ?? '-' }}</td>
                            <td class="text-muted">{{ optional($p->created_at)->format('d M Y H:i') }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.pegawai.edit', $p) }}" class="btn btn-outline-warning btn-icon" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.pegawai.destroy', $p) }}" method="POST"
                                          onsubmit="return confirm('Hapus pegawai {{ $p->username }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-icon" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2" style="opacity:0.3;"></i>
                                Tidak ada pegawai terdaftar
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