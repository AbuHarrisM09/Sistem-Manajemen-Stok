@extends('layouts.app')

@section('title', 'Tambah Bahan - J Stok')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.bahan.index') }}">Data Bahan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Bahan</li>
                </ol>
            </nav>
            <h2 class="fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Data Bahan</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.bahan.store') }}" method="POST" id="form-bahan">
                        @csrf
                        <div class="mb-4">
                            <label for="nama_bahan" class="form-label fw-bold">Nama Bahan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('nama_bahan') is-invalid @enderror"
                                   id="nama_bahan" name="nama_bahan" value="{{ old('nama_bahan') }}"
                                   placeholder="Contoh: Tepung Terigu" required>
                            @error('nama_bahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="satuan" class="form-label fw-bold">Satuan <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg @error('satuan') is-invalid @enderror" id="satuan" name="satuan" required>
                                <option value="" disabled {{ old('satuan') ? '' : 'selected' }}>Pilih satuan</option>
                                @foreach($units as $u)
                                    <option value="{{ $u }}" {{ old('satuan') === $u ? 'selected' : '' }}>{{ strtoupper($u) }}</option>
                                @endforeach
                                <option value="lainnya" {{ old('satuan') === 'lainnya' ? 'selected' : '' }}>Lainnya...</option>
                            </select>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4" id="wrap-satuan-lainnya" style="display: none;">
                            <label for="satuan_lainnya" class="form-label fw-bold">Satuan Kustom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('satuan_lainnya') is-invalid @enderror"
                                   id="satuan_lainnya" name="satuan_lainnya" value="{{ old('satuan_lainnya') }}"
                                   placeholder="Contoh: galon, roll">
                            <div class="form-text">Gunakan satuan yang belum ada di daftar.</div>
                            @error('satuan_lainnya')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="stok_minimum" class="form-label fw-bold">Stok Minimum <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-lg @error('stok_minimum') is-invalid @enderror"
                                   id="stok_minimum" name="stok_minimum" value="{{ old('stok_minimum', 0) }}"
                                   min="0" placeholder="0" required>
                            <div class="form-text">Batas minimal stok sebelum dianggap menipis.</div>
                            @error('stok_minimum')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('admin.bahan.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h5 class="card-title fw-bold"><i class="bi bi-info-circle me-2"></i>Informasi</h5>
                    <p class="small text-muted">Lengkapi form untuk menambahkan bahan baru ke dalam sistem inventori.</p>
                    <hr>
                    <ul class="small text-muted ps-3 mb-0">
                        <li class="mb-2">Gunakan dropdown satuan untuk konsistensi.</li>
                        <li class="mb-2">Pilih “Lainnya...” jika satuan belum tersedia.</li>
                        <li class="mb-2">Stok minimum digunakan untuk peringatan stok menipis.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const satuan = document.getElementById('satuan');
    const wrap = document.getElementById('wrap-satuan-lainnya');
    const custom = document.getElementById('satuan_lainnya');
    const lainnya = 'lainnya';

    const toggleCustom = () => {
        const show = satuan.value === lainnya;
        wrap.style.display = show ? 'block' : 'none';
        custom.required = show;
    };

    toggleCustom();
    satuan.addEventListener('change', toggleCustom);
});
</script>
@endpush
@endsection