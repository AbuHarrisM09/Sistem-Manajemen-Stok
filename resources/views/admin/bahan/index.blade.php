@extends('layouts.app')

@section('title', 'Data Bahan - J Stok')

@section('content')
<<<<<<< HEAD
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Kembali</a>
        <h2>📦 Data Bahan</h2>
        <a href="{{ route('admin.bahan.create') }}" class="btn btn-primary">+ Tambah Bahan</a>
=======
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-3">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h2 class="fw-bold mb-1" style="font-size:1.3rem;">
                        <i class="bi bi-box-seam me-2 text-primary"></i>Data Bahan
                    </h2>
                    <p class="text-muted mb-0" style="font-size:.9rem;">Kelola data bahan inventori</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.bahan.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Bahan
                    </a>
                </div>
            </div>
        </div>
>>>>>>> 88b69662b81f682f7c0623f0271e0531d2552ffc
    </div>

    <!-- Toolbar: search + filter -->
    <div class="row mb-3">
        <div class="col">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <form class="row g-2 align-items-center" method="GET" action="">
                        <div class="col-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                                <input
                                    type="text"
                                    name="q"
                                    value="{{ request('q') }}"
                                    class="form-control"
                                    placeholder="Cari nama bahan..."
                                >
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <select name="filter_satuan" class="form-select">
                                <option value="">Semua satuan</option>
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
                        <div class="col-6 col-md-3 d-grid">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="bi bi-funnel me-1"></i>Terapkan
                            </button>
                        </div>
                    </form>

                    @if(request()->has('q') || request()->has('filter_satuan'))
                        <div class="mt-2">
                            <span class="badge bg-light text-dark me-1">
                                <i class="bi bi-filter me-1"></i>Filter aktif
                            </span>
                            @if(request('q'))
                                <span class="badge bg-primary me-1">Kata kunci: "{{ request('q') }}"</span>
                            @endif
                            @if(request('filter_satuan'))
                                <span class="badge bg-secondary">Satuan: {{ strtoupper(request('filter_satuan')) }}</span>
                            @endif
                            <a href="{{ route('admin.bahan.index') }}" class="btn btn-link btn-sm ms-2 p-0 align-baseline">
                                Reset
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3 py-2">Nama Bahan</th>
                            <th class="py-2">Satuan</th>
                            <th class="py-2">Stok Minimum</th>
                            <th class="py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(
                            collect($bahans)
                                ->when(request('q'), fn($c) => $c->filter(fn($b) => str($b->nama_bahan)->lower()->contains(str(request('q'))->lower())))
                                ->when(request('filter_satuan'), fn($c) => $c->where('satuan', request('filter_satuan')))
                        as $bahan)
                            <tr>
                                <td class="px-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-tag text-primary"></i>
                                        <div>
                                            <strong>{{ $bahan->nama_bahan }}</strong>
                                            <div class="text-muted small">
                                                ID: {{ $bahan->id_bahan }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ strtoupper($bahan->satuan) }}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $bahan->stok_minimum }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.bahan.edit', $bahan) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </a>
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#more-{{ $bahan->id_bahan }}">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <form action="{{ route('admin.bahan.destroy', $bahan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus {{ $bahan->nama_bahan }}?')">
                                                <i class="bi bi-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>

                                    <!-- More details collapse -->
                                    <div class="collapse mt-2 text-start" id="more-{{ $bahan->id_bahan }}">
                                        <div class="card card-body py-2">
                                            <div class="small text-muted">
                                                Dibuat: {{ optional($bahan->created_at)->format('d M Y, H:i') ?? '-' }}<br>
                                                Diperbarui: {{ optional($bahan->updated_at)->format('d M Y, H:i') ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    <p class="mb-0">Belum ada data bahan.</p>
                                    <a href="{{ route('admin.bahan.create') }}" class="btn btn-primary mt-3">
                                        <i class="bi bi-plus-circle me-1"></i>Tambah Bahan Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer summary -->
            <div class="px-3 py-2 bg-light border-top d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Total bahan: <strong>{{ collect($bahans)->count() }}</strong>
                    @if(request('q') || request('filter_satuan'))
                        | Hasil filter: <strong>{{ collect($bahans)
                            ->when(request('q'), fn($c) => $c->filter(fn($b) => str($b->nama_bahan)->lower()->contains(str(request('q'))->lower())))
                            ->when(request('filter_satuan'), fn($c) => $c->where('satuan', request('filter_satuan')))
                            ->count() }}</strong>
                    @endif
                </div>
                <div>
                    <a href="{{ route('admin.bahan.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Tambah
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection