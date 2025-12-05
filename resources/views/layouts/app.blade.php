<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'J Stok')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 60px;
            --base-font-size: 14px;
            --heading-scale: 0.9;
            --btn-scale: 0.9;
            --table-font-size: 13px;
            --badge-font-size: 12px;
            --spacing-scale: 0.9;
        }

        html { font-size: var(--base-font-size); }
        body {
            margin: 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        /* Heading scale */
        h1 { font-size: calc(2.0rem * var(--heading-scale)); }
        h2 { font-size: calc(1.7rem * var(--heading-scale)); }
        h3 { font-size: calc(1.5rem * var(--heading-scale)); }
        h4 { font-size: calc(1.3rem * var(--heading-scale)); }
        h5 { font-size: calc(1.1rem * var(--heading-scale)); }
        h6 { font-size: calc(1.0rem * var(--heading-scale)); }

        /* Spacing scaling */
        .p-4 { padding: calc(1.5rem * var(--spacing-scale)) !important; }
        .py-3 { padding-top: calc(1rem * var(--spacing-scale)) !important; padding-bottom: calc(1rem * var(--spacing-scale)) !important; }
        .px-4 { padding-left: calc(1.5rem * var(--spacing-scale)) !important; padding-right: calc(1.5rem * var(--spacing-scale)) !important; }
        .mb-4 { margin-bottom: calc(1.5rem * var(--spacing-scale)) !important; }
        .my-4 { margin-top: calc(1.5rem * var(--spacing-scale)) !important; margin-bottom: calc(1.5rem * var(--spacing-scale)) !important; }
        .g-4 { gap: calc(1.5rem * var(--spacing-scale)) !important; }
        .g-3 { gap: calc(1rem * var(--spacing-scale)) !important; }

        /* Sidebar */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            height: 100vh; width: var(--sidebar-width);
            background: linear-gradient(180deg, #0d6efd 0%, #0a58ca 100%);
            box-shadow: 2px 0 15px rgba(0,0,0,0.1);
            transition: margin-left 0.3s ease;
            z-index: 1050;
            overflow-y: auto;
        }
        #sidebar.active { margin-left: calc(-1 * var(--sidebar-width)); }

        .sidebar-header { padding: calc(20px * var(--spacing-scale)); background: rgba(0,0,0,0.1); border-bottom: 1px solid rgba(255,255,255,0.15); }
        .sidebar-brand { color: #fff; font-size: 1.2rem; font-weight: 700; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .sidebar-brand i { font-size: 1.5rem; }

        .nav-item { margin: calc(4px * var(--spacing-scale)) 12px; }
        .nav-link { color: rgba(255,255,255,0.9); padding: calc(10px * var(--spacing-scale)) calc(16px * var(--spacing-scale)); border-radius: 10px; display: flex; align-items: center; gap: 10px; text-decoration: none; transition: all 0.2s ease; font-size: 0.95rem; }
        .nav-link:hover { background: rgba(255,255,255,0.2); color: #fff; }
        .nav-link.active { background: rgba(255,255,255,0.3); font-weight: 600; }

        .sidebar-footer { position: sticky; bottom: 0; padding: calc(14px * var(--spacing-scale)); background: rgba(0,0,0,0.1); border-top: 1px solid rgba(255,255,255,0.15); }

        /* Topbar */
        #topbar {
            position: fixed; top: 0; left: var(--sidebar-width); right: 0; height: var(--topbar-height);
            background: #fff; box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            z-index: 1040; transition: left 0.3s ease;
        }
        #topbar.active { left: 0; }
        .topbar-content { height: 100%; display: flex; align-items: center; justify-content: space-between; padding: 0 calc(18px * var(--spacing-scale)); }
        .sidebarCollapse { border: none; background: transparent; padding: calc(6px * var(--spacing-scale)) calc(8px * var(--spacing-scale)); border-radius: 8px; }
        .sidebarCollapse i { font-size: 1.2rem; }

        /* Content */
        #content { margin-left: var(--sidebar-width); margin-top: var(--topbar-height); padding: calc(22px * var(--spacing-scale)); min-height: calc(100vh - var(--topbar-height)); transition: margin-left 0.3s ease; }
        #content.active { margin-left: 0; }

        /* Buttons smaller */
        .btn-lg { font-size: calc(1rem * var(--btn-scale)); padding: calc(0.6rem * var(--spacing-scale)) calc(1.0rem * var(--spacing-scale)); }
        .btn { font-size: calc(0.95rem * var(--btn-scale)); }

        /* Table smaller */
        table.table { font-size: var(--table-font-size); }
        .table thead th { font-weight: 600; }

        /* Badge smaller */
        .badge { font-size: var(--badge-font-size); }

        /* Form controls smaller */
        .form-control-lg, .form-select-lg { font-size: 0.95rem; padding: calc(0.5rem * var(--spacing-scale)) calc(0.75rem * var(--spacing-scale)); }
        .form-control, .form-select { font-size: 0.9rem; }

        /* User dropdown */
        .user-dropdown .dropdown-toggle { display: flex; align-items: center; gap: 8px; color: #333; text-decoration: none; padding: calc(6px * var(--spacing-scale)) calc(10px * var(--spacing-scale)); border-radius: 8px; background: #f8f9fa; font-size: 0.95rem; }
        .user-badge { font-size: 10px; padding: 3px 7px; border-radius: 10px; }

        /* Overlay (mobile) */
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1045; }
        .sidebar-overlay.active { display: block; }

        /* Responsive */
        @media (max-width: 991.98px) {
            #sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            #sidebar.active { margin-left: 0; }
            #topbar { left: 0; }
            #content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            @if(auth('pengguna')->check() && auth('pengguna')->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>J Stok</span>
                </a>
            @else
                <a href="{{ route('pegawai.dashboard') }}" class="sidebar-brand">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>J Stok</span>
                </a>
            @endif
        </div>

        <div class="nav-section">
            <ul class="nav flex-column">
                @if(auth('pengguna')->check() && auth('pengguna')->user()->isAdmin())
                    <!-- Admin menu -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.bahan.index') }}" class="nav-link {{ request()->routeIs('admin.bahan.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i> <span>Data Bahan</span>
                        </a>
                    </li>
                @else
                    <!-- Pegawai menu -->
                    <li class="nav-item">
                        <a href="{{ route('pegawai.dashboard') }}" class="nav-link {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                        </a>
                    </li>
                @endif

                <!-- Shared menu (Admin & Pegawai) -->
                <li class="nav-item">
                    <a href="{{ route('transaksi.masuk') }}" class="nav-link {{ request()->routeIs('transaksi.masuk') ? 'active' : '' }}">
                        <i class="bi bi-arrow-down-circle"></i> <span>Stok Masuk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transaksi.keluar') }}" class="nav-link {{ request()->routeIs('transaksi.keluar') ? 'active' : '' }}">
                        <i class="bi bi-arrow-up-circle"></i> <span>Stok Keluar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-clock-history"></i> <span>Riwayat</span>
                    </a>
                </li>

                <!-- Laporan: hanya admin, aman jika route belum ada -->
                @if(auth('pengguna')->check() && auth('pengguna')->user()->isAdmin())
                    @if(\Illuminate\Support\Facades\Route::has('admin.laporan.index'))
                        <li class="nav-item">
                            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                                <i class="bi bi-file-earmark-text"></i> <span>Laporan</span>
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>

        <div class="sidebar-footer">
            <a href="{{ route('logout') }}" class="nav-link text-white"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> <span>Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </nav>

    <!-- Topbar -->
    <nav id="topbar">
        <div class="topbar-content">
            <button id="sidebarCollapse" class="sidebarCollapse" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            <div class="user-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span>{{ auth('pengguna')->user()->username ?? 'User' }}</span>
                        <span class="badge user-badge bg-primary">{{ auth('pengguna')->user()->isAdmin() ? 'Admin' : 'Pegawai' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const topbar = document.getElementById('topbar');
        const sidebarCollapse = document.getElementById('sidebarCollapse');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        sidebarCollapse.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
            topbar.classList.toggle('active');

            if (window.innerWidth <= 992) {
                sidebarOverlay.classList.toggle('active');
            }
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('active');
            content.classList.remove('active');
            topbar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
                sidebarOverlay.classList.remove('active');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>