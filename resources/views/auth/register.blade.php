<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - e-Pustaka SMK Negeri 5</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        .register-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* ========================================= */
        /* SISI KIRI: GAMBAR (TETAP SEPERTI ASLINYA) */
        /* ========================================= */
        .register-left {
            flex: 1;
            background-image: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1500&q=80');
            background-size: cover;
            background-position: center;
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 40px;
        }

        .register-left::before {
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
            color: #fbbf24; /* Aksen Kuning */
        }

        .left-content h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 15px; }
        .left-content p { font-size: 1.1rem; opacity: 0.9; line-height: 1.6; }

        /* ========================================= */
        /* SISI KANAN: BACKGROUND LEMBUT & MENYATU   */
        /* ========================================= */
        .register-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            position: relative;
            padding: 40px;
            overflow-y: auto;
        }

        /* Hiasan Pola Titik-titik Halus */
        .register-right::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(#cbd5e1 1.5px, transparent 1.5px);
            background-size: 25px 25px;
            opacity: 0.6;
        }

        .register-card {
            background: white;
            padding: 45px 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 2;
            border: 1px solid white;
            animation: slideLeft 1s ease-out;
            margin: 20px 0;
        }

        .register-card h3 { font-weight: 800; color: #1e293b; margin-bottom: 5px; font-size: 1.7rem; }
        .register-card p.subtitle { color: #64748b; font-size: 0.9rem; margin-bottom: 25px; }

        .form-label { font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 6px; }
        .input-group-custom { position: relative; margin-bottom: 15px; }

        .input-group-custom i {
            position: absolute; left: 18px; top: 50%;
            transform: translateY(-50%); color: #94a3b8; font-size: 1rem; z-index: 5;
        }

        .form-control-custom {
            width: 100%; padding: 12px 15px 12px 45px;
            border-radius: 10px; border: 2px solid #e2e8f0;
            background: #f8fafc; font-size: 0.9rem; transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: #f59e0b; background: white;
            outline: none; box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.15);
        }

        .btn-register {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #1e3a8a; border: none; border-radius: 12px;
            padding: 14px; font-weight: 800; font-size: 1rem; width: 100%;
            transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(251, 191, 36, 0.3);
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-3px); box-shadow: 0 15px 30px rgba(251, 191, 36, 0.5); color: #1e3a8a;
        }

        .login-link { text-align: center; margin-top: 20px; font-size: 0.9rem; color: #64748b; }
        .login-link a { color: #3b82f6; font-weight: 700; text-decoration: none; transition: 0.3s; }
        .login-link a:hover { color: #1e3a8a; text-decoration: underline; }

        @keyframes slideRight { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes slideLeft { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }

        @media (max-width: 900px) {
            .register-left { display: none; }
            .register-right { background: #f1f5f9; padding: 20px; }
            .register-card { padding: 30px 20px; }
        }
    </style>
</head>
<body>

<div class="register-container">
    <!-- SISI KIRI -->
    <div class="register-left">
        <div class="left-content">
            <i class="fas fa-user-graduate logo-big"></i>
            <h1>Gabung Bersama Kami</h1>
            <p>Jadilah bagian dari anggota e-Pustaka SMK Negeri 5. Dapatkan akses penuh ke katalog digital, ajukan peminjaman buku secara online, dan pantau riwayat bacaanmu dengan mudah.</p>
        </div>
    </div>

    <!-- SISI KANAN -->
    <div class="register-right">
        <div class="register-card">
            <h3>Buat Akun Baru</h3>
            <p class="subtitle">Lengkapi data diri Anda untuk mendaftar.</p>

            @if ($errors->any())
                <div class="alert alert-danger mb-3" style="border-radius: 10px; font-size: 0.85rem;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                <div class="mb-2">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-group-custom">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" class="form-control-custom" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Alamat Email</label>
                    <div class="input-group-custom">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control-custom" placeholder="Masukkan email aktif" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label class="form-label">Kelas</label>
                            <div class="input-group-custom">
                                <i class="fas fa-school"></i>
                                <input type="text" name="kelas" class="form-control-custom" placeholder="Cth: XI RPL" value="{{ old('kelas') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label class="form-label">NIS</label>
                            <div class="input-group-custom">
                                <i class="fas fa-id-card"></i>
                                <input type="text" name="nis" class="form-control-custom" placeholder="Cth: 22190" value="{{ old('nis') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Password</label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="form-control-custom" placeholder="Minimal 8 karakter" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-group-custom">
                        <i class="fas fa-check-circle"></i>
                        <input type="password" name="password_confirmation" class="form-control-custom" placeholder="Ulangi password Anda" required>
                    </div>
                </div>

                <button type="submit" class="btn-register" id="registerBtn">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </button>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', function() {
        const btn = document.getElementById('registerBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
        btn.disabled = true;
    });
</script>
</body>
</html>