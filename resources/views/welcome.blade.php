@extends('layouts.app')

@section('title', 'Selamat Datang di e-Pustaka')

@section('content')
<style>
    /* =========================================
       HERO SECTION
       ========================================= */
    .hero-section {
        position: relative;
        background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 50vh;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        margin-top: -24px;
    }

    .hero-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 58, 138, 0.85) 100%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 900px;
        padding: 0 20px;
        animation: slideUp 1.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 15px;
        line-height: 1.1;
        letter-spacing: -1px;
    }

    .text-gradient {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-content p {
        font-size: 1rem;
        margin-bottom: 30px;
        opacity: 0.9;
        font-weight: 300;
        line-height: 1.6;
    }

    .btn-hero {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: #1e3a8a;
        font-weight: 800;
        font-size: 1rem;
        padding: 12px 30px;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 8px 20px rgba(251, 191, 36, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
    }

    .btn-hero:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 12px 25px rgba(251, 191, 36, 0.6);
        color: #1e3a8a;
    }

    /* =========================================
       SECTION FITUR
       ========================================= */
    .features-section {
        padding: 60px 0;
        background: white;
        position: relative;
        z-index: 3;
        margin-top: -30px;
        border-radius: 30px 30px 0 0;
        box-shadow: 0 -10px 40px rgba(0,0,0,0.05);
    }

    .feature-card {
        text-align: center;
        padding: 25px 15px;
        border-radius: 20px;
        background: white;
        transition: all 0.4s ease;
        height: 100%;
        border: 1px solid #e2e8f0;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        border-color: #3b82f6;
    }

    .feature-icon-wrapper {
        width: 70px; height: 70px;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white; border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; margin: 0 auto 15px;
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
    }

    .feature-card h5 { font-weight: 800; color: #1e293b; margin-bottom: 8px; font-size: 1rem; }
    .feature-card p { color: #64748b; font-size: 0.85rem; line-height: 1.6; margin: 0; }

    /* =========================================
       KATALOG PREVIEW
       ========================================= */
    .katalog-preview {
        padding: 50px 0 80px;
        background: #f0f4f8;
    }

    .section-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-title h2 { 
        font-weight: 900; color: #1e3a8a; font-size: 2.2rem; margin-bottom: 10px; 
    }
    .section-title p { color: #64748b; font-size: 0.95rem; }

    .card-buku-preview {
        border: none; border-radius: 16px; 
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.4s ease; 
        background: white; height: 100%;
        display: flex; flex-direction: column; overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .card-buku-preview:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    
    .cover-preview {
        height: 250px; position: relative; overflow: hidden;
        background: #f1f5f9; display: flex; justify-content: center; align-items: center;
        padding: 15px;
    }
    .cover-preview img {
        height: 100%; width: auto; max-width: 100%; object-fit: cover;
        border-radius: 8px; box-shadow: 5px 5px 15px rgba(0,0,0,0.25);
        transition: transform 0.4s ease;
        transform: perspective(800px) rotateY(-5deg);
    }
    .card-buku-preview:hover .cover-preview img { transform: perspective(800px) rotateY(0deg) scale(1.05); }

    .cover-fallback {
        width: 140px; height: 200px;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px; box-shadow: 5px 5px 15px rgba(0,0,0,0.25);
        transform: perspective(800px) rotateY(-5deg); transition: transform 0.4s ease;
    }
    .cover-fallback i { font-size: 3rem; color: white; opacity: 0.3; }
    .card-buku-preview:hover .cover-fallback { transform: perspective(800px) rotateY(0deg) scale(1.05); }

    .badge-kategori-preview {
        position: absolute; top: 15px; left: 15px;
        background: rgba(255,255,255,0.95); color: #1e293b;
        font-weight: 700; font-size: 0.7rem; padding: 5px 12px;
        border-radius: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        z-index: 2;
    }

    .card-body-preview { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
    .judul-preview { font-weight: 800; font-size: 1rem; margin-bottom: 6px; color: #1e293b; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .pengarang-preview { color: #64748b; font-size: 0.8rem; margin-bottom: 15px; display: flex; align-items: center; gap: 6px; }
    .sinopsis-preview { font-size: 0.8rem; color: #64748b; margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5; flex-grow: 1; }
    
    .footer-preview { 
        background: #f8fafc; border-top: 1px solid #f1f5f9; 
        padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; 
    }

    /* =========================================
       BANNER AJAKAN (CTA)
       ========================================= */
    .cta-section {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        padding: 50px 20px;
        text-align: center;
        color: white;
        border-radius: 30px;
        margin: 0 5% 50px 5%;
        box-shadow: 0 15px 30px rgba(30, 58, 138, 0.3);
        position: relative;
        overflow: hidden;
    }
    .cta-section::before {
        content: '📚'; position: absolute; left: -20px; top: -20px; font-size: 150px; opacity: 0.1; transform: rotate(-15deg);
    }
    .cta-section h2 { font-weight: 800; font-size: 2rem; margin-bottom: 15px; position: relative; z-index: 2; }
    .cta-section p { font-size: 1rem; opacity: 0.9; margin-bottom: 25px; position: relative; z-index: 2; }

    /* =========================================
       FOOTER KHUSUS LANDING PAGE
       ========================================= */
    .footer-landing {
        background: #0f172a; color: #94a3b8; padding: 30px 0; text-align: center;
    }
    .footer-landing p { margin: 0; font-size: 0.9rem; }

    /* =========================================
       RESPONSIVE (TAMPILAN HP)
       ========================================= */
    @media (max-width: 768px) {
        /* Hero Section di HP */
        .hero-section { 
            height: 50vh; 
            min-height: 350px; 
            padding: 30px 0; 
        }
        .hero-content h1 { font-size: 2.2rem; margin-bottom: 10px; }
        .hero-content p { font-size: 0.9rem; margin-bottom: 25px; }
        .btn-hero { font-size: 0.9rem; padding: 10px 25px; }
        
        /* Fitur Section di HP */
        .features-section { 
            margin-top: -20px; 
            border-radius: 20px 20px 0 0; 
            padding: 40px 0; 
        }
        .feature-card { padding: 20px 15px; }
        .feature-icon-wrapper { width: 60px; height: 60px; font-size: 1.5rem; margin-bottom: 12px; }
        .feature-card h5 { font-size: 0.95rem; }
        .feature-card p { font-size: 0.8rem; }
        
        /* Katalog di HP */
        .section-title h2 { font-size: 1.8rem; }
        .cover-preview { height: 220px; }
        
        /* CTA di HP */
        .cta-section h2 { font-size: 1.5rem; }
        .cta-section { margin: 0 15px 40px 15px; padding: 40px 15px; }
    }
</style>

<!-- =========================================
     1. HERO SECTION
     ========================================= -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Jelajahi Dunia<br>Lewat <span class="text-gradient">Membaca</span></h1>
        <p>Sistem Informasi Perpustakaan Digital SMK Negeri 5. Temukan ribuan koleksi buku, pinjam dengan mudah, dan kelola riwayat bacaanmu.</p>
        
        <a href="#katalog" class="btn-hero">
            <i class="fas fa-book-open"></i> Lihat Koleksi Buku
        </a>
    </div>
</section>

<!-- =========================================
     2. FITUR SECTION
     ========================================= -->
<section class="features-section">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-wrapper"><i class="fas fa-search"></i></div>
                    <h5>Pencarian Cepat</h5>
                    <p>Temukan buku berdasarkan judul, pengarang, atau kategori dengan mesin pencari.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-wrapper"><i class="fas fa-mobile-alt"></i></div>
                    <h5>Peminjaman Online</h5>
                    <p>Ajukan peminjaman buku langsung dari smartphone tanpa harus antre di rak.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-wrapper"><i class="fas fa-history"></i></div>
                    <h5>Riwayat Terpantau</h5>
                    <p>Pantau tanggal pengembalian dan riwayat bacaanmu agar terhindar dari denda.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================
     3. KATALOG PREVIEW
     ========================================= -->
<section id="katalog" class="katalog-preview">
    <div class="container">
        <div class="section-title">
            <h2>Koleksi Terbaru</h2>
            <p>Beberapa buku yang baru saja ditambahkan ke perpustakaan</p>
        </div>

        <div class="row g-4">
            @forelse($bukus as $buku)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card-buku-preview">
                    <div class="cover-preview">
                        @if($buku->foto)
                            <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}">
                        @else
                            <div class="cover-fallback"><i class="fas fa-book"></i></div>
                        @endif
                        <span class="badge-kategori-preview">
                            <i class="fas fa-tag me-1 text-primary"></i>{{ $buku->kategori }}
                        </span>
                    </div>
                    
                    <div class="card-body-preview">
                        <div class="judul-preview">{{ $buku->judul }}</div>
                        <div class="pengarang-preview"><i class="fas fa-pen-nib text-primary"></i> {{ $buku->pengarang }}</div>
                        
                        <div class="mb-2">
                            <span class="badge bg-{{ $buku->stok > 0 ? 'success' : 'danger' }} text-white" style="padding: 4px 12px; border-radius: 20px; font-size: 0.7rem;">
                                <i class="fas fa-{{ $buku->stok > 0 ? 'check-circle' : 'times-circle' }} me-1"></i> Stok: {{ $buku->stok }}
                            </span>
                        </div>
                        
                        <p class="sinopsis-preview">{{ $buku->sinopsis ?? 'Belum ada sinopsis.' }}</p>
                    </div>

                    <div class="footer-preview">
                        <a href="{{ Auth::check() ? route('buku.show', $buku->id) : route('katalog.show', $buku->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px; font-weight: 600; font-size: 0.75rem; padding: 5px 10px;">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        
                        @auth
                            @if(Auth::user()->role == 'siswa' && $buku->stok > 0)
                                <a href="{{ route('peminjaman.form_ajukan', $buku->id) }}" class="btn btn-sm btn-primary" style="border-radius: 8px; font-weight: 600; background: #1e3a8a; border-color: #1e3a8a; font-size: 0.75rem; padding: 5px 10px;">
                                    <i class="fas fa-hand-holding"></i> Pinjam
                                </a>
                            @endif
                        @endauth

                        @guest
                            @if($buku->stok > 0)
                                <a href="{{ route('login') }}" class="btn btn-sm btn-primary" style="border-radius: 8px; font-weight: 600; background: #1e3a8a; border-color: #1e3a8a; font-size: 0.75rem; padding: 5px 10px;" onclick="return confirm('Silakan login terlebih dahulu untuk meminjam buku ini.')">
                                    <i class="fas fa-hand-holding"></i> Pinjam
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">Belum ada koleksi buku.</h4>
            </div>
            @endforelse
        </div>

        <!-- Tombol Menuju Halaman Katalog Penuh -->
        <div class="text-center mt-5">
            <a href="{{ Auth::check() ? route('buku.index') : route('katalog') }}" class="btn btn-lg btn-primary px-5 py-3" style="border-radius: 50px; font-weight: 700; background: #1e3a8a; border-color: #1e3a8a; box-shadow: 0 10px 20px rgba(30, 58, 138, 0.3);">
                Lihat Semua Katalog Buku <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- =========================================
     4. BANNER AJAKAN (CTA)
     ========================================= -->
<section class="cta-section">
    <h2>Mulai Petualangan Membacamu Hari Ini!</h2>
    <p>Bergabunglah bersama ratusan siswa lainnya. Pinjam buku favoritmu sekarang juga.</p>
    @guest
        <a href="{{ route('register') }}" class="btn btn-light text-primary fw-bold px-4 py-2" style="border-radius: 50px;">
            <i class="fas fa-user-plus me-2"></i> Daftar Anggota Sekarang
        </a>
    @endguest
    @auth
        <a href="{{ route('buku.index') }}" class="btn btn-light text-primary fw-bold px-4 py-2" style="border-radius: 50px;">
            <i class="fas fa-book-open me-2"></i> Mulai Cari Buku
        </a>
    @endauth
</section>

<!-- =========================================
     5. FOOTER LANDING PAGE
     ========================================= -->
<div class="footer-landing">
    <p>&copy; {{ date('Y') }} e-Pustaka SMK Negeri 5. Dibuat dengan <i class="fas fa-heart text-danger"></i> oleh Satria Rahmansyah.</p>
</div>

@endsection