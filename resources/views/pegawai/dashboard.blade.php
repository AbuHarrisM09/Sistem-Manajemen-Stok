<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - J Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">J Stok</span>
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-white text-decoration-none">
                Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">📊 Pantau Status Stok</h2>
                <a href="{{ route('transaksi.masuk') }}" class="btn btn-success btn-sm me-2">📥 Stok Masuk</a>
        <a href="{{ route('transaksi.keluar') }}" class="btn btn-danger btn-sm">📤 Stok Keluar</a>
        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>Nama Bahan</th>
                        <th>Satuan</th>
                        <th>Stok Saat Ini</th>
                        <th>Status</th>
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
                            <td>{{ $bahan->nama_bahan }}</td>
                            <td>{{ $bahan->satuan }}</td>
                            <td>{{ $stok }}</td>
                            <td><span class="badge {{ $badgeClass }} px-3 py-2">{{ ucfirst($status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data bahan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>