@extends('layouts.app')

@section('title', 'Dashboard - e-Pustaka')

@section('content')
<style>
    /* Background dengan pattern */
    .dashboard-bg {
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 25px 0 60px 0;
    }
    
    .dashboard-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    /* CONTAINER LEBAR (Menghilangkan sela di pinggir) */
    .container-wide {
        width: 95%;
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* Header Modern */
    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 30px 40px;
        color: white;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.25);
    }
    
    .welcome-section::after {
        content: '📚';
        position: absolute;
        right: 40px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 100px;
        opacity: 0.15;
    }
    
    .welcome-section h3 { font-weight: 700; margin-bottom: 8px; font-size: 1.8rem; }
    .welcome-section p { opacity: 0.9; margin-bottom: 0; font-size: 1rem; }

    /* Card Modern */
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        height: 100%;
    }
    
    .card-modern:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.1); }

    /* Tombol Aksi */
    .quick-actions .btn {
        border-radius: 12px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .quick-actions .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    /* Stat Cards (Khusus Admin) */
    .stat-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 16px;
        height: 100%;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.15); }
    .stat-card .icon-bg {
        position: absolute; right: -10px; bottom: -15px;
        font-size: 80px; opacity: 0.15; color: white;
    }
    .stat-card .stat-number { font-size: 2.5rem; font-weight: 700; margin-bottom: 0; }

    /* Chart Container */
    .chart-container { position: relative; height: 300px; width: 100%; }
    
    /* List Group Notifikasi */
    .list-group-modern .list-group-item {
        border: none; border-bottom: 1px solid #f1f3f5;
        padding: 15px 0; background: transparent;
    }
    .list-group-modern .list-group-item:last-child { border-bottom: none; }

    /* Buku Terbaru */
    .buku-terbaru-item {
        background: #f8f9fa; border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    .buku-terbaru-item:hover {
        background: white; border-color: #667eea;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
    }

    /* Welcome Card Khusus Siswa */
    .student-welcome {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white; border-radius: 20px; padding: 40px;
        text-align: center; box-shadow: 0 10px 30px rgba(17, 153, 142, 0.25);
        margin-bottom: 30px;
    }
    .student-welcome i { font-size: 4rem; margin-bottom: 20px; opacity: 0.8; }

    @media (max-width: 768px) {
        .welcome-section::after { display: none; }
        .welcome-section { padding: 25px 20px; }
        .stat-card .stat-number { font-size: 1.8rem; }
        .stat-card .icon-bg { font-size: 50px; }
    }
</style>

