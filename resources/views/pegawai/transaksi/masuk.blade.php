@extends('layouts.app')

@section('title', 'Stok Masuk - J Stok')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1 d-flex align-items-center">
                    <span class="rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                        <i class="bi bi-arrow-down-circle text-white"></i>
                    </span>
                    Catat Stok Masuk
                </h2>
                <p class="text-muted mb-0 small">Input penerimaan bahan dan catat stok terbaru</p>
            </div>
            @php $backRoute = auth('pengguna')->user()?->isAdmin() ? 'admin.dashboard' : 'pegawai.dashboard'; @endphp
            <a href="{{ route($backRoute) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3">
        <!-- Form Stok Masuk -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header text-white border-0 py-3" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>Form Stok Masuk</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.masuk') }}" method="POST">
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
                            <a href="{{ route($backRoute) }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ringkasan stok untuk referensi -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold d-flex align-items-center">
                        <span class="rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                            <i class="bi bi-list-check text-white"></i>
                        </span>
                        Ringkasan Stok
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 modern-table">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3">Nama Bahan</th>
                                    <th class="py-3">Satuan</th>
                                    <th class="py-3">Stok Saat Ini</th>
                                    <th class="py-3">Status</th>
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
                                        <td class="px-4"><strong>{{ $bahan->nama_bahan }}</strong></td>
                                        <td><span class="badge bg-light text-dark">{{ strtoupper($bahan->satuan) }}</span></td>
                                        <td><span class="badge bg-info bg-opacity-10 text-info border border-info">{{ $stok }}</span></td>
                                        <td><span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox fs-1 d-block mb-2" style="opacity:0.3;"></i>
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