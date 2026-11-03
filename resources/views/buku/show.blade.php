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
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }
    .breadcrumb-custom a:hover {
        color: #764ba2;
        text-decoration: underline;
    }
    .breadcrumb-custom .separator { color: #adb5bd; }
    .breadcrumb-custom .current { color: #6c757d; }

    /* Card Detail */
    .card-detail {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        overflow: hidden;
        position: relative;
        z-index: 1;
    }

    /* Header Cover Buku */
    .book-cover-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 30px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .book-cover-header::after {
        content: '📖';
        position: absolute;
        right: 30px;
        bottom: -20px;
        font-size: 130px;
        opacity: 0.15;
    }

    .book-cover-icon {
        width: 100px;
        height: 130px;
        background: rgba(255,255,255,0.15);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        margin-bottom: 20px;
        border: 2px solid rgba(255,255,255,0.3);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .book-cover-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 10px 0;
        line-height: 1.3;
    }

    .book-cover-header .meta-line {
        opacity: 0.9;
        font-size: 0.95rem;
        margin-bottom: 8px;
    }

    .book-cover-header .meta-line i { width: 20px; }

    /* Badge */
    .badge-detail {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-right: 8px;
        margin-bottom: 8px;
    }

    .badge-stok-tersedia { background: #d4edda; color: #155724; }
    .badge-stok-habis { background: #f8d7da; color: #721c24; }
    .badge-kategori { background: rgba(255,255,255,0.25); color: white; }

    /* Body */
    .detail-body { padding: 30px; }

    .section-title {
        font-size: 0.85rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #667eea;
        letter-spacing: 1px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title::after {
        content: '';
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, #667eea, transparent);
        border-radius: 2px;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 30px;
    }

    .info-item {
        background: #f8f9fa;
        padding: 15px 18px;
        border-radius: 12px;
        border-left: 3px solid #667eea;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
    }

    .info-item .info-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .info-item .info-value {
        font-size: 1rem;
        color: #2d3436;
        font-weight: 600;
    }

    /* Sinopsis */
    .sinopsis-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 20px 25px;
        border-radius: 12px;
        font-size: 0.95rem;
        line-height: 1.7;
        color: #495057;
        border-left: 4px solid #764ba2;
        margin-bottom: 30px;
    }

    .sinopsis-box.empty {
        font-style: italic;
        color: #adb5bd;
        text-align: center;
    }

    /* Tombol Aksi */
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 1px solid #f1f3f5;
    }

    .btn-action-lg {
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }

    .btn-action-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .btn-back-detail {
        background: white;
        color: #495057;
        border: 2px solid #e9ecef;
    }
    .btn-back-detail:hover {
        background: #f8f9fa;
        color: #495057;
    }

    /* Sidebar Aksi Admin */
    .admin-panel {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 25px;
        color: white;
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
    }
    .admin-panel h5 {
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 1.05rem;
    }
    .admin-panel .btn {
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
    }
    .admin-panel .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    /* Sidebar Statistik */
    .stats-panel {
        background: white;
        border-radius: 16px;
        padding: 25px;
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        margin-top: 20px;
    }
    .stats-panel h5 {
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 1rem;
        color: #2d3436;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .stat-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f1f3f5;
    }
    .stat-row:last-child { border-bottom: none; }
    .stat-row .stat-label { font-size: 0.9rem; color: #6c757d; }
    .stat-row .stat-value { font-weight: 700; color: #2d3436; }

    @media (max-width: 768px) {
        .book-cover-header h1 { font-size: 1.3rem; }
        .info-grid { grid-template-columns: 1fr; }
        .book-cover-header::after { display: none; }
        .admin-panel { margin-top: 20px; }
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

        <div class="row g-4">
            <!-- KOLOM KIRI: Detail Buku -->
            <div class="col-lg-8">
                <div class="card-detail">
                    <!-- Header Cover -->
                    <div class="book-cover-header">
                        <div class="book-cover-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h1>{{ $buku->judul }}</h1>
                        <div class="meta-line">
                            <i class="fas fa-user-edit"></i>{{ $buku->pengarang }}
                        </div>
                        <div class="meta-line">
                            <i class="fas fa-building"></i>{{ $buku->penerbit ?? '-' }}
                            &nbsp;|&nbsp;
                            <i class="fas fa-calendar"></i>{{ $buku->tahun_terbit ?? '-' }}
                        </div>
                        <div class="mt-3">
                            <span class="badge-detail badge-kategori">
                                <i class="fas fa-tag me-1"></i>{{ $buku->kategori }}
                            </span>
                            @if($buku->stok > 0)
                                <span class="badge-detail badge-stok-tersedia">
                                    <i class="fas fa-check-circle me-1"></i>Tersedia ({{ $buku->stok }} eksemplar)
                                </span>
                            @else
                                <span class="badge-detail badge-stok-habis">
                                    <i class="fas fa-times-circle me-1"></i>Stok Habis
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="detail-body">

                        <!-- Informasi Buku -->
                        <div class="section-title">
                            <i class="fas fa-info-circle"></i>Informasi Buku
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">ISBN</div>
                                <div class="info-value">
                                    <i class="fas fa-barcode me-2 text-muted"></i>{{ $buku->isbn }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Kategori</div>
                                <div class="info-value">
                                    <i class="fas fa-tag me-2 text-muted"></i>{{ $buku->kategori }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Pengarang</div>
                                <div class="info-value">
                                    <i class="fas fa-user-edit me-2 text-muted"></i>{{ $buku->pengarang }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Penerbit</div>
                                <div class="info-value">
                                    <i class="fas fa-building me-2 text-muted"></i>{{ $buku->penerbit ?? '-' }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Tahun Terbit</div>
                                <div class="info-value">
                                    <i class="fas fa-calendar me-2 text-muted"></i>{{ $buku->tahun_terbit ?? '-' }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Stok Tersedia</div>
                                <div class="info-value">
                                    <i class="fas fa-boxes me-2 text-muted"></i>{{ $buku->stok }} eksemplar
                                </div>
                            </div>
                        </div>

                        <!-- Sinopsis -->
                        <div class="section-title">
                            <i class="fas fa-align-left"></i>Sinopsis
                        </div>
                        @if($buku->sinopsis)
                            <div class="sinopsis-box">
                                {{ $buku->sinopsis }}
                            </div>
                        @else
                            <div class="sinopsis-box empty">
                                <i class="fas fa-info-circle me-2"></i>
                                Belum ada sinopsis untuk buku ini
                            </div>
                        @endif

                        <!-- Tombol Aksi -->
                        <div class="action-buttons">
                            <a href="{{ Auth::check() ? route('buku.index') : route('katalog') }}" class="btn-action-lg btn-back-detail">
                                <i class="fas fa-arrow-left"></i>Kembali
                            </a>

                            {{-- Tombol Pinjam --}}
                            @if($buku->stok > 0)
                                @auth
                                    @if(Auth::user()->role == 'siswa')
                                        <form action="{{ route('peminjaman.ajukan') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                            <button type="submit" class="btn-action-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                <i class="fas fa-hand-holding"></i>Pinjam Buku Ini
                                            </button>
                                        </form>
                                    @endif
                                @endauth

                                @guest
                                    <a href="{{ route('login') }}" 
                                       class="btn-action-lg"
                                       style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;"
                                       onclick="return confirm('Silakan login terlebih dahulu untuk meminjam buku ini.')">
                                        <i class="fas fa-hand-holding"></i>Pinjam Buku Ini
                                    </a>
                                @endguest
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: Sidebar -->
            <div class="col-lg-4">

                {{-- Panel Admin --}}
                @auth
                    @if(Auth::user()->role == 'admin')
                    <div class="admin-panel">
                        <h5><i class="fas fa-tools me-2"></i>Menu Admin</h5>
                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i>Edit Buku
                        </a>
                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Yakin hapus buku ini?')">
                                <i class="fas fa-trash"></i>Hapus Buku
                            </button>
                        </form>
                        <a href="{{ route('buku.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i>Tambah Buku Baru
                        </a>
                    </div>
                    @endif
                @endauth

                {{-- Panel Statistik --}}
                <div class="stats-panel">
                    <h5><i class="fas fa-chart-line text-primary"></i>Statistik Buku</h5>
                    <div class="stat-row">
                        <span class="stat-label">Kode Buku</span>
                        <span class="stat-value">#{{ str_pad($buku->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Total Stok</span>
                        <span class="stat-value">{{ $buku->stok }} eksemplar</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Status</span>
                        <span class="stat-value">
                            @if($buku->stok > 0)
                                <span class="text-success">● Tersedia</span>
                            @else
                                <span class="text-danger">● Habis</span>
                            @endif
                        </span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Ditambahkan</span>
                        <span class="stat-value" style="font-size: 0.85rem;">
                            {{ $buku->created_at ? $buku->created_at->format('d M Y') : '-' }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection