@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📤 Catat Stok Keluar</h2>
        <a href="{{ route('pegawai.dashboard') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first('jumlah_bahan') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('transaksi.keluar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Bahan <span class="text-danger">*</span></label>
                    <select name="id_bahan" class="form-select @error('id_bahan') is-invalid @enderror" required>
                        <option value="">Pilih Bahan</option>
                        @foreach($bahans as $bahan)
                            <option value="{{ $bahan->id_bahan }}" {{ old('id_bahan') == $bahan->id_bahan ? 'selected' : '' }}>
                                {{ $bahan->nama_bahan }} (Stok: {{ $bahan->stok_saat_ini }} {{ $bahan->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_bahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah_bahan" class="form-control @error('jumlah_bahan') is-invalid @enderror"
                           value="{{ old('jumlah_bahan') }}" min="1" required>
                    @error('jumlah_bahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                           value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('pegawai.dashboard') }}" class="btn btn-secondary me-md-2">Batal</a>
                    <button type="submit" class="btn btn-danger">Simpan Stok Keluar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection