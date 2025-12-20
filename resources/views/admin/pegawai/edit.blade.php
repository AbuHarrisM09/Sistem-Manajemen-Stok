@extends('layouts.app')

@section('title', 'Edit Pegawai - J Stok')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col d-flex justify-content-between align-items-center">
            <h2 class="fw-bold mb-0" style="font-size:1.25rem;">
                <i class="bi bi-person-gear me-2 text-primary"></i>Edit Pegawai
            </h2>
            <a href="{{ route('admin.pegawai.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.pegawai.update', $pengguna) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                           value="{{ old('username', $pengguna->username) }}" required>
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama', $pengguna->nama) }}" placeholder="contoh: Budi Santoso">
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password (opsional)</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="biarkan kosong jika tidak mengubah">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="ulangi password">
                </div>

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
@endsection