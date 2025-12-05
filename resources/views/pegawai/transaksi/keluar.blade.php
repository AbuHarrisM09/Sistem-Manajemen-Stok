@extends('layouts.app')

@section('title', 'Stok Keluar - J Stok')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col d-flex justify-content-between align-items-center">
            <h2 class="fw-bold mb-0" style="font-size:1.25rem;"><i class="bi bi-arrow-up-circle me-2 text-danger"></i>Catat Stok Keluar</h2>
            <a href="{{ route('pegawai.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first('jumlah_bahan') ?? $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-2">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white border-0 py-2">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-dash-circle me-2"></i>Form Stok Keluar</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.keluar.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Bahan <span class="text-danger">*</span></label>
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
                            <label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_bahan" class="form-control @error('jumlah_bahan') is-invalid @enderror"
                                   value="{{ old('jumlah_bahan') }}" min="1" required>
                            @error('jumlah_bahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('pegawai.dashboard') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-save me-1"></i>Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ringkas: daftar bahan & stok untuk referensi -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-list-check me-2"></i>Ringkasan Stok</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-3 py-2">Nama Bahan</th>
                                    <th class="py-2">Satuan</th>
                                    <th class="py-2">Stok Saat Ini</th>
                                    <th class="py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bahans as $bahan)
                                    @php
                                        $stok = $bahan->stok_saat_ini;
                                        $status = $bahan->status_stok;
                                        $badgeClass = match($status) {
                                            'habis' => 'bg-danger',
                                            'menipis' => 'bg-warning text-dark',
                                            default => 'bg-success'
                                        };
                                    @endphp
                                    <tr>
                                        <td class="px-3"><strong>{{ $bahan->nama_bahan }}</strong></td>
                                        <td><span class="badge bg-light text-dark">{{ strtoupper($bahan->satuan) }}</span></td>
                                        <td><span class="badge bg-info bg-opacity-10 text-info border border-info">{{ $stok }}</span></td>
                                        <td><span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                            Belum ada data bahan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection