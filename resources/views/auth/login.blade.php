<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login ke Sistem Manajemen Stok Jeje Katering">
    <title>Login - J Stok</title>

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .login-card {
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            border: none;
        }

        .login-header {
            background: linear-gradient(90deg, #4cc9f0, #4ade80);
            color: #0f172a;
            padding: 32px 24px;
            text-align: center;
        }

        .login-header h1 {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 4px;
        }

        .login-header p {
            opacity: 0.85;
            font-size: 0.95rem;
            margin: 0;
        }

        .login-body {
            padding: 32px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #1e293b;
        }

        .input-group-text {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
        }

        .btn-login {
            padding: 12px;
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.25s ease;
            background: linear-gradient(90deg, #2ecc71, #1abc9c);
            border: none;
            color: white;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.3);
            background: linear-gradient(90deg, #1abc9c, #2ecc71);
        }

        .form-control:focus {
            border-color: #2ecc71;
            box-shadow: 0 0 0 0.25rem rgba(46, 204, 113, 0.2);
        }

        .alert {
            border: none;
            border-radius: 8px;
        }

        @media (max-width: 576px) {
            .login-body {
                padding: 24px;
            }

            .login-header {
                padding: 24px 16px;
            }

            .login-card {
                margin: 0 -12px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card login-card">
                    <div class="login-header">
                        <h1>J Stok</h1>
                        <p>Sistem Manajemen Stok • Jeje Katering</p>
                    </div>
                    <div class="login-body">
                        @if ($errors->any())
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                                <div>{{ $errors->first('username') }}</div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username') }}" required autofocus
                                        autocomplete="username">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-login">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>