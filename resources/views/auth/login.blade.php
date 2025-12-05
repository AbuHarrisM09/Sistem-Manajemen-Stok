<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login ke Sistem Manajemen Stok Jeje Katering">
    <title>Masuk • J Stok</title>

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --brand: #0d6efd;
            --brand-2: #20c997;
            --bg-1: #0ea5e9;
            --bg-2: #22c55e;
        }

        /* Background decorative */
        body {
            min-height: 100vh;
            background:
                radial-gradient(1200px 600px at -200px -200px, rgba(13,110,253,0.10), transparent 70%),
                radial-gradient(1200px 600px at 100% 120%, rgba(32,201,151,0.10), transparent 70%),
                linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
            display: grid;
            place-items: center;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding: 16px;
        }

        .auth-wrap {
            width: 100%;
            max-width: 980px;
        }

        .brand-card {
            background: linear-gradient(135deg, var(--bg-1) 0%, var(--bg-2) 100%);
            color: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(13,110,253,0.18);
            overflow: hidden;
        }

        .brand-card .left {
            padding: 32px 28px;
        }

        .brand-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1.8rem;
            letter-spacing: .5px;
        }

        .brand-title i {
            font-size: 1.9rem;
        }

        .brand-subtitle {
            margin-top: 8px;
            font-size: .95rem;
            opacity: .92;
        }

        .brand-highlights {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 16px;
        }

        .brand-highlights .item {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.28);
            color: #fff;
            padding: 8px 10px;
            border-radius: 10px;
            font-size: .9rem;
        }

        .brand-illustration {
            position: relative;
            min-height: 100%;
            background: radial-gradient(400px 200px at 60% 30%, rgba(255,255,255,0.25), transparent 60%);
        }

        /* Login card */
        .login-card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 8px 28px rgba(16,24,40,.12);
            border: 1px solid #e6e9ef;
            overflow: hidden;
        }

        .login-header {
            padding: 20px 22px;
            border-bottom: 1px solid #eef1f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .login-header h2 {
            font-weight: 700;
            margin: 0;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .login-header .badge {
            font-size: .75rem;
        }

        .login-body {
            padding: 24px 22px;
        }

        .input-group-text {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
        }

        .form-control {
            border: 1px solid #cbd5e1;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 .2rem rgba(13,110,253,.15);
        }

        .btn-login {
            padding: 10px 14px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-2) 100%);
            border: none;
        }

        .btn-login:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        .muted-link {
            color: #64748b;
            text-decoration: none;
        }
        .muted-link:hover { color: var(--brand); }

        @media (max-width: 991.98px) {
            .brand-card { margin-bottom: 16px; }
        }
    </style>
</head>
<body>
    <div class="auth-wrap">
        <div class="row g-3">
            <!-- Left: Branding and highlights -->
            <div class="col-lg-6">
                <div class="brand-card h-100">
                    <div class="row g-0 h-100">
                        <div class="col-7 left">
                            <div class="brand-title">
                                <i class="bi bi-box-seam-fill"></i>
                                <span>J Stok</span>
                            </div>
                            <div class="brand-subtitle">Sistem Manajemen Stok • Jeje Katering</div>

                            <div class="brand-highlights">
                                <div class="item">
                                    <i class="bi bi-shield-check"></i>
                                    Role-based Access
                                </div>
                                <div class="item">
                                    <i class="bi bi-graph-up"></i>
                                    Dashboard & Charts
                                </div>
                                <div class="item">
                                    <i class="bi bi-box-arrow-in-down"></i>
                                    Transaksi Masuk/Keluar
                                </div>
                                <div class="item">
                                    <i class="bi bi-file-earmark-text"></i>
                                    Laporan Stok
                                </div>
                            </div>
                        </div>
                        <div class="col-5 brand-illustration d-none d-md-block d-lg-block">
                            <!-- Decorative illustration area -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Login -->
            <div class="col-lg-6">
                <div class="login-card">
                    <div class="login-header">
                        <h2><i class="bi bi-door-open"></i> Masuk</h2>
                        <span class="badge text-bg-light">Versi 1.0</span>
                    </div>
                    <div class="login-body">
                        @if ($errors->any())
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                                <div>{{ $errors->first() }}</div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text"
                                           class="form-control @error('username') is-invalid @enderror"
                                           id="username"
                                           name="username"
                                           value="{{ old('username') }}"
                                           required
                                           autofocus
                                           autocomplete="username"
                                           placeholder="contoh: jeje_admin">
                                </div>
                                @error('username')
                                    <div class="small text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group" x-data>
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           required
                                           autocomplete="current-password"
                                           placeholder="••••••••">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="small text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                                <a href="#" class="muted-link small"><i class="bi bi-question-circle me-1"></i>Lupa password?</a>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-login">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                                </button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <small class="text-muted">Hak cipta © {{ date('Y') }} • J Stok</small>
                        </div>
                    </div>
                </div>

                <!-- Tips card -->
                <div class="card mt-3 border-0 shadow-sm">
                    <div class="card-body py-2 px-3">
                        <div class="small text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Tips: gunakan akun sesuai role (Admin atau Pegawai) untuk mengakses fitur yang tepat.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Minimal JS -->
    <script>
        // Toggle show/hide password
        document.getElementById('togglePassword')?.addEventListener('click', function () {
            const input = document.getElementById('password');
            const icon = this.querySelector('i');
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>