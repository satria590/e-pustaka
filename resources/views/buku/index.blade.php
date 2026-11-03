@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<style>
    .katalog-bg {
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    
    .katalog-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }
    
    .header-katalog {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .header-katalog::after {
        content: '📚';
        position: absolute;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 80px;
        opacity: 0.15;
    }
    
    .header-katalog h4 { font-weight: 600; margin-bottom: 5px; }
    .header-katalog p { opacity: 0.9; margin-bottom: 0; }
    
    .card-buku {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        height: 100%;
        overflow: hidden;
    }
    
    .card-buku:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    }
    
    .card-buku .card-header-buku {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 15px 20px;
        color: white;
        position: relative;
    }
    
    .card-buku .card-header-buku .book-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 40px;
        opacity: 0.2;
    }
    
    .card-buku .card-body { padding: 20px; }
    .card-buku .card-body .judul {
        font-weight: 600; font-size: 1.1rem;
        margin-bottom: 8px; color: #2d3436;
    }
    .card-buku .card-body .pengarang {
        color: #636e72; font-size: 0.9rem; margin-bottom: 4px;
    }
    .card-buku .card-body .kategori {
        display: inline-block; padding: 3px 12px;
        border-radius: 20px; font-size: 0.75rem;
        font-weight: 500; margin-bottom: 10px;
    }
    .card-buku .card-footer {
        background: transparent; border-top: 1px solid #f1f3f5;
        padding: 15px 20px; display: flex;
        justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 8px;
    }
    
    .btn-action {
        border-radius: 10px; padding: 6px 14px;
        font-size: 0.8rem; font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-action:hover { transform: translateY(-2px); }
    
    .stok-badge {
        padding: 4px 14px; border-radius: 20px;
        font-weight: 600; font-size: 0.8rem;
    }
    
    .search-box {
        border-radius: 12px; border: 2px solid #e9ecef;
        padding: 10px 18px; transition: all 0.3s ease;
        background: white;
    }
    .search-box:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
    }
    
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state .empty-icon {
        font-size: 80px; color: #b2bec3; margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .header-katalog::after { display: none; }
        .card-buku .card-footer {
            flex-direction: column; align-items: stretch;
        }
    }
</style>

<div class="katalog-bg">
    <div class="container">
        <!-- Header -->
        <div class="header-katalog">
            <div>
                <h4><i class="fas fa-book-open me-2"></i>Katalog Buku</h4>
                <p><i class="fas fa-search me-2"></i>Temukan koleksi buku favorit Anda</p>
                <div class="mt-2">
                    <span class="badge bg-light text-dark me-2">
                        <i class="fas fa-book me-1"></i>Total: {{ $bukus->total() }} buku
                    </span>
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-tag me-1"></i>{{ $bukus->count() }} ditampilkan
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Search & Actions -->
        <div class="row mb-4">
            <div class="col-md-8">
                <form action="{{ Auth::check() ? route('buku.search') : route('katalog.search') }}" method="GET" class="d-flex gap-2">
                    <div class="flex-grow-1">
                        <input type="text" name="keyword" class="form-control search-box" 
                               placeholder="🔍 Cari buku berdasarkan judul, pengarang, atau kategori..."
                               value="{{ request('keyword') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                    @if(request('keyword'))
                        <a href="{{ Auth::check() ? route('buku.index') : route('katalog') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>Reset
                        </a>
                    @endif
                </form>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                @auth
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('buku.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>Tambah Buku
                        </a>
                    @endif
                @endauth
            </div>
        </div>
        
        <!-- Books Grid -->
        <div class="row">
            @forelse($bukus as $buku)
            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="card-buku">
                    <div class="card-header-buku">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">{{ Str::limit($buku->judul, 30) }}</span>
                            <i class="book-icon fas fa-book"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="judul">{{ Str::limit($buku->judul, 40) }}</div>
                        <div class="pengarang">
                            <i class="fas fa-user me-1"></i>{{ $buku->pengarang }}
                        </div>
                        <div class="kategori" style="background: {{ $buku->kategori == 'Teknologi' ? '#dfe6e9' : ($buku->kategori == 'Sains' ? '#d4edda' : '#fff3cd') }}; color: {{ $buku->kategori == 'Teknologi' ? '#2d3436' : ($buku->kategori == 'Sains' ? '#155724' : '#856404') }};">
                            <i class="fas fa-tag me-1"></i>{{ $buku->kategori }}
                        </div>
                        <div class="mt-2">
                            <span class="stok-badge bg-{{ $buku->stok > 0 ? 'success' : 'danger' }} text-white">
                                <i class="fas fa-{{ $buku->stok > 0 ? 'check-circle' : 'times-circle' }} me-1"></i>
                                Stok: {{ $buku->stok }}
                            </span>
                            <small class="text-muted ms-2">
                                <i class="fas fa-barcode me-1"></i>{{ $buku->isbn }}
                            </small>
                        </div>
                        @if($buku->sinopsis)
                            <p class="text-muted mt-2" style="font-size: 0.85rem;">
                                {{ Str::limit($buku->sinopsis, 80) }}
                            </p>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-1">
                            <a href="{{ Auth::check() ? route('buku.show', $buku->id) : route('katalog.show', $buku->id) }}" 
                               class="btn btn-sm btn-info btn-action text-white">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            
                            {{-- Tombol Edit & Delete: hanya admin --}}
                            @auth
                                @if(Auth::user()->role == 'admin')
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning btn-action">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Yakin hapus?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>

                        {{-- ============ TOMBOL PINJAM ============ --}}
                        @if($buku->stok > 0)
                            @auth
                                @if(Auth::user()->role == 'siswa')
                                    <a href="{{ route('peminjaman.form_ajukan', $buku->id) }}" class="btn btn-sm btn-primary btn-action">
                                        <i class="fas fa-hand-holding"></i> Pinjam
                                    </a>
                                @endif
                            @endauth

                            @guest
                                {{-- Kalau belum login, arahkan ke login --}}
                                <a href="{{ route('login') }}" 
                                   class="btn btn-sm btn-primary btn-action"
                                   onclick="return confirm('Silakan login terlebih dahulu untuk meminjam buku ini.')">
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
                    <div class="empty-icon"><i class="fas fa-book-open"></i></div>
                    <h4 class="text-muted">Belum ada buku dalam katalog</h4>
                    @auth
                        @if(Auth::user()->role == 'admin')
                            <p class="text-muted">Mulai tambahkan koleksi buku pertama Anda</p>
                            <a href="{{ route('buku.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-1"></i>Tambah Buku Sekarang
                            </a>
                        @else
                            <p class="text-muted">Silakan cek kembali nanti</p>
                        @endif
                    @endauth

                    @guest
                        <p class="text-muted">Silakan cek kembali nanti</p>
                    @endguest
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $bukus->links() }}
        </div>
    </div>
</div>
@endsection