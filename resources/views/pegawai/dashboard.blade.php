@extends('layouts.app')

@section('title', 'Dashboard Pegawai - J Stok')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-2">
        <div class="col">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div>
                    <h2 class="fw-bold mb-1" style="font-size:1.25rem;">
                        <i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard Pegawai
                    </h2>
                    <p class="text-muted mb-0" style="font-size:.9rem;">
                        <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                    </p>
                </div>
                <div class="text-muted" style="font-size:.9rem;">
                    <small>Hai, <strong>{{ auth('pengguna')->user()->username }}</strong> 👋</small>
                </div>
            </div>
        </div>
    </div>

    <!-- TOP ROW: Cards (kiri) + Chart (kanan) -->
    <div class="row g-2 mb-2 align-items-start">
        <!-- Kiri: 4 cards compact -->
        <div class="col-xl-8">
            <div class="row g-2">
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1 small text-uppercase">Total</p>
                                    <h3 class="fw-bold mb-0" style="font-size:1.15rem;">{{ $totalBahan }}</h3>
                                </div>
                                <i class="bi bi-box-seam text-primary" style="font-size:1.3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1 small text-uppercase">Aman</p>
                                    <h3 class="fw-bold text-success mb-0" style="font-size:1.15rem;">{{ $stokAman }}</h3>
                                </div>
                                <i class="bi bi-check-circle text-success" style="font-size:1.3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1 small text-uppercase">Menipis</p>
                                    <h3 class="fw-bold text-warning mb-0" style="font-size:1.15rem;">{{ $stokMenipis }}</h3>
                                </div>
                                <i class="bi bi-exclamation-triangle text-warning" style="font-size:1.3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1 small text-uppercase">Habis</p>
                                    <h3 class="fw-bold text-danger mb-0" style="font-size:1.15rem;">{{ $stokHabis }}</h3>
                                </div>
                                <i class="bi bi-x-circle text-danger" style="font-size:1.3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: Chart -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 fw-bold" style="font-size:1rem;">
                        <i class="bi bi-pie-chart me-2 text-primary"></i>Statistik Stok
                    </h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center py-2">
                    <div class="w-100" style="max-width:240px; aspect-ratio:1/1; margin:auto;">
                        <canvas id="pegawaiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat (khusus pegawai: hanya Masuk & Keluar) -->
    <div class="row g-2 mb-2">
        <div class="col-6 col-md-3">
            <a href="{{ route('transaksi.masuk') }}" class="btn btn-success w-100">
                <i class="bi bi-arrow-down-circle me-1"></i>Stok Masuk
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('transaksi.keluar') }}" class="btn btn-danger w-100">
                <i class="bi bi-arrow-up-circle me-1"></i>Stok Keluar
            </a>
        </div>
    </div>

    <!-- Tabel status stok -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 fw-bold" style="font-size:1rem;">
                        <i class="bi bi-table me-2 text-primary"></i>Status Stok Bahan
                    </h6>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const pegawaiCtx = document.getElementById('pegawaiChart');

    new Chart(pegawaiCtx, {
        type: 'doughnut',
        data: {
            labels: ['Aman', 'Menipis', 'Habis'],
            datasets: [{
                data: [{{ $stokAman }}, {{ $stokMenipis }}, {{ $stokHabis }}],
                backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                borderColor: ['#198754', '#ffc107', '#dc3545'],
                borderWidth: 2,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 8, font: { size: 11 } }
                },
                tooltip: {
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
            animation: { animateRotate: true, animateScale: true, duration: 700 },
            layout: { padding: 0 }
        }
    });
</script>
@endpush
@endsection