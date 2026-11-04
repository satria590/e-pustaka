@extends('layouts.app')

@section('title', 'Detail Buku - ' . $buku->judul)

@section('content')
<style>
    .detail-bg {
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 30px 0 60px 0;
    }
    
    .detail-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    /* Breadcrumb */
    .breadcrumb-custom {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }
    .breadcrumb-custom a {
        color: #1e3a8a;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }
    .breadcrumb-custom a:hover { color: #3b82f6; text-decoration: underline; }
    .breadcrumb-custom .separator { color: #94a3b8; }
    .breadcrumb-custom .current { color: #64748b; }

    /* Card Detail */
    .card-detail {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        background: white;
        overflow: hidden;
        position: relative;
        z-index: 1;
    }

    /* Bagian Atas (Cover & Info Utama) */
    .book-cover-section {
        background: #f8fafc;
        padding: 40px;
        display: flex;
        gap: 40px;
        align-items: flex-start;
        border-bottom: 1px solid #e2e8f0;
    }

    /* Desain Cover Buku */
    .book-cover-img {
        width: 250px;
        height: 350px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }
    .book-cover-img:hover {
        transform: translateY(-5px) scale(1.02);
    }

    /* Desain Jika Tidak Ada Foto (Fallback) */
    .book-cover-fallback {
        width: 250px;
        height: 350px;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 15px 30px rgba(30, 58, 138, 0.3);
        flex-shrink: 0;
    }
    .book-cover-fallback i {
        font-size: 6rem;
        color: white;
        opacity: 0.5;
    }

    /* Info Buku di Samping Cover */
    .book-info-main {
        flex-grow: 1;
    }
    .book-info-main h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.3;
        margin-bottom: 15px;
    }
    .book-meta {
        font-size: 1rem;
        color: #64748b;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .book-meta i { width: 20px; color: #3b82f6; }

    .badge-kategori {
        display: inline-block;
        background: #e0e7ff;
        color: #3730a3;
        padding: 8px 18px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        margin-top: 15px;
        margin-right: 10px;
    }

    .badge-stok {
        display: inline-block;
        padding: 8px 18px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        margin-top: 15px;
    }
    .stok-tersedia { background: #d1fae5; color: #065f46; }
    .stok-habis { background: #fee2e2; color: #991b1b; }

    /* Bagian Bawah (Sinopsis & Tombol) */
    .detail-body { padding: 40px; }

    .section-title {
        font-size: 0.85rem;
        text-transform: uppercase;
        font-weight: 800;
        color: #1e3a8a;
        letter-spacing: 1px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-title::after {
        content: '';
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, #3b82f6, transparent);
        border-radius: 2px;
    }

    .sinopsis-box {
        background: #f8fafc;
        padding: 25px;
        border-radius: 12px;
        font-size: 1rem;
        line-height: 1.8;
        color: #475569;
        border-left: 4px solid #3b82f6;
        margin-bottom: 30px;
    }
    .sinopsis-box.empty {
        font-style: italic;
        color: #94a3b8;
        text-align: center;
    }

    /* Tombol Aksi */
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .btn-action-lg {
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }
    .btn-action-lg:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .btn-back-detail {
        background: white;
        color: #475569;
        border: 2px solid #e2e8f0;
    }
    .btn-back-detail:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .book-cover-section {
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 30px 20px;
        }
        .book-cover-img, .book-cover-fallback {
            width: 200px;
            height: 280px;
            margin-bottom: 20px;
        }
        .book-info-main h1 { font-size: 1.6rem; }
        .book-meta { justify-content: center; }
        .detail-body { padding: 30px 20px; }
    }
</style>

<div class="detail-bg">
    <div class="container">

        <!-- Breadcrumb -->
        <div class="breadcrumb-custom">
            <a href="{{ Auth::check() ? route('buku.index') : route('katalog') }}">
                <i class="fas fa-home me-1"></i>Katalog Buku
            </a>
            <i class="fas fa-chevron-right separator" style="font-size: 0.7rem;"></i>
            <span class="current">Detail Buku</span>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card-detail">
                    
                    <!-- ========================================== -->
                    <!-- BAGIAN ATAS: COVER & INFO UTAMA            -->
                    <!-- ========================================== -->
                    <div class="book-cover-section">
                        
                        <!-- Tampilkan Foto atau Ikon Default -->
                        @if($buku->foto)
                            <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}" class="book-cover-img">
                        @else
                            <div class="book-cover-fallback">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif

                        <div class="book-info-main">
                            <h1>{{ $buku->judul }}</h1>
                            
                            <div class="book-meta">
                                <i class="fas fa-pen-nib"></i> {{ $buku->pengarang }}
                            </div>
                            <div class="book-meta">
                                <i class="fas fa-building"></i> {{ $buku->penerbit ?? '-' }} ({{ $buku->tahun_terbit ?? '-' }})
                            </div>
                            <div class="book-meta">
                                <i class="fas fa-barcode"></i> ISBN: {{ $buku->isbn }}
                            </div>

                            <div>
                                <span class="badge-kategori">
                                    <i class="fas fa-tag me-1"></i> {{ $buku->kategori }}
                                </span>

                                @if($buku->stok > 0)
                                    <span class="badge-stok stok-tersedia">
                                        <i class="fas fa-check-circle me-1"></i> Stok: {{ $buku->stok }} Eksemplar
                                    </span>
                                @else
                                    <span class="badge-stok stok-habis">
                                        <i class="fas fa-times-circle me-1"></i> Stok Habis
                                    </span>
                                @endif
                            </div>

                            {{-- TAMBAHAN: LOKASI RAK --}}
                            @if($buku->lokasi_rak)
                            <div class="mt-4 p-3 rounded" style="background: #fef3c7; border-left: 4px solid #f59e0b;">
                                <h6 class="mb-1 fw-bold text-warning"><i class="fas fa-map-marker-alt me-1"></i>Lokasi Buku</h6>
                                <p class="mb-0 text-dark">Silakan ambil buku ini di: <strong>{{ $buku->lokasi_rak }}</strong></p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- BAGIAN BAWAH: SINOPSIS & TOMBOL            -->
                    <!-- ========================================== -->
                    <div class="detail-body">
                        
                        <div class="section-title">
                            <i class="fas fa-align-left"></i> Sinopsis Buku
                        </div>
                        
                        @if($buku->sinopsis)
                            <div class="sinopsis-box">
                                {{ $buku->sinopsis }}
                            </div>
                        @else
                            <div class="sinopsis-box empty">
                                <i class="fas fa-info-circle me-2"></i> Belum ada sinopsis untuk buku ini.
                            </div>
                        @endif

                        <div class="action-buttons">
                            <a href="{{ Auth::check() ? route('buku.index') : route('katalog') }}" class="btn-action-lg btn-back-detail">
                                <i class="fas fa-arrow-left"></i>Kembali
                            </a>

                            {{-- Tombol Pinjam --}}
                            @if($buku->stok > 0)
                                @auth
                                    @if(Auth::user()->role == 'siswa')
                                        <a href="{{ route('peminjaman.form_ajukan', $buku->id) }}" class="btn-action-lg" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white;">
                                            <i class="fas fa-hand-holding"></i>Pinjam Buku Ini
                                        </a>
                                    @endif
                                @endauth

                                @guest
                                    <a href="{{ route('login') }}" 
                                       class="btn-action-lg"
                                       style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white;"
                                       onclick="return confirm('Silakan login terlebih dahulu untuk meminjam buku ini.')">
                                        <i class="fas fa-hand-holding"></i>Pinjam Buku Ini
                                    </a>
                                @endguest
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection