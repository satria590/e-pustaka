<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>e-Pustaka - @yield('title', 'Dashboard')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Navbar Custom Gradient */
        .navbar-custom {
            background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 12px 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            color: white !important;
        }

        .navbar-brand i { transition: transform 0.3s ease; }
        .navbar-brand:hover i { transform: scale(1.2) rotate(-10deg); }

        /* Link Navigasi Desktop */
        .nav-link-custom {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link-custom:hover, 
        .nav-link-custom.active {
            color: white !important;
            background: rgba(255, 255, 255, 0.15);
        }

        /* Tombol Login & Daftar (Desktop) */
        .btn-login-nav {
            color: white;
            border: 2px solid rgba(255,255,255,0.5);
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-login-nav:hover {
            background: white;
            color: #1e3a8a;
            border-color: white;
        }

        .btn-register-nav {
            background: #fbbf24;
            color: #1e3a8a;
            border: 2px solid #fbbf24;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 700;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(251, 191, 36, 0.4);
        }

        .btn-register-nav:hover {
            background: #f59e0b;
            border-color: #f59e0b;
            color: #1e3a8a;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(251, 191, 36, 0.6);
        }

        /* Dropdown User (Jika Login) */
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            padding: 10px;
        }
        .dropdown-item {
            border-radius: 8px;
            padding: 8px 15px;
            font-weight: 500;
            transition: 0.2s;
        }
        .dropdown-item:hover { background: #f1f5f9; color: #3b82f6; }

        /* ========================================= */
        /* PERBAIKAN NAVBAR MOBILE (HP)              */
        /* ========================================= */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: rgba(30, 58, 138, 0.98); /* Latar biru gelap transparan */
                backdrop-filter: blur(10px);
                border-radius: 12px;
                margin-top: 15px;
                padding: 20px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                border: 1px solid rgba(255,255,255,0.1);
            }

            .navbar-nav {
                align-items: stretch !important;
                gap: 10px !important;
            }

            .nav-link-custom {
                text-align: center;
                padding: 12px !important;
                background: rgba(255,255,255,0.05);
            }

            .btn-login-nav, .btn-register-nav {
                display: block;
                text-align: center;
                width: 100%;
                margin-bottom: 10px;
            }

            .dropdown-menu {
                background: transparent;
                box-shadow: none;
                border: 1px solid rgba(255,255,255,0.2);
                padding: 5px;
            }
            .dropdown-item {
                color: white;
                text-align: center;
            }
            .dropdown-item:hover {
                background: rgba(255,255,255,0.1);
                color: white;
            }
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-book-open me-2"></i>e-Pustaka
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-3">
                    {{-- Menu untuk GUEST (belum login) --}}
                    @guest
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('katalog*') || request()->routeIs('home') ? 'active' : '' }}" 
                               href="{{ route('katalog') }}">
                                <i class="fas fa-book me-1"></i>Katalog Buku
                            </a>
                        </li>
                    @endguest

                    {{-- Menu untuk USER yang sudah LOGIN --}}
                    @auth
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                               href="{{ route('dashboard') }}">
                                <i class="fas fa-chart-pie me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('buku.*') ? 'active' : '' }}" 
                               href="{{ route('buku.index') }}">
                                <i class="fas fa-book me-1"></i>Katalog Buku
                            </a>
                        </li>
                        @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}" 
                               href="{{ route('peminjaman.index') }}">
                                <i class="fas fa-hand-holding me-1"></i>Peminjaman
                            </a>
                        </li>
                        @endif
                    @endauth
                </ul>
                
                <ul class="navbar-nav align-items-center gap-2">
                    {{-- ================== GUEST ================== --}}
                    @guest
                        <li class="nav-item w-100 w-lg-auto">
                            <a class="btn-login-nav" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item w-100 w-lg-auto">
                            <a class="btn-register-nav" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Daftar
                            </a>
                        </li>
                    @endguest

                    {{-- ================== USER LOGIN ================== --}}
                    @auth
                        <li class="nav-item dropdown w-100 w-lg-auto text-center">
                            <a class="nav-link dropdown-toggle d-inline-flex align-items-center justify-content-center text-white w-100" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2 fs-5"></i>{{ Auth::user()->name }}
                                <span class="badge bg-light text-dark ms-2">{{ Auth::user()->role }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-cog me-2"></i>Pengaturan Profil
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow-1">
        <div class="container-fluid p-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3 shadow-sm border-0">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3 shadow-sm border-0">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-center py-4 mt-auto border-top">
        <div class="container">
            <small class="text-muted fw-medium">
                &copy; {{ date('Y') }} e-Pustaka SMK Negeri 5 | 
                <i class="fas fa-code me-1 text-primary"></i>Developed by Satria Rahmansyah
            </small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>