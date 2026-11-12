@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

<style>
    .katalog-bg { position: relative; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; padding: 30px 0 60px 0; }
    .container-wide { width: 95%; max-width: 1500px; margin: 0 auto; position: relative; z-index: 1; }
    
    /* Header Katalog */
    .header-katalog {
        background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1500&q=80');
        background-size: cover; background-position: center; background-attachment: fixed;
        border-radius: 24px; padding: 40px; color: white; margin-bottom: 30px;
        position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .header-katalog::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(59, 130, 246, 0.8) 100%); z-index: 1; }
    .header-content { position: relative; z-index: 2; }
    .header-katalog h4 { font-weight: 800; margin-bottom: 10px; font-size: 2rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
    .header-katalog p { opacity: 0.95; margin-bottom: 0; font-size: 1.05rem; font-weight: 500; }
    
    /* Search Box */
    .search-wrapper { background: white; padding: 15px 20px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; position: relative; z-index: 5; margin-top: -30px; }
    .search-box { border-radius: 12px; border: 2px solid #e9ecef; padding: 12px 20px; transition: all 0.3s ease; background: #f8f9fa; flex-grow: 1; max-width: 500px; font-weight: 500; }
    .search-box:focus { border-color: #3b82f6; background: white; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15); }

    /* Showcase / Slider */
    .showcase-section { margin-bottom: 40px; background: white; border-radius: 20px; padding: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .showcase-title { font-weight: 800; color: #1e293b; font-size: 1.4rem; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .showcase-title i { color: #f59e0b; }
    .swiper { width: 100%; padding-bottom: 40px; }
    .swiper-slide { background-position: center; background-size: cover; width: 300px; height: 400px; border-radius: 16px; overflow: hidden; position: relative; box-shadow: 0 10px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease; }
    .swiper-slide:hover { transform: translateY(-5px) scale(1.02); }
    .swiper-slide img { display: block; width: 100%; height: 100%; object-fit: cover; }
    .slide-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0) 100%); padding: 20px; color: white; }
    .slide-overlay h5 { font-weight: 800; font-size: 1.1rem; margin-bottom: 5px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .slide-overlay p { font-size: 0.85rem; margin: 0; opacity: 0.8; }
    .slide-overlay .btn-slide { margin-top: 10px; background: #fbbf24; color: #1e3a8a; font-weight: 700; border: none; border-radius: 8px; padding: 6px 15px; font-size: 0.8rem; transition: 0.3s; }
    .slide-overlay .btn-slide:hover { background: #f59e0b; }
    .swiper-pagination-bullet-active { background: #1e3a8a !important; }

    /* Card Buku (DESKTOP) */
    .card-buku { border: none; border-radius: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.06); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); background: white; height: 100%; display: flex; flex-direction: column; overflow: hidden; position: relative; }
    .card-buku:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
    
    .cover-container { height: 220px; overflow: hidden; position: relative; }
    .cover-container img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
    .card-buku:hover .cover-container img { transform: scale(1.1); }
    .cover-fallback { width: 100%; height: 100%; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); display: flex; align-items: center; justify-content: center; }
    .cover-fallback i { font-size: 5rem; color: white; opacity: 0.3; }
    .badge-kategori-float { position: absolute; top: 15px; left: 15px; background: rgba(255,255,255,0.95); color: #1e293b; font-weight: 700; font-size: 0.75rem; padding: 5px 12px; border-radius: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 2; }

    .card-body-buku { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
    .judul-buku { font-weight: 800; font-size: 1.1rem; margin-bottom: 8px; color: #1e293b; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .pengarang-buku { color: #64748b; font-size: 0.85rem; margin-bottom: 15px; display: flex; align-items: center; gap: 8px; }
    .sinopsis-buku { font-size: 0.85rem; color: #64748b; margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6; flex-grow: 1; }
    
    .card-footer-buku { background: #f8fafc; border-top: 1px solid #f1f5f9; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .stok-badge { padding: 6px 15px; border-radius: 20px; font-weight: 700; font-size: 0.8rem; }
    .btn-action { border-radius: 10px; padding: 8px 16px; font-size: 0.85rem; font-weight: 700; transition: all 0.3s ease; }
    .btn-action:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.15); }

    /* Banner Siswa */
    .banner-siswa { background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px; padding: 25px; color: white; margin-bottom: 30px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); }
    .banner-siswa h5 { font-weight: 800; margin: 0 0 5px 0; }
    .banner-siswa p { margin: 0; opacity: 0.9; font-size: 0.9rem; }

    .empty-state { text-align: center; padding: 80px 20px; background: white; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .empty-state .empty-icon { font-size: 90px; color: #b2bec3; margin-bottom: 20px; }
    
    /* ========================================= */
    /* TAMPILAN MOBILE (LIST VIEW RAPI)          */
    /* ========================================= */
    @media (max-width: 768px) {
        .header-katalog { padding: 30px 20px; }
        .search-wrapper { flex-direction: column; align-items: stretch; margin-top: 10px; }
        .search-box { max-width: 100%; }
        .banner-siswa { flex-direction: column; text-align: center; gap: 15px; }
        .showcase-section { display: none; /* Sembunyikan slider di HP */ }

        /* Card diubah menjadi bentuk List */
        .card-buku { 
            flex-direction: row; 
            height: auto; 
            border-radius: 12px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        .card-buku:hover { transform: none; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }

        /* Foto di Kiri */
        .cover-container { 
            width: 100px; 
            height: auto; 
            min-height: 140px;
            flex-shrink: 0; 
        }
        .cover-container img { height: 100%; }

        .badge-kategori-float { 
            top: 8px; left: 8px; 
            font-size: 0.6rem; padding: 2px 6px; 
        }

        /* Teks di Kanan */
        .card-body-buku { padding: 12px; width: 100%; }
        .judul-buku { font-size: 0.9rem; margin-bottom: 4px; line-height: 1.3; }
        .pengarang-buku { font-size: 0.75rem; margin-bottom: 8px; }
        
        /* Tombol Sembunyikan Sinopsis */
        .btn-toggle-sinopsis {
            font-size: 0.7rem; padding: 2px 8px; border-radius: 4px;
            background: #f1f5f9; color: #3b82f6; border: none; margin-bottom: 8px;
            display: inline-block; cursor: pointer;
        }

        /* Sinopsis Tersembunyi Awalnya */
        .sinopsis-buku { 
            display: none; 
            font-size: 0.75rem; 
            margin-bottom: 8px;
            line-height: 1.4;
        }
        .sinopsis-buku.show { display: block; }

        /* Tombol Aksi di Bawah */
        .card-footer-buku { 
            padding: 10px 12px; 
            border-top: 1px dashed #e2e8f0; 
            background: #f8fafc;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        /* Sembunyikan tombol Detail di Desktop, ganti ikon kecil */
        .card-footer-buku .d-flex.gap-1 { display: flex; gap: 5px !important; }
        .card-footer-buku .btn-action { padding: 4px 8px; font-size: 0.7rem; }
        
        /* Tombol Pinjam di HP */
        .card-footer-buku > a.btn { 
            flex-grow: 1; 
            margin-left: 10px; 
            padding: 6px 12px; 
            font-size: 0.8rem; 
        }
    }
</style>

<div class="katalog-bg">
    <div class="container-wide">
        
        <!-- Banner Sapaan Siswa -->
        @auth
            @if(Auth::user()->role == 'siswa')
                <div class="banner-siswa">
                    <div>
                        <h5>👋 Halo, {{ Auth::user()->name }}!</h5>
                        <p>Mau baca buku apa hari ini? Temukan koleksi favoritmu di bawah ini.</p>
                    </div>
                    <div>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-light text-success fw-bold px-4 py-2" style="border-radius: 12px;">
                            <i class="fas fa-history me-1"></i> Riwayat Pinjam Saya
                        </a>
                    </div>
                </div>
            @endif
        @endauth

        <!-- Header Katalog -->
        <div class="header-katalog">
            <div class="header-content">
                <h4><i class="fas fa-book-open me-3"></i>Katalog Buku</h4>
                <p>Jelajahi dan temukan koleksi buku favorit Anda</p>
                <div class="mt-4">
                    <span class="badge bg-white text-primary me-2 px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.9rem;">
                        <i class="fas fa-layer-group me-1"></i> Total: {{ $bukus->total() }} Buku
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Search & Actions -->
        <div class="search-wrapper">
            {{-- FORM PENCARIAN --}}
            <form action="{{ Auth::check() ? route('buku.search') : route('katalog.search') }}" method="GET" class="d-flex gap-2 flex-grow-1" style="max-width: 600px;">
                <input type="text" name="keyword" class="form-control search-box" 
                       placeholder="🔍 Cari judul, pengarang, atau kategori..."
                       value="{{ request('keyword') }}">
                <button type="submit" class="btn btn-primary px-4" style="border-radius: 12px; font-weight: 600; background: #1e3a8a; border-color: #1e3a8a;">
                    <i class="fas fa-search"></i> Cari
                </button>
                @if(request('keyword'))
                    <a href="{{ Auth::check() ? route('buku.index') : route('katalog') }}" class="btn btn-outline-danger px-3" style="border-radius: 12px;" title="Reset Pencarian">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
            <div>
                @auth
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('buku.create') }}" class="btn btn-success px-4 py-2" style="border-radius: 12px; font-weight: 700; box-shadow: 0 4px 10px rgba(25, 135, 84, 0.3);">
                            <i class="fas fa-plus me-2"></i>Tambah Buku Baru
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Showcase / Slider (Disembunyikan di HP via CSS) -->
        @if(isset($featuredBukus) && $featuredBukus->count() > 0 && !request('keyword'))
        <div class="showcase-section">
            <h4 class="showcase-title"><i class="fas fa-fire"></i> Buku Pilihan Minggu Ini</h4>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($featuredBukus as $fb)
                    <div class="swiper-slide">
                        @if($fb->foto)
                            <img src="{{ $fb->foto }}" alt="{{ $fb->judul }}" />
                        @else
                            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Default" />
                        @endif
                        <div class="slide-overlay">
                            <span class="badge bg-primary mb-2">{{ $fb->kategori }}</span>
                            <h5>{{ $fb->judul }}</h5>
                            <p><i class="fas fa-pen-nib me-1"></i> {{ $fb->pengarang }}</p>
                            @if($fb->stok > 0)
                                @auth
                                    @if(Auth::user()->role == 'siswa')
                                        <a href="{{ route('peminjaman.form_ajukan', $fb->id) }}" class="btn btn-slide">
                                            <i class="fas fa-hand-holding"></i> Pinjam Sekarang
                                        </a>
                                    @endif
                                @endauth
                                @guest
                                    <a href="{{ route('login') }}" class="btn btn-slide" onclick="return confirm('Login dulu untuk meminjam.')">
                                        <i class="fas fa-hand-holding"></i> Pinjam Sekarang
                                    </a>
                                @endguest
                            @else
                                <span class="badge bg-danger mt-2">Stok Habis</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next" style="color: #1e3a8a;"></div>
                <div class="swiper-button-prev" style="color: #1e3a8a;"></div>
            </div>
        </div>
        @endif
        
        <!-- Grid Buku -->
        <div class="row g-4">
            @forelse($bukus as $buku)
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="card-buku">
                    <div class="cover-container">
                        @if($buku->foto)
                            <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}">
                        @else
                            <div class="cover-fallback"><i class="fas fa-book"></i></div>
                        @endif
                        <span class="badge-kategori-float">
                            <i class="fas fa-tag me-1 text-primary"></i>{{ $buku->kategori }}
                        </span>
                    </div>
                    
                    <div class="card-body-buku">
                        <div class="judul-buku">{{ $buku->judul }}</div>
                        <div class="pengarang-buku">
                            <i class="fas fa-pen-nib text-primary"></i> {{ $buku->pengarang }}
                        </div>
                        
                        {{-- Tombol Baca Sinopsis (Hanya muncul di HP) --}}
                        <button class="btn-toggle-sinopsis d-md-none" onclick="toggleSinopsis(this)">
                            <i class="fas fa-chevron-down"></i> Baca Sinopsis
                        </button>

                        <div class="mt-1 mb-2">
                            <span class="stok-badge bg-{{ $buku->stok > 0 ? 'success' : 'danger' }} text-white">
                                <i class="fas fa-{{ $buku->stok > 0 ? 'check-circle' : 'times-circle' }} me-1"></i>
                                Stok: {{ $buku->stok }}
                            </span>
                        </div>
                        
                        @if($buku->sinopsis)
                            <p class="sinopsis-buku">{{ $buku->sinopsis }}</p>
                        @else
                            <p class="sinopsis-buku fst-italic text-muted">Belum ada sinopsis.</p>
                        @endif
                    </div>

                    <div class="card-footer-buku">
                        <div class="d-flex gap-1">
                            <a href="{{ Auth::check() ? route('buku.show', $buku->id) : route('katalog.show', $buku->id) }}" class="btn btn-sm btn-info btn-action text-white">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @auth
                                @if(Auth::user()->role == 'admin')
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning btn-action"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            @endauth
                        </div>

                        @if($buku->stok > 0)
                            @auth
                                @if(Auth::user()->role == 'siswa')
                                    <a href="{{ route('peminjaman.form_ajukan', $buku->id) }}" class="btn btn-sm btn-action" style="background: #059669; color: white; border: none;">
                                        <i class="fas fa-hand-holding"></i> Pinjam
                                    </a>
                                @endif
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-sm btn-action" style="background: #059669; color: white; border: none;" onclick="return confirm('Silakan login terlebih dahulu untuk meminjam buku ini.')">
                                    <i class="fas fa-hand-holding"></i> Pinjam
                                </a>
                            @endguest
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-book-dead"></i></div>
                    <h4 class="text-muted fw-bold">Buku tidak ditemukan</h4>
                    @if(request('keyword'))
                        <p class="text-muted">Tidak ada buku dengan kata kunci "{{ request('keyword') }}". Coba kata kunci lain.</p>
                        <a href="{{ Auth::check() ? route('buku.index') : route('katalog') }}" class="btn btn-primary mt-3 px-4 py-2" style="border-radius: 10px;">
                            <i class="fas fa-undo me-1"></i>Reset Pencarian
                        </a>
                    @else
                        @auth
                            @if(Auth::user()->role == 'admin')
                                <p class="text-muted">Mulai tambahkan koleksi buku pertama Anda</p>
                                <a href="{{ route('buku.create') }}" class="btn btn-primary mt-3 px-4 py-2" style="border-radius: 10px;">
                                    <i class="fas fa-plus me-1"></i>Tambah Buku Sekarang
                                </a>
                            @else
                                <p class="text-muted">Belum ada buku di perpustakaan.</p>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
            @endforelse
        </div>
        
        <div class="d-flex justify-content-center mt-5">
            {{ $bukus->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        breakpoints: {
            640: { slidesPerView: 2, spaceBetween: 20 },
            1024: { slidesPerView: 3, spaceBetween: 30 },
        }
    });

    // Fungsi untuk Buka-Tutup Sinopsis di HP
    function toggleSinopsis(button) {
        const cardBody = button.closest('.card-body-buku');
        const sinopsis = cardBody.querySelector('.sinopsis-buku');
        
        if (sinopsis.classList.contains('show')) {
            sinopsis.classList.remove('show');
            button.innerHTML = '<i class="fas fa-chevron-down"></i> Baca Sinopsis';
        } else {
            sinopsis.classList.add('show');
            button.innerHTML = '<i class="fas fa-chevron-up"></i> Sembunyikan';
        }
    }
</script>
@endsection