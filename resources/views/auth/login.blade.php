<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - e-Pustaka SMK Negeri 5</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* ========================================= */
        /* SISI KIRI: GAMBAR (TETAP SEPERTI ASLINYA) */
        /* ========================================= */
        .login-left {
            flex: 1;
            background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1500&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 40px;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(59, 130, 246, 0.7) 100%);
        }

        .left-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 500px;
            animation: slideRight 1s ease-out;
        }

        .left-content i.logo-big {
            font-size: 5rem;
            margin-bottom: 20px;
            text-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .left-content h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 15px; }
        .left-content p { font-size: 1.1rem; opacity: 0.9; line-height: 1.6; }

        /* ========================================= */
        /* SISI KANAN: BACKGROUND LEMBUT & MENYATU   */
        /* ========================================= */
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Gradasi warna abu kebiruan yang sangat lembut */
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            position: relative;
            padding: 40px;
        }

        /* Hiasan Pola Titik-titik Halus */
        .login-right::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(#cbd5e1 1.5px, transparent 1.5px);
            background-size: 25px 25px;
            opacity: 0.6;
        }

        /* Card Form Putih Bersih */
        .login-card {
            background: white;
            padding: 50px 45px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 2;
            border: 1px solid white;
            animation: slideLeft 1s ease-out;
        }

        .login-card h3 { font-weight: 800; color: #1e293b; margin-bottom: 5px; font-size: 1.8rem; }
        .login-card p.subtitle { color: #64748b; font-size: 0.95rem; margin-bottom: 30px; }

        .form-label { font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 8px; }
        
        .input-group-custom { position: relative; margin-bottom: 20px; }

        .input-group-custom i {
            position: absolute; left: 20px; top: 50%;
            transform: translateY(-50%); color: #94a3b8; font-size: 1.1rem; z-index: 5;
        }

        .form-control-custom {
            width: 100%; padding: 15px 20px 15px 50px;
            border-radius: 12px; border: 2px solid #e2e8f0;
            background: #f8fafc; font-size: 0.95rem; transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: #3b82f6; background: white;
            outline: none; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .btn-login {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white; border: none; border-radius: 12px;
            padding: 15px; font-weight: 700; font-size: 1rem; width: 100%;
            transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-3px); box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4); color: white;
        }

        .register-link { text-align: center; margin-top: 25px; font-size: 0.9rem; color: #64748b; }
        .register-link a { color: #3b82f6; font-weight: 700; text-decoration: none; transition: 0.3s; }
        .register-link a:hover { color: #1e3a8a; text-decoration: underline; }

        @keyframes slideRight { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes slideLeft { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }

        @media (max-width: 900px) {
            .login-left { display: none; }
            .login-right { background: #f1f5f9; padding: 20px; }
            .login-card { padding: 40px 25px; }
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- SISI KIRI -->
    <div class="login-left">
        <div class="left-content">
            <i class="fas fa-book-reader logo-big"></i>
            <h1>e-Pustaka</h1>
            <p>Sistem Informasi Perpustakaan Digital SMK Negeri 5. Akses ribuan koleksi buku, kelola pinjaman, dan perluas wawasanmu dalam satu genggaman.</p>
        </div>
    </div>

    <!-- SISI KANAN -->
    <div class="login-right">
        <div class="login-card">
            <h3>Selamat Datang!</h3>
            <p class="subtitle">Silakan masuk ke akun Anda untuk melanjutkan.</p>

            @if (session('status'))
                <div class="alert alert-success mb-3" style="border-radius: 10px; font-size: 0.9rem;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger mb-3" style="border-radius: 10px; font-size: 0.9rem;">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Alamat Email</label>
                    <div class="input-group-custom">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control-custom" placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="form-control-custom" placeholder="Masukkan password Anda" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember" style="font-size: 0.85rem; color: #64748b;">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size: 0.85rem; color: #3b82f6; text-decoration: none; font-weight: 600;">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="btn-text"><i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang</span>
                </button>

                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('loginBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
        btn.disabled = true;
    });
</script>
</body>
</html>