@extends('layouts.app')

@section('title', 'Laporan Stok - J Stok')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); overflow:hidden;">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3 py-4">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-file-earmark-text text-white" style="font-size:2rem;"></i>
                        <div>
                            <h2 class="text-white fw-bold mb-1">Laporan Stok Masuk & Keluar</h2>
                            <p class="text-white text-opacity-75 mb-0 small">Riwayat transaksi stok harian</p>
                        </div>
                    </div>
                    @php
                        $totalTransaksi = method_exists($transaksis, 'total') ? $transaksis->total() : $transaksis->count();
                    @endphp
                    <div class="text-white text-end">
                        <p class="mb-1 small">Total Transaksi</p>
                        <h3 class="fw-bold mb-0">{{ $totalTransaksi }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="mb-0 fw-bold d-flex align-items-center"><i class="bi bi-funnel me-2 text-success"></i>Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('pegawai.laporan.index') }}" class="row g-3 align-items-end">
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
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                    @if(request()->anyFilled(['jenis_transaksi','id_pengguna','tanggal_dari','tanggal_sampai']))
                        <a href="{{ route('pegawai.laporan.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Transaksi Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold d-flex align-items-center"><i class="bi bi-table me-2 text-success"></i>Daftar Transaksi</h5>
            <span class="badge bg-light text-dark border">{{ $totalTransaksi }} transaksi</span>
        </div>
        <div class="card-body p-0">
            @if($transaksis->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle modern-table">
                    <thead>
                        <tr>
                            <th style="width: 70px;" class="px-4 py-3">No</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Nama Bahan</th>
                            <th class="py-3">Jenis</th>
                            <th class="py-3">Jumlah</th>
                            <th class="py-3">Pegawai</th>
                            <th class="py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $index => $transaksi)
                        <tr>
                            <td class="px-4">{{ $transaksis->firstItem() + $index }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}</td>
                            <td><strong>{{ $transaksi->bahan->nama_bahan ?? '-' }}</strong></td>
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
                                <span class="badge bg-info bg-opacity-10 text-info border border-info">
                                    {{ number_format($transaksi->jumlah_bahan) }} {{ $transaksi->bahan->satuan ?? '' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $transaksi->pengguna->nama ?? '-' }}</strong>
                                        <small class="text-muted d-block">{{ $transaksi->pengguna->username ?? '' }}</small>
                                    </div>
                                </div>
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
        <div class="card-footer bg-white border-0">
            {{ $transaksis->links() }}
        </div>
        @endif
    </div>
</div>
@endsection