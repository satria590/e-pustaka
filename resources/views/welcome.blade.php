@extends('layouts.app')

@section('title', 'Selamat Datang di e-Pustaka')

@section('content')
<style>
    /* =========================================
       HERO SECTION (Layar Penuh Pertama)
       ========================================= */
    .hero-section {
        position: relative;
        background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        height: 85vh; /* Hampir setinggi layar */
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        margin-top: -24px; /* Menarik ke atas agar menempel navbar */
    }

    .hero-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 58, 138, 0.7) 100%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        padding: 0 20px;
        animation: slideUp 1s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        line-height: 1.2;
    }

    .hero-content p {
        font-size: 1.2rem;
        margin-bottom: 40px;
        opacity: 0.9;
        font-weight: 400;
    }

    .btn-hero {
        background: #fbbf24; /* Kuning cerah */
        color: #1e3a8a;
        font-weight: 700;
        font-size: 1.1rem;
        padding: 15px 40px;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(251, 191, 36, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
    }

    .btn-hero:hover {
        background: #f59e0b;
        color: #1e3a8a;
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(251, 191, 36, 0.6);
    }

    /* =========================================
       SECTION FITUR / KEUNGGULAN
       ========================================= */
    .features-section {
        padding: 80px 0;
        background: white;
        position: relative;
        z-index: 3;
    }

    .feature-card {
        text-align: center;
        padding: 30px 20px;
        border-radius: 20px;
        background: #f8fafc;
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #e2e8f0;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        background: white;
        border-color: #3b82f6;
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 20px;
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
    }

    .feature-card h5 { font-weight: 700; color: #1e293b; margin-bottom: 10px; }
    .feature-card p { color: #64748b; font-size: 0.95rem; line-height: 1.6; margin: 0; }

    /* =========================================
       KATALOG PREVIEW (Bawah)
       ========================================= */
    .katalog-preview {
        padding: 80px 0;
        background: #f0f4f8;
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 { font-weight: 800; color: #1e3a8a; font-size: 2.2rem; margin-bottom: 10px; }
    .section-title p { color: #64748b; font-size: 1.1rem; }

    /* Card Buku (Copy dari index) */
    .card-buku {
        border: none; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        transition: all 0.4s ease; background: white; height: 100%;
        display: flex; flex-direction: column; overflow: hidden; position: relative;
        border-left: 6px solid #cbd5e1;
    }
    .card-buku:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    
    .bg-kategori-teknologi { background: #e0e7ff; color: #3730a3; border-left-color: #6366f1; }
    .bg-kategori-sains { background: #d1fae5; color: #065f46; border-left-color: #10b981; }
    .bg-kategori-fiksi { background: #fce7f3; color: #9d174d; border-left-color: #ec4899; }
    .bg-kategori-sejarah { background: #fef3c7; color: #92400e; border-left-color: #f59e0b; }
    .bg-kategori-lainnya { background: #f3e8ff; color: #6b21a8; border-left-color: #a855f7; }

    .card-buku .card-header-buku { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
    .card-buku .kategori-badge { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px; }
    .card-buku .book-icon { font-size: 1.8rem; opacity: 0.3; transition: all 0.3s ease; }
    .card-buku:hover .book-icon { transform: scale(1.2) rotate(10deg); opacity: 0.6; }
    
    .card-buku .card-body { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
    .card-buku .judul { font-weight: 800; font-size: 1.15rem; margin-bottom: 5px; color: #1e293b; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .card-buku .pengarang { color: #64748b; font-size: 0.85rem; margin-bottom: 15px; display: flex; align-items: center; gap: 6px; font-weight: 500; font-style: italic; }
    .card-buku .sinopsis { font-size: 0.85rem; color: #64748b; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6; flex-grow: 1; }
    
    .card-buku .card-footer { background: #f8fafc; border-top: 1px dashed #e2e8f0; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .btn-action { border-radius: 8px; padding: 7px 15px; font-size: 0.8rem; font-weight: 700; transition: all 0.3s ease; }
    .stok-badge { padding: 5px 12px; border-radius: 8px; font-weight: 700; font-size: 0.75rem; }

    @media (max-width: 768px) {
        .hero-content h1 { font-size: 2.2rem; }
        .hero-section { height: auto; padding: 100px 0; }
    }
</style>

<!-- =========================================
     1. HERO SECTION (Layar Pertama)
     ========================================= -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Jelajahi Dunia Lewat Membaca</h1>
        <p>Sistem Informasi Perpustakaan Digital SMK Negeri 5. Temukan ribuan koleksi buku, pinjam dengan mudah, dan kelola riwayat bacaanmu dalam satu genggaman.</p>
        
        <!-- Tombol yang mengarah ke ID #katalog -->
        <a href="#katalog" class="btn-hero">
            <i class="fas fa-book-open"></i> Lihat Koleksi Buku
        </a>
    </div>
</section>

<!-- =========================================
     2. FITUR SECTION (Keunggulan)
     ========================================= -->
<section class="features-section">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-search"></i></div>
                    <h5>Pencarian Cepat</h5>
                    <p>Temukan buku berdasarkan judul, pengarang, atau kategori dengan mesin pencari yang canggih.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                    <h5>Peminjaman Online</h5>
                    <p>Ajukan peminjaman buku langsung dari smartphone kamu tanpa harus antre di depan rak.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-history"></i></div>
                    <h5>Riwayat Terpantau</h5>
                    <p>Pantau tanggal pengembalian dan riwayat bacaanmu agar terhindar dari denda keterlambatan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================
     3. KATALOG PREVIEW (Target Scroll)
     ========================================= -->
<section id="katalog" class="katalog-preview">
    <div class="container">
        <div class="section-title">
            <h2>Koleksi Terbaru Kami</h2>
            <p>Beberapa buku yang baru saja ditambahkan ke perpustakaan</p>
        </div>

        <div class="row g-4">
            @forelse($bukus as $buku)
            <div class="col-xl-3 col-lg-4 col-md-6">
                
                @php
                    $kat = strtolower($buku->kategori);
                    $bgClass = 'bg-kategori-lainnya';
                    $iconClass = 'fa-book';
                    if ($kat == 'teknologi') { $bgClass = 'bg-kategori-teknologi'; $iconClass = 'fa-laptop-code'; } 
                    elseif ($kat == 'sains') { $bgClass = 'bg-kategori-sains'; $iconClass = 'fa-flask'; } 
                    elseif ($kat == 'fiksi') { $bgClass = 'bg-kategori-fiksi'; $iconClass = 'fa-hat-wizard'; } 
                    elseif ($kat == 'sejarah') { $bgClass = 'bg-kategori-sejarah'; $iconClass = 'fa-landmark'; }
                @endphp

                <div class="card-buku {{ $bgClass }}">
                    <div class="card-header-buku">
                        <div class="kategori-badge"><i class="fas {{ $iconClass }}"></i> {{ $buku->kategori }}</div>
                        <i class="book-icon fas {{ $iconClass }}"></i>
                    </div>
                    
                    <div class="card-body">
                        <div class="judul">{{ $buku->judul }}</div>
                        <div class="pengarang"><i class="fas fa-pen-nib"></i> {{ $buku->pengarang }}</div>
                        <div class="mt-1 mb-3">
                            <span class="stok-badge bg-{{ $buku->stok > 0 ? 'success' : 'danger' }} text-white">Stok: {{ $buku->stok }}</span>
                        </div>
                        <p class="sinopsis">{{ $buku->sinopsis ?? 'Belum ada sinopsis.' }}</p>
                    </div>

                    <div class="card-footer">
                        <a href="{{ Auth::check() ? route('buku.show', $buku->id) : route('katalog.show', $buku->id) }}" class="btn btn-sm btn-outline-primary btn-action">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        
                        @auth
                            @if(Auth::user()->role == 'siswa' && $buku->stok > 0)
                                <a href="{{ route('peminjaman.form_ajukan', $buku->id) }}" class="btn btn-sm btn-primary btn-action" style="background: #1e3a8a; border-color: #1e3a8a;">
                                    <i class="fas fa-hand-holding"></i> Pinjam
                                </a>
                            @endif
                        @endauth

                        @guest
                            @if($buku->stok > 0)
                                <a href="{{ route('login') }}" class="btn btn-sm btn-primary btn-action" style="background: #1e3a8a; border-color: #1e3a8a;" onclick="return confirm('Silakan login terlebih dahulu untuk meminjam buku ini.')">
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
@endsection