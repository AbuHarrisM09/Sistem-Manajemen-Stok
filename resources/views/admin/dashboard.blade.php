@extends('layouts.app')

@section('title', 'Dashboard Admin - J Stok')

@section('content')
<div class="container-fluid">
    <!-- Header Section with Gradient -->
    <div class="row mb-2">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); overflow: hidden; position: relative;">
                <div style="position: absolute; top: 0; right: 0; width: 150px; height: 150px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); border-radius: 50%; transform: translate(20%, -40%);"></div>
                <div class="card-body py-2 position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                                    <i class="bi bi-speedometer2 text-white" style="font-size: 1.35rem;"></i>
                                </div>
                                <div>
                                    <h2 class="text-white fw-bold mb-1" style="font-size: 1.48rem;">Dashboard Admin</h2>
                                    <p class="text-white text-opacity-75 mb-0">
                                        <i class="bi bi-calendar3 me-2"></i>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="bg-white bg-opacity-25 rounded-3 px-3 py-2 d-inline-block">
                                <p class="text-white text-opacity-75 mb-1 small">Selamat datang,</p>
                                <h5 class="text-white fw-bold mb-0" style="font-size: 0.92rem;">{{ auth('pengguna')->user()->nama ?? auth('pengguna')->user()->username }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions dengan Gradient Buttons -->
    <div class="row g-3 mb-3">
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.bahan.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center py-2">
                        <div class="icon-box mb-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 44px; height: 44px; margin: 0 auto; border-radius: 11px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-plus-circle text-white" style="font-size: 1.3rem;"></i>
                        </div>
                        <h6 class="fw-bold mb-1">Tambah Bahan</h6>
                        <p class="text-muted small mb-0">Tambah data bahan baru</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.bahan.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center py-2">
                        <div class="icon-box mb-2" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); width: 44px; height: 44px; margin: 0 auto; border-radius: 11px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-box-seam text-white" style="font-size: 1.3rem;"></i>
                        </div>
                        <h6 class="fw-bold mb-1">Kelola Bahan</h6>
                        <p class="text-muted small mb-0">Manajemen data bahan</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.pegawai.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center py-2">
                        <div class="icon-box mb-2" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); width: 44px; height: 44px; margin: 0 auto; border-radius: 11px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-person-plus-fill text-white" style="font-size: 1.3rem;"></i>
                        </div>
                        <h6 class="fw-bold mb-1">Tambah Pegawai</h6>
                        <p class="text-muted small mb-0">Tambah data pegawai</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.pegawai.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center py-2">
                        <div class="icon-box mb-2" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); width: 44px; height: 44px; margin: 0 auto; border-radius: 11px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-people-fill text-white" style="font-size: 1.3rem;"></i>
                        </div>
                        <h6 class="fw-bold mb-1">Kelola Pegawai</h6>
                        <p class="text-muted small mb-0">Manajemen pegawai</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Stats Cards dan Chart -->
    <div class="row g-3 mb-4">
        <!-- Stats Cards -->
        <div class="col-lg-8">
            <div class="row g-3">
                <!-- Total Bahan -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted text-uppercase small fw-bold mb-2" style="letter-spacing: 0.5px;">Total Bahan</p>
                                    <h2 class="fw-bold mb-2" style="font-size: 1.6rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $totalBahan }}</h2>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-graph-up text-success me-1"></i>
                                        Total item terdaftar
                                    </p>
                                </div>
                                <div class="icon-wrapper" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); padding: 8px; border-radius: 12px;">
                                    <i class="bi bi-box-seam" style="font-size: 1.55rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stok Aman -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted text-uppercase small fw-bold mb-2" style="letter-spacing: 0.5px;">Stok Aman</p>
                                    <h2 class="fw-bold mb-2" style="font-size: 1.6rem; color: #10b981;">{{ $stokAman }}</h2>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-shield-check text-success me-1"></i>
                                        Kondisi optimal
                                    </p>
                                </div>
                                <div class="icon-wrapper" style="background: rgba(16, 185, 129, 0.1); padding: 8px; border-radius: 12px;">
                                    <i class="bi bi-check-circle text-success" style="font-size: 1.55rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stok Menipis -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted text-uppercase small fw-bold mb-2" style="letter-spacing: 0.5px;">Stok Menipis</p>
                                    <h2 class="fw-bold mb-2" style="font-size: 1.6rem; color: #f59e0b;">{{ $stokMenipis }}</h2>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-exclamation-circle text-warning me-1"></i>
                                        Perlu perhatian
                                    </p>
                                </div>
                                <div class="icon-wrapper" style="background: rgba(245, 158, 11, 0.1); padding: 8px; border-radius: 12px;">
                                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 1.55rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stok Habis -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted text-uppercase small fw-bold mb-2" style="letter-spacing: 0.5px;">Stok Habis</p>
                                    <h2 class="fw-bold mb-2" style="font-size: 1.6rem; color: #ef4444;">{{ $stokHabis }}</h2>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-x-circle text-danger me-1"></i>
                                        Segera restok
                                    </p>
                                </div>
                                <div class="icon-wrapper" style="background: rgba(239, 68, 68, 0.1); padding: 8px; border-radius: 12px;">
                                    <i class="bi bi-x-circle text-danger" style="font-size: 1.55rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pegawai -->
            @isset($totalPegawai)
            <div class="row g-3 mt-0">
                <div class="col-12">
                    <div class="card border-0 shadow-sm hover-scale">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                        <div class="icon-wrapper me-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 10px; border-radius: 12px;">
                                            <i class="bi bi-people-fill text-white" style="font-size: 1.6rem;"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing: 0.5px;">Total Pegawai</p>
                                            <h3 class="fw-bold mb-0" style="font-size: 1.5rem; color: #10b981;">{{ $totalPegawai }}</h3>
                                    </div>
                                </div>
                                <a href="{{ route('admin.pegawai.index') }}" class="btn btn-outline-success btn-sm">
                                    Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endisset
        </div>

        <!-- Chart -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-pie-chart-fill me-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.3rem;"></i>
                        Statistik Status Stok
                    </h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center py-3">
                    <div class="w-100" style="max-width: 240px;">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3">
                    <div class="row text-center g-0">
                        <div class="col-4">
                            <div class="p-2">
                                <div class="d-inline-block" style="width: 12px; height: 12px; background: #10b981; border-radius: 50%;"></div>
                                <p class="small text-muted mb-0 mt-1">Aman</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2">
                                <div class="d-inline-block" style="width: 12px; height: 12px; background: #f59e0b; border-radius: 50%;"></div>
                                <p class="small text-muted mb-0 mt-1">Menipis</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2">
                                <div class="d-inline-block" style="width: 12px; height: 12px; background: #ef4444; border-radius: 50%;"></div>
                                <p class="small text-muted mb-0 mt-1">Habis</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Link Laporan -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('admin.laporan.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm hover-lift" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                                    <i class="bi bi-file-earmark-text text-white" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h6 class="text-white fw-bold mb-1">Lihat Laporan & Log Stok</h6>
                                    <p class="text-white text-opacity-75 mb-0 small">Akses laporan lengkap dan riwayat transaksi stok</p>
                                </div>
                            </div>
                            <i class="bi bi-arrow-right-circle text-white" style="font-size: 1.6rem;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Tabel Status Stok -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="bi bi-table me-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.3rem;"></i>
                            <span style="font-size: 1.05rem;">Status Stok Bahan</span>
                        </h5>
                        <a href="{{ route('admin.bahan.index') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-box-seam me-1"></i>Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 modern-table">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3">Nama Bahan</th>
                                    <th class="py-3">Satuan</th>
                                    <th class="py-3">Stok Saat Ini</th>
                                    <th class="py-3">Stok Minimum</th>
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
                                        $iconClass = match($status) {
                                            'habis' => 'bi-x-circle',
                                            'menipis' => 'bi-exclamation-triangle',
                                            default => 'bi-check-circle'
                                        };
                                        $statusText = match($status) {
                                            'habis' => 'Habis',
                                            'menipis' => 'Menipis',
                                            default => 'Aman'
                                        };
                                    @endphp
                                    <tr>
                                        <td class="px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-wrapper me-2" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); padding: 6px; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 0.95rem;"></i>
                                                </div>
                                                <strong>{{ $bahan->nama_bahan }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $bahan->satuan }}</span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); font-size: 0.85rem; padding: 6px 10px;">
                                                {{ $stok }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted fw-medium">{{ $bahan->stok_minimum }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $badgeClass }}" style="font-size: 0.85rem; padding: 6px 14px;">
                                                <i class="bi {{ $iconClass }} me-1"></i>{{ $statusText }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                                <p class="mt-3 mb-0">Belum ada data bahan</p>
                                                <a href="{{ route('admin.bahan.create') }}" class="btn btn-primary btn-sm mt-3">
                                                    <i class="bi bi-plus-circle me-1"></i>Tambah Bahan Pertama
                                                </a>
                                            </div>
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

<style>
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
    }

    .hover-scale {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-scale:hover {
        transform: scale(1.02);
    }

    .modern-table thead tr {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: #f8fafc;
        transform: translateX(4px);
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('stockChart');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Aman', 'Menipis', 'Habis'],
            datasets: [{
                data: [{{ $stokAman }}, {{ $stokMenipis }}, {{ $stokHabis }}],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderColor: [
                    '#10b981',
                    '#f59e0b',
                    '#ef4444'
                ],
                borderWidth: 3,
                hoverOffset: 12,
                hoverBorderWidth: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const val = context.parsed;
                            const pct = total ? ((val / total) * 100).toFixed(1) : 0;
                            return `${context.label}: ${val} bahan (${pct}%)`;
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1000,
                easing: 'easeInOutQuart'
            },
            layout: {
                padding: 6
            }
        }
    });
</script>
@endpush

@endsection