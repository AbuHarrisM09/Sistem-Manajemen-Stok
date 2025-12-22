<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'J Stok')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --topbar-height: 70px;
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-color: #667eea;
            --primary-dark: #5568d3;
            --secondary-color: #764ba2;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --dark-color: #1e293b;
            --light-bg: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition-base: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --border-radius: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 14px;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--light-bg);
            color: var(--dark-color);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        /* Sidebar */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.12);
            transition: var(--transition-base);
            z-index: 1050;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        #sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 200px;
            background: radial-gradient(circle at 50% 0%, rgba(102, 126, 234, 0.15), transparent 70%);
            pointer-events: none;
        }

        #sidebar.active {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }

        .sidebar-brand {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: var(--transition-base);
            letter-spacing: -0.5px;
        }

        .sidebar-brand:hover {
            transform: translateX(4px);
            color: #a5b4fc;
        }

        .sidebar-brand i {
            font-size: 2rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-section {
            flex: 1;
            overflow-y: auto;
            padding: 20px 0;
        }

        /* Keep sidebar list clean without default bullets */
        .nav-section ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .nav-section ul li {
            list-style: none;
        }

        .nav-section::-webkit-scrollbar {
            width: 4px;
        }

        .nav-section::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .nav-item {
            margin: 4px 16px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: var(--transition-base);
            font-size: 0.95rem;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 0;
            background: var(--primary-gradient);
            border-radius: 0 4px 4px 0;
            transition: var(--transition-base);
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(4px);
        }

        .nav-link:hover::before {
            height: 60%;
        }

        .nav-link.active {
            background: var(--primary-gradient);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .nav-link.active::before {
            height: 0;
        }

        .nav-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 20px 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
        }

        .sidebar-footer .nav-link {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
            margin: 0;
        }

        .sidebar-footer .nav-link:hover {
            background: #ef4444;
            color: #fff;
            transform: translateX(0);
        }

        /* Topbar */
        #topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            z-index: 1040;
            transition: var(--transition-base);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        #topbar.active {
            left: 0;
        }

        .topbar-content {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
        }

        .sidebarCollapse {
            border: none;
            background: #f8fafc;
            padding: 10px 14px;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition-base);
            color: var(--dark-color);
        }

        .sidebarCollapse:hover {
            background: var(--primary-gradient);
            color: #fff;
            transform: scale(1.05);
        }

        .sidebarCollapse i {
            font-size: 1.4rem;
            display: block;
        }

        /* User Dropdown */
        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--dark-color);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 12px;
            background: #f8fafc;
            transition: var(--transition-base);
            font-weight: 500;
            border: 2px solid transparent;
        }

        .user-dropdown .dropdown-toggle:hover {
            background: #fff;
            border-color: var(--primary-color);
            box-shadow: var(--card-shadow);
        }

        .user-dropdown .dropdown-toggle::after {
            margin-left: 4px;
        }

        .user-badge {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            background: var(--primary-gradient);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 8px;
            margin-top: 8px;
            min-width: 200px;
            animation: scaleIn 0.2s ease;
        }

        .dropdown-item {
            padding: 10px 16px;
            border-radius: 8px;
            transition: var(--transition-base);
            font-size: 0.95rem;
        }

        .dropdown-item:hover {
            background: var(--light-bg);
            color: var(--primary-color);
        }

        /* Content */
        #content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 24px;
            min-height: calc(100vh - var(--topbar-height));
            transition: var(--transition-base);
            animation: fadeIn 0.5s ease;
        }

        #content.active {
            margin-left: 0;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition-base);
            overflow: hidden;
            animation: slideIn 0.4s ease;
        }

        .card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-4px);
        }

        .card-header {
            background: #fff;
            border-bottom: 2px solid #f1f5f9;
            padding: 16px 20px;
            font-weight: 600;
        }

        .card-body {
            padding: 18px 20px;
        }

        /* Shared table & hover helpers */
        .modern-table thead tr {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .modern-table thead th {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.4px;
            color: #475569;
            border-bottom: 0;
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

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 24px -6px rgba(0, 0, 0, 0.12);
        }

        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .avatar {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        /* Buttons */
        .btn {
            padding: 9px 16px;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition-base);
            border: none;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: var(--primary-gradient);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
        }

        .btn-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-gradient);
            color: #fff;
            border-color: transparent;
        }

        .btn-outline-success {
            border: 2px solid var(--success-color);
            color: var(--success-color);
            background: transparent;
        }

        .btn-outline-success:hover {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            border-color: transparent;
        }

        /* Tables */
        .table {
            font-size: 0.9rem;
        }

        .table thead th {
            background: var(--light-bg);
            color: var(--dark-color);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 16px;
            border: none;
        }

        .table tbody tr {
            transition: var(--transition-base);
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover {
            background: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
        }

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 16px;
            transition: var(--transition-base);
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        /* Overlay (mobile) */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1045;
            animation: fadeIn 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
            border-radius: 8px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            :root {
                --sidebar-width: 260px;
            }
        }

        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                margin-left: 0;
            }

            #topbar {
                left: 0;
            }

            #content {
                margin-left: 0;
                padding: 20px;
            }
        }

        @media (max-width: 767.98px) {
            :root {
                --sidebar-width: 280px;
                --topbar-height: 60px;
            }

            html {
                font-size: 13px;
            }

            #content {
                padding: 16px;
            }

            .topbar-content {
                padding: 0 16px;
            }

            .card-body {
                padding: 16px;
            }
        }

        @media (max-width: 575.98px) {
            .user-dropdown .dropdown-toggle span:not(.badge) {
                display: none;
            }
        }

        /* Utility Classes */
        .gradient-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .shadow-sm-custom {
            box-shadow: var(--card-shadow);
        }

        .shadow-lg-custom {
            box-shadow: var(--card-shadow-hover);
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

                <!-- Laporan -->
                @if(auth('pengguna')->check() && auth('pengguna')->user()->isAdmin())
                    <li class="nav-item">
                        <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text"></i> <span>Laporan</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('pegawai.laporan.index') }}" class="nav-link {{ request()->routeIs('pegawai.laporan.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text"></i> <span>Laporan</span>
                        </a>
                    </li>
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
                        <li>
                            <a class="dropdown-item" href="{{ route('profil.edit') }}">
                                <i class="bi bi-person me-2"></i>Profile
                            </a>
                        </li>
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
        // Sidebar Toggle
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

        // Close sidebar on nav item click (mobile)
        if (window.innerWidth <= 992) {
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    sidebar.classList.add('active');
                    sidebarOverlay.classList.remove('active');
                });
            });
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading animation to buttons
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
                    
                    // Re-enable after 3 seconds as fallback
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 3000);
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe cards
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(card);
            });
        });

        // Toast notifications
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer') || createToastContainer();
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            setTimeout(() => toast.remove(), 5000);
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
            return container;
        }

        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.alert').forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>