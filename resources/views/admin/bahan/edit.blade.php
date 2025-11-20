@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>✏️ Edit Data Bahan</h2>
        <a href="{{ route('admin.bahan.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.bahan.update', $bahan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_bahan" class="form-label">Nama Bahan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_bahan') is-invalid @enderror"
                           id="nama_bahan" name="nama_bahan" value="{{ old('nama_bahan', $bahan->nama_bahan) }}" required>
                    @error('nama_bahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('satuan') is-invalid @enderror"
                           id="satuan" name="satuan" value="{{ old('satuan', $bahan->satuan) }}" required>
                    @error('satuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="stok_minimum" class="form-label">Stok Minimum <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('stok_minimum') is-invalid @enderror"
                           id="stok_minimum" name="stok_minimum" value="{{ old('stok_minimum', $bahan->stok_minimum) }}" min="0" required>
                    @error('stok_minimum')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.bahan.index') }}" class="btn btn-secondary me-md-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection