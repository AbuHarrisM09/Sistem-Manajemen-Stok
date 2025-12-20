@extends('layouts.app')

@section('title', 'Laporan Stok - J Stok')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-3">
        <div class="col">
            <h2 class="fw-bold mb-1">
                <i class="bi bi-file-earmark-text me-2 text-primary"></i>Laporan Stok Masuk & Keluar
            </h2>
            <p class="text-muted mb-0">Log aktivitas stok yang dikerjakan oleh pegawai</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Jenis Transaksi</label>
                    <select name="jenis_transaksi" class="form-select">
                        <option value="">Semua</option>
                        <option value="masuk" {{ request('jenis_transaksi') == 'masuk' ? 'selected' : '' }}>Stok Masuk</option>
                        <option value="keluar" {{ request('jenis_transaksi') == 'keluar' ? 'selected' : '' }}>Stok Keluar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pegawai</label>
                    <select name="id_pengguna" class="form-select">
                        <option value="">Semua Pegawai</option>
                        @foreach($penggunas as $pengguna)
                            <option value="{{ $pengguna->id_pengguna }}" {{ request('id_pengguna') == $pengguna->id_pengguna ? 'selected' : '' }}>
                                {{ $pengguna->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label d-block">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.laporan.export', request()->all()) }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export Semua ke Excel
                </a>
                <a href="{{ route('admin.laporan.export.masuk', request()->all()) }}" class="btn btn-outline-success">
                    <i class="bi bi-arrow-down-circle me-1"></i>Export Stok Masuk
                </a>
                <a href="{{ route('admin.laporan.export.keluar', request()->all()) }}" class="btn btn-outline-danger">
                    <i class="bi bi-arrow-up-circle me-1"></i>Export Stok Keluar
                </a>
            </div>
        </div>
    </div>

    <!-- Transaksi Table -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Daftar Transaksi</h5>
        </div>
        <div class="card-body p-0">
            @if($transaksis->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Tanggal</th>
                            <th>Nama Bahan</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Pegawai</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $index => $transaksi)
                        <tr>
                            <td>{{ $transaksis->firstItem() + $index }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $transaksi->bahan->nama_bahan ?? '-' }}</strong>
                            </td>
                            <td>
                                @if($transaksi->jenis_transaksi == 'masuk')
                                    <span class="badge bg-success">
                                        <i class="bi bi-arrow-down-circle me-1"></i>Masuk
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-arrow-up-circle me-1"></i>Keluar
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ number_format($transaksi->jumlah_bahan) }}</strong>
                                {{ $transaksi->bahan->satuan ?? '' }}
                            </td>
                            <td>
                                <i class="bi bi-person-circle me-1"></i>
                                {{ $transaksi->pengguna->nama ?? '-' }}
                                <small class="text-muted d-block">{{ $transaksi->pengguna->username ?? '' }}</small>
                            </td>
                            <td>{{ $transaksi->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-4 text-muted"></i>
                <p class="text-muted mt-2">Tidak ada data transaksi</p>
            </div>
            @endif
        </div>
        @if($transaksis->hasPages())
        <div class="card-footer bg-white">
            {{ $transaksis->links() }}
        </div>
        @endif
    </div>
</div>
@endsection