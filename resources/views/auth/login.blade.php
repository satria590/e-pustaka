<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - e-Pustaka SMK Negeri 5</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        
        /* Background Animation */
        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        
        .bg-animation .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: float 20s infinite ease-in-out;
        }
        
        .bg-animation .circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }
        
        .bg-animation .circle:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
            animation-delay: 5s;
        }
        
        .bg-animation .circle:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 10s;
        }
        
        .bg-animation .circle:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 20%;
            right: 10%;
            animation-delay: 3s;
        }
        
        .bg-animation .circle:nth-child(5) {
            width: 250px;
            height: 250px;
            bottom: 20%;
            left: 5%;
            animation-delay: 7s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(50px, -30px) scale(1.1);
            }
            50% {
                transform: translate(-20px, 50px) scale(0.9);
            }
            75% {
                transform: translate(30px, -20px) scale(1.05);
            }
        }
        
        /* Floating Books */
        .floating-books {
            position: absolute;
            font-size: 3rem;
            opacity: 0.1;
            color: white;
            animation: floatBook 15s infinite ease-in-out;
            z-index: 0;
        }
        
        .floating-books:nth-child(1) {
            top: 10%;
            left: 5%;
            animation-delay: 0s;
            font-size: 4rem;
        }
        
        .floating-books:nth-child(2) {
            top: 70%;
            right: 8%;
            animation-delay: 4s;
            font-size: 3.5rem;
        }
        
        .floating-books:nth-child(3) {
            top: 40%;
            left: 2%;
            animation-delay: 8s;
            font-size: 2.5rem;
        }
        
        .floating-books:nth-child(4) {
            bottom: 15%;
            right: 3%;
            animation-delay: 12s;
            font-size: 3rem;
        }
        
        @keyframes floatBook {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(20px, -30px) rotate(5deg);
            }
            50% {
                transform: translate(-15px, 25px) rotate(-3deg);
            }
            75% {
                transform: translate(10px, -15px) rotate(4deg);
            }
        }
        
        /* Card Login */
        .login-card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-icon {
            display: inline-block;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            line-height: 80px;
            text-align: center;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 1rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
            }
        }
        
        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .logo-sub {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 400;
            display: block;
            -webkit-text-fill-color: #6c757d;
        }
        
        .logo-divider {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            margin: 0.5rem auto;
            border-radius: 10px;
        }
        
        .form-label {
            font-weight: 500;
            font-size: 0.9rem;
            color: #333;
        }
        
        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
        }
        
        .form-control-icon {
            position: relative;
        }
        
        .form-control-icon .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }
        
        .form-control-icon .form-control {
            padding-left: 45px;
        }
        
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login i {
            margin-right: 8px;
        }
        
        .btn-login .spinner {
            display: none;
        }
        
        .btn-login.loading .spinner {
            display: inline-block;
        }
        
        .btn-login.loading .btn-text {
            display: none;
        }
        
        .form-check {
            padding-left: 2rem;
        }
        
        .form-check-input {
            border-radius: 4px;
            border: 2px solid #ced4da;
            transition: all 0.2s ease;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .form-check-label {
            font-size: 0.9rem;
            color: #495057;
        }
        
        .forgot-link {
            font-size: 0.9rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .forgot-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e9ecef;
        }
        
        .register-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .register-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        .register-link .text-muted {
            font-size: 0.9rem;
        }
        
        /* Alert */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
        
        .alert-danger {
            background: #fde8e8;
            color: #dc3545;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
                border-radius: 16px;
            }
            
            .logo-icon {
                width: 60px;
                height: 60px;
                line-height: 60px;
                font-size: 2rem;
            }
            
            .logo-text {
                font-size: 1.5rem;
            }
            
            .floating-books {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="bg-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
    
    <!-- Floating Books -->
    <div class="floating-books"><i class="fas fa-book"></i></div>
    <div class="floating-books"><i class="fas fa-book-open"></i></div>
    <div class="floating-books"><i class="fas fa-book-reader"></i></div>
    <div class="floating-books"><i class="fas fa-graduation-cap"></i></div>
    
    <!-- Login Card -->
    <div class="login-card">
        <!-- Logo -->
        <div class="logo-container">
            <div class="logo-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="logo-text">
                e-Pustaka
                <span class="logo-sub">SMK Negeri 5</span>
            </div>
            <div class="logo-divider"></div>
            <p class="text-muted mt-2" style="font-size: 0.85rem;">
                <i class="fas fa-arrow-right me-1"></i>Sistem Informasi Perpustakaan Digital
            </p>
        </div>
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-3">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            </div>
        @endif
        
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif
        
        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            
            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">
                    <i class="fas fa-envelope me-1 text-primary"></i>Alamat Email
                </label>
                <div class="form-control-icon">
                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" 
                           name="email" 
                           class="form-control" 
                           placeholder="Masukkan email Anda"
                           value="{{ old('email') }}"
                           required 
                           autofocus>
                </div>
            </div>
            
            <!-- Password -->
            <div class="mb-3">
                <label class="form-label">
                    <i class="fas fa-lock me-1 text-primary"></i>Password
                </label>
                <div class="form-control-icon">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" 
                           name="password" 
                           class="form-control" 
                           placeholder="Masukkan password Anda"
                           required>
                </div>
            </div>
            
            <!-- Remember & Forgot -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" 
                           name="remember" 
                           class="form-check-input" 
                           id="remember">
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        <i class="fas fa-key me-1"></i>Lupa password?
                    </a>
                @endif
            </div>
            
            <!-- Login Button -->
            <button type="submit" class="btn-login" id="loginBtn">
                <span class="btn-text">
                    <i class="fas fa-sign-in-alt"></i>Masuk
                </span>
                <span class="spinner">
                    <i class="fas fa-spinner fa-spin"></i> Memproses...
                </span>
            </button>
            
            <!-- Register Link -->
            <div class="register-link">
                <span class="text-muted">Belum punya akun?</span>
                <a href="{{ route('register') }}">
                    <i class="fas fa-user-plus me-1"></i>Daftar sekarang
                </a>
            </div>
        </form>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Loading effect on login button
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>
</body>
</html>