<div class="dashboard-bg">
    <div class="container-wide"> <!-- Container lebar agar tidak ada sela -->
        
        <!-- ============================================== -->
        <!-- TAMPILAN UNTUK SISWA (TANPA STATISTIK)         -->
        <!-- ============================================== -->
        @if(Auth::user()->role == 'siswa')
            
            <div class="welcome-section">
                <div>
                    <h3>👋 Halo, {{ Auth::user()->name }}!</h3>
                    <p>
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{ date('l, d F Y') }} | 
                        <span class="badge bg-light text-dark ms-2 px-3 py-2 rounded-pill">
                            <i class="fas fa-user-tag me-1"></i> Siswa
                        </span>
                    </p>
                </div>
            </div>

            <div class="quick-actions mb-4">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('buku.index') }}" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari & Pinjam Buku
                    </a>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-info text-white">
                        <i class="fas fa-history"></i> Riwayat Peminjaman Saya
                    </a>
                </div>
            </div>

            <!-- Kartu Ucapan / Banner Khusus Siswa -->
            <div class="student-welcome">
                <i class="fas fa-book-reader"></i>
                <h3 class="fw-bold">Mari Tingkatkan Literasi!</h3>
                <p class="mb-0" style="font-size: 1.1rem; opacity: 0.9;">
                    Temukan buku favoritmu di katalog dan ajukan peminjaman secara online. <br>
                    Jangan lupa kembalikan tepat waktu ya!
                </p>
            </div>

            <!-- Koleksi Buku Terbaru (Untuk Siswa) -->
            <div class="row">
                <div class="col-12">
                    <div class="card-modern card">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-star me-2 text-warning"></i> Rekomendasi Buku Terbaru
                            </h5>
                            <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                @php
                                    $bukus = App\Models\Buku::latest()->take(4)->get();
                                @endphp
                                @forelse($bukus as $buku)
                                <div class="col-md-6 col-xl-3"> 
                                    <div class="buku-terbaru-item d-flex align-items-center p-3 rounded-3 h-100">
                                        <div class="bg-primary text-white rounded-3 p-3 me-3 shadow-sm">
                                            <i class="fas fa-book fa-2x"></i>
                                        </div>
                                        <div class="overflow-hidden">
                                            <h6 class="mb-1 fw-bold text-truncate" style="font-size: 0.95rem;" title="{{ $buku->judul }}">
                                                {{ $buku->judul }}
                                            </h6>
                                            <small class="text-muted d-block text-truncate mb-2" style="font-size: 0.8rem;">
                                                <i class="fas fa-pen-nib me-1"></i>{{ $buku->pengarang }}
                                            </small>
                                            <span class="badge bg-success" style="font-size: 0.75rem;">Stok: {{ $buku->stok }}</span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center text-muted py-4">
                                    <p>Belum ada buku.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
        <!-- ============================================== -->
        <!-- TAMPILAN UNTUK ADMIN (DENGAN STATISTIK)        -->
        <!-- ============================================== -->
            
            <div class="welcome-section">
                <div>
                    <h3>👋 Selamat Datang, Admin {{ Auth::user()->name }}!</h3>
                    <p>
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{ date('l, d F Y') }} | 
                        <span class="badge bg-light text-dark ms-2 px-3 py-2 rounded-pill">
                            <i class="fas fa-shield-alt me-1"></i> Administrator
                        </span>
                    </p>
                </div>
            </div>

            <div class="quick-actions mb-4">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('buku.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Buku Baru
                    </a>
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-warning text-white">
                        <i class="fas fa-hand-holding"></i> Pinjamkan Buku (Offline)
                    </a>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-info text-white">
                        <i class="fas fa-list"></i> Verifikasi Peminjaman
                    </a>
                </div>
            </div>

            <!-- Stat Cards Admin -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body position-relative z-1">
                            <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Buku</h6>
                            <h2 class="stat-number">{{ $totalBuku }}</h2>
                            <small class="text-white-50"><i class="fas fa-book me-1"></i> Judul tersedia</small>
                            <i class="icon-bg fas fa-book"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card card text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <div class="card-body position-relative z-1">
                            <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Anggota</h6>
                            <h2 class="stat-number">{{ $totalAnggota }}</h2>
                            <small class="text-white-50"><i class="fas fa-users me-1"></i> Pengguna terdaftar</small>
                            <i class="icon-bg fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div class="card-body position-relative z-1">
                            <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Peminjaman</h6>
                            <h2 class="stat-number">{{ $totalPeminjaman }}</h2>
                            <small class="text-white-50"><i class="fas fa-history me-1"></i> Transaksi</small>
                            <i class="icon-bg fas fa-hand-holding"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card card text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="card-body position-relative z-1">
                            <h6 class="text-white-50 text-uppercase fw-bold mb-1">Dipinjam Aktif</h6>
                            <h2 class="stat-number">{{ $peminjamanAktif }}</h2>
                            <small class="text-white-50"><i class="fas fa-spinner me-1"></i> Sedang dipinjam</small>
                            <i class="icon-bg fas fa-book-reader"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart & Notifikasi Admin -->
            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="card-modern card">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-chart-bar me-2 text-primary"></i> Statistik Peminjaman</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="chart-container">
                                <canvas id="chartPeminjaman"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card-modern card">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-bell me-2 text-warning"></i> Notifikasi</h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="list-group list-group-modern">
                                <div class="list-group-item d-flex align-items-center">
                                    <div class="me-3"><span class="badge bg-success rounded-circle p-2"><i class="fas fa-check fa-sm"></i></span></div>
                                    <div><small class="d-block fw-bold">Sistem berjalan normal</small><small class="text-muted">Status: OK</small></div>
                                </div>
                                @if($peminjamanAktif > 0)
                                <div class="list-group-item d-flex align-items-center">
                                    <div class="me-3"><span class="badge bg-info rounded-circle p-2"><i class="fas fa-info fa-sm"></i></span></div>
                                    <div><small class="d-block fw-bold">{{ $peminjamanAktif }} buku dipinjam</small><small class="text-muted">Aktif saat ini</small></div>
                                </div>
                                @endif
                                <div class="list-group-item d-flex align-items-center">
                                    <div class="me-3"><span class="badge bg-primary rounded-circle p-2"><i class="fas fa-users fa-sm"></i></span></div>
                                    <div><small class="d-block fw-bold">{{ $totalAnggota }} anggota</small><small class="text-muted">Terdaftar</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buku Terbaru Admin -->
            <div class="row">
                <div class="col-12">
                    <div class="card-modern card">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-clock me-2 text-primary"></i> Koleksi Buku Terbaru</h5>
                            <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                @php $bukus = App\Models\Buku::latest()->take(4)->get(); @endphp
                                @forelse($bukus as $buku)
                                <div class="col-md-6 col-xl-3"> 
                                    <div class="buku-terbaru-item d-flex align-items-center p-3 rounded-3 h-100">
                                        <div class="bg-primary text-white rounded-3 p-3 me-3 shadow-sm"><i class="fas fa-book fa-2x"></i></div>
                                        <div class="overflow-hidden">
                                            <h6 class="mb-1 fw-bold text-truncate" style="font-size: 0.95rem;">{{ $buku->judul }}</h6>
                                            <small class="text-muted d-block text-truncate mb-2" style="font-size: 0.8rem;"><i class="fas fa-pen-nib me-1"></i>{{ $buku->pengarang }}</small>
                                            <span class="badge bg-success" style="font-size: 0.75rem;">Stok: {{ $buku->stok }}</span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center text-muted py-4"><p>Belum ada buku.</p></div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    </div>
</div>
@endsection

@push('scripts')
@if(Auth::user()->role == 'admin')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('chartPeminjaman');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    const chartData = @json($chartData);
    const bulanData = Array(12).fill(0);
    
    if (chartData && chartData.length > 0) {
        chartData.forEach(function(item) {
            if (item.bulan >= 1 && item.bulan <= 12) {
                bulanData[item.bulan - 1] = item.total;
            }
        });
    }
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: bulanData,
                backgroundColor: 'rgba(102, 126, 234, 0.8)',
                borderColor: '#667eea',
                borderWidth: 1.5,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: true, color: 'rgba(0,0,0,0.05)' }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endif
@endpush