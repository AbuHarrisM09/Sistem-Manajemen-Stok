<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login ke Sistem Manajemen Stok Jeje Katering">
    <title>Masuk • J Stok</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --card-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 360px;
            height: 360px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            top: -180px;
            right: -180px;
            animation: float 20s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -110px;
            left: -110px;
            animation: float 15s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, -30px); }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .auth-container {
            width: 100%;
            max-width: 760px;
            position: relative;
            z-index: 1;
            animation: scaleIn 0.5s ease-out;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .brand-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.95) 0%, rgba(118, 75, 162, 0.95) 100%);
            padding: 30px 28px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .brand-section::before {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
            top: -90px;
            right: -90px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            position: relative;
        }

        .brand-logo-icon {
            width: 52px;
            height: 52px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .brand-title {
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .brand-subtitle {
            font-size: 0.92rem;
            opacity: 0.9;
            margin-bottom: 16px;
            font-weight: 500;
        }

        .brand-subtitle {
            margin-bottom: 10px;
        }

        .login-section {
            padding: 30px 28px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-header h2 {
            font-size: 1.45rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .login-header p {
            color: #64748b;
            font-size: 0.88rem;
        }

        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 6px;
            font-size: 0.88rem;
        }

        .form-control,
        .input-group-text {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 11px 12px;
            font-size: 0.88rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .input-group-text {
            background: #f8fafc;
            color: #64748b;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .input-group .input-group-text {
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .btn-toggle-password {
            border: 2px solid #e2e8f0;
            border-left: none;
            border-radius: 0 10px 10px 0;
            background: #f8fafc;
            color: #64748b;
            padding: 11px 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-toggle-password:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .btn-login {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-size: 0.92rem;
            font-weight: 700;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.22);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 24px;
            animation: slideUp 0.4s ease;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .text-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .text-link:hover {
            color: #5568d3;
            text-decoration: underline;
        }

        .footer-note {
            margin-top: 20px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 12px;
            text-align: center;
        }

        .footer-note i {
            color: #667eea;
        }

        @media (max-width: 991.98px) {
            .brand-section,
            .login-section {
                padding: 26px 22px;
            }

            .brand-title {
                font-size: 1.55rem;
            }

            .feature-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .login-header h2 {
                font-size: 1.42rem;
            }
        }

        @media (max-width: 575.98px) {
            body {
                padding: 8px;
            }

            .brand-section,
            .login-section {
                padding: 20px 16px;
            }

            .brand-logo-icon {
                width: 48px;
                height: 48px;
                font-size: 1.5rem;
            }

            .brand-title {
                font-size: 1.5rem;
            }

            .feature-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            .login-header h2 {
                font-size: 1.3rem;
            }
            .login-header p {
                font-size: 0.86rem;
            }
            .form-control,
            .input-group-text,
            .btn-toggle-password {
                padding: 10px 11px;
                font-size: 0.86rem;
            }
            .btn-login {
                padding: 11px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="row g-0">
                <!-- Brand Section -->
                <div class="col-lg-5">
                    <div class="brand-section h-100 d-flex flex-column justify-content-center">
                        <div class="brand-logo mb-2">
                            <div class="brand-logo-icon">
                                <i class="bi bi-box-seam-fill"></i>
                            </div>
                            <div>
                                <div class="brand-title">J Stok</div>
                            </div>
                        </div>
                        <div class="brand-subtitle">
                            Sistem Manajemen Stok
                        </div>
                    </div>
                </div>

                <!-- Login Section -->
                <div class="col-lg-7">
                    <div class="login-section">
                        <div class="login-header">
                            <h2>Selamat Datang!</h2>
                            <p>Masuk ke akun Anda untuk melanjutkan</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="bi bi-exclamation-circle-fill me-3 fs-4"></i>
                                <div>
                                    <strong>Oops!</strong> {{ $errors->first() }}
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control @error('username') is-invalid @enderror"
                                           id="username"
                                           name="username"
                                           value="{{ old('username') }}"
                                           required
                                           autofocus
                                           autocomplete="username"
                                           placeholder="Masukkan username Anda">
                                </div>
                                @error('username')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           required
                                           autocomplete="current-password"
                                           placeholder="Masukkan password Anda">
                                    <button type="button" class="btn-toggle-password" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>



                            <button type="submit" class="btn btn-login">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                            </button>
                        </form>
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                © {{ date('Y') }} J Stok. All rights reserved.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword')?.addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.animation = 'slideUp 0.4s ease reverse';
                    setTimeout(() => alert.remove(), 400);
                }, 5000);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>