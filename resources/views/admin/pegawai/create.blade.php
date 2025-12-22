@extends('layouts.app')

@section('title', 'Tambah Pegawai - J Stok')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="fw-bold mb-1 d-flex align-items-center">
                        <i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah Pegawai
                    </h2>
                    <p class="text-muted mb-0 small">Buat akun baru untuk pegawai</p>
                </div>
                <a href="{{ route('admin.pegawai.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
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
                    <form action="{{ route('admin.pegawai.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                       value="{{ old('username') }}" placeholder="contoh: pegawai_budi" required>
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama') }}" placeholder="contoh: Budi Santoso">
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                       placeholder="min. 6 karakter" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="ulangi password" required>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Simpan
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
                    <h6 class="fw-bold d-flex align-items-center mb-2"><i class="bi bi-shield-check me-2"></i>Panduan</h6>
                    <ul class="text-muted small ps-3 mb-0">
                        <li>Gunakan username unik per pegawai.</li>
                        <li>Isi nama lengkap untuk laporan yang lebih jelas.</li>
                        <li>Password minimal 6 karakter untuk keamanan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection