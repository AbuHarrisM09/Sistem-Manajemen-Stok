@extends('layouts.app')

@section('title', 'Data Bahan - J Stok')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <div>
                        <h2 class="fw-bold mb-1 d-flex align-items-center">
                            <i class="bi bi-box-seam me-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 2rem;"></i>
                            Data Bahan
                        </h2>
                        <p class="text-muted mb-0 small">Kelola data bahan stok dengan mudah</p>
                    </div>
                </div>
                <a href="{{ route('admin.bahan.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Bahan
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form class="row g-3 align-items-end" method="GET" action="">
                        <div class="col-md-5">
                            <label class="form-label fw-semibold small text-muted">
                                <i class="bi bi-search me-1"></i>Pencarian
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="Cari nama bahan...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small text-muted">
                                <i class="bi bi-filter me-1"></i>Satuan
                            </label>
                            <select name="filter_satuan" class="form-select">
                                <option value="">Semua Satuan</option>
                                @php
                                    $uniqueUnits = collect($bahans)->pluck('satuan')->unique()->sort()->values();
                                @endphp
                                @foreach($uniqueUnits as $unit)
                                    <option value="{{ $unit }}" {{ request('filter_satuan') === $unit ? 'selected' : '' }}>
                                        {{ strtoupper($unit) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            @if(request()->has('q') || request()->has('filter_satuan'))
                                <a href="{{ route('admin.bahan.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-x-circle me-1"></i>Reset
                                </a>
                            @endif
                        </div>
                    </form>

                    @if(request()->has('q') || request()->has('filter_satuan'))
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-funnel me-1"></i>Filter Aktif:
                                </span>
                                @if(request('q'))
                                    <span class="badge bg-primary">
                                        Kata kunci: "{{ request('q') }}"
                                    </span>
                                @endif
                                @if(request('filter_satuan'))
                                    <span class="badge bg-secondary">
                                        Satuan: {{ strtoupper(request('filter_satuan')) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                <div>{{ $errors->first('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-table me-2 text-primary"></i>Daftar Bahan
                </h5>
                <div class="text-muted small">
                    Total: <span class="badge bg-primary">{{ collect($bahans)->count() }}</span>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 modern-table">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">
                                <i class="bi bi-box-seam me-2"></i>Nama Bahan
                            </th>
                            <th class="py-3">
                                <i class="bi bi-rulers me-2"></i>Satuan
                            </th>
                            <th class="py-3">
                                <i class="bi bi-graph-down me-2"></i>Stok Minimum
                            </th>
                            <th class="py-3 text-center">
                                <i class="bi bi-gear me-2"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(
                            collect($bahans)
                                ->when(request('q'), fn($c) => $c->filter(fn($b) => str($b->nama_bahan)->lower()->contains(str(request('q'))->lower())))
                                ->when(request('filter_satuan'), fn($c) => $c->where('satuan', request('filter_satuan')))
                        as $bahan)
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="icon-wrapper" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); padding: 12px; border-radius: 12px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.3rem;"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block">{{ $bahan->nama_bahan }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border" style="font-size: 0.85rem; padding: 6px 12px;">
                                        {{ strtoupper($bahan->satuan) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info" style="font-size: 0.85rem; padding: 6px 12px;">
                                        {{ $bahan->stok_minimum }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.bahan.edit', $bahan) }}" class="btn btn-outline-warning btn-icon" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-info btn-icon" data-bs-toggle="collapse" data-bs-target="#detail-{{ $bahan->id_bahan }}" title="Detail">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                        <form action="{{ route('admin.bahan.destroy', $bahan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus bahan {{ $bahan->nama_bahan }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-icon" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Detail Collapse -->
                                    <div class="collapse mt-3" id="detail-{{ $bahan->id_bahan }}">
                                        <div class="card card-body bg-light border-0 shadow-sm text-start">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Dibuat</small>
                                                    <small class="fw-semibold">{{ optional($bahan->created_at)->format('d/m/Y H:i') ?? '-' }}</small>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Diperbarui</small>
                                                    <small class="fw-semibold">{{ optional($bahan->updated_at)->format('d/m/Y H:i') ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-inbox" style="font-size: 4rem; opacity: 0.2; display: block; margin-bottom: 1rem;"></i>
                                        <p class="text-muted mb-3">Belum ada data bahan</p>
                                        <a href="{{ route('admin.bahan.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>Tambah Bahan Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer with Summary -->
        <div class="card-footer bg-light border-0 py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-muted small">
                    <i class="bi bi-stack me-1"></i>
                    Total: <strong class="text-dark">{{ collect($bahans)->count() }}</strong> bahan
                    @if(request('q') || request('filter_satuan'))
                        <span class="mx-2">|</span>
                        Hasil filter: <strong class="text-primary">{{ collect($bahans)
                            ->when(request('q'), fn($c) => $c->filter(fn($b) => str($b->nama_bahan)->lower()->contains(str(request('q'))->lower())))
                            ->when(request('filter_satuan'), fn($c) => $c->where('satuan', request('filter_satuan')))
                            ->count() }}</strong>
                    @endif
                </div>
                <a href="{{ route('admin.bahan.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Bahan
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .modern-table thead tr {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    .modern-table thead th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #64748b;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .modern-table tbody tr:hover {
        background: #f8fafc;
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .btn-group .btn {
        transition: all 0.2s ease;
    }

    .btn-group .btn:hover {
        transform: translateY(-2px);
    }
</style>

@endsection