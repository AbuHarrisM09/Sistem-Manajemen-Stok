@extends('layouts.app')

@section('title', 'Edit Pegawai - J Stok')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1 d-flex align-items-center"><i class="bi bi-person-gear me-2 text-primary"></i>Edit Pegawai</h2>
                <p class="text-muted mb-0 small">Perbarui data akun pegawai</p>
            </div>
            <a href="{{ route('admin.pegawai.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.pegawai.update', $pengguna) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                       value="{{ old('username', $pengguna->username) }}" required>
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama', $pengguna->nama) }}" placeholder="contoh: Budi Santoso">
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password (opsional)</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                       placeholder="biarkan kosong jika tidak mengubah">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="ulangi password">
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.pegawai.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light h-100">
                <div class="card-body">
                    <h6 class="fw-bold d-flex align-items-center mb-2"><i class="bi bi-info-circle me-2"></i>Data Saat Ini</h6>
                    <ul class="text-muted small ps-3 mb-3">
                        <li>Username: {{ $pengguna->username }}</li>
                        <li>Nama: {{ $pengguna->nama ?? '-' }}</li>
                        <li>Dibuat: {{ optional($pengguna->created_at)->format('d M Y H:i') }}</li>
                    </ul>
                    <p class="text-muted small mb-0">Biarkan kolom password kosong jika tidak ingin mengubah kata sandi.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection