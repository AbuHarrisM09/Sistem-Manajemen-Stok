@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1 d-flex align-items-center"><i class="bi bi-person-circle me-2 text-primary"></i>Profil Saya</h2>
                <p class="text-muted mb-0 small">Perbarui data akun dan password</p>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>Periksa kembali inputan Anda.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profil.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}">
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Baru (opsional)</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" placeholder="Biarkan kosong jika tidak mengubah">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle p-3" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                            <i class="bi bi-shield-lock text-white" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Keamanan Akun</h5>
                            <p class="mb-0 text-white text-opacity-75 small">Pastikan kredensial Anda aman</p>
                        </div>
                    </div>
                    <ul class="small mb-0 ps-3" style="line-height: 1.6;">
                        <li>Gunakan password yang berbeda dengan layanan lain.</li>
                        <li>Ganti password secara berkala untuk keamanan.</li>
                        <li>Jaga kerahasiaan kredensial Anda.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
