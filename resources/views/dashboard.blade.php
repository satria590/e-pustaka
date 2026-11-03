@extends('layouts.app')

@section('title', 'Dashboard - e-Pustaka')

@section('content')
<style>
    /* Background dengan pattern */
    .dashboard-bg {
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    
    .dashboard-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    /* CONTAINER LEBAR */
    .container-wide {
        width: 95%;
        max-width: 1500px; /* Lebar maksimal */
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* Floating animation untuk kartu */
    .stat-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 16px;
    }
    
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .stat-card .icon-bg {
        position: absolute;
        right: -15px;
        bottom: -15px;
        font-size: 80px;
        opacity: 0.15;
        color: white;
    }
    
    .stat-card .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    
    /* Card shadow dan efek */
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
    }
    
    .card-modern:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    
    /* Welcome section */
    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 25px 30px;
        color: white;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-section::after {
        content: '📚';
        position: absolute;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 80px;
        opacity: 0.2;
    }
    
    .welcome-section h3 {
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .welcome-section p {
        opacity: 0.9;
        margin-bottom: 0;
    }
    
    /* Quick action buttons */
    .quick-actions .btn {
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .quick-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    /* Chart container */
    .chart-container {
        position: relative;
        height: 280px;
    }
    
    /* List group modern */
    .list-group-modern .list-group-item {
        border: none;
        border-bottom: 1px solid #f1f3f5;
        padding: 12px 0;
        background: transparent;
    }
    
    .list-group-modern .list-group-item:last-child {
        border-bottom: none;
    }
    
    /* Badge status */
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .welcome-section::after {
            display: none;
        }
        
        .stat-card .stat-number {
            font-size: 1.8rem;
        }
        
        .stat-card .icon-bg {
            font-size: 50px;
        }
    }
</style>

<div class="dashboard-bg">
    <div class="container-wide"> <!-- Gunakan container-wide di sini -->
        
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div>
                <h3>👋 Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p>
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ date('l, d F Y') }} | 
                    <span class="badge bg-light text-dark ms-2">
                        <i class="fas fa-user-tag me-1"></i>
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </p>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions mb-4">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('buku.index') }}" class="btn btn-primary">
                    <i class="fas fa-book me-2"></i>Cari Buku
                </a>
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('buku.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Tambah Buku
                    </a>
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-warning text-white">
                        <i class="fas fa-hand-holding me-2"></i>Pinjamkan Buku
                    </a>
                @endif
                <a href="{{ route('peminjaman.index') }}" class="btn btn-info text-white">
                    <i class="fas fa-list me-2"></i>Lihat Peminjaman
                </a>
            </div>
        </div>
        
        <!-- Stat Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card card text-white bg-gradient-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Buku</h6>
                                <h2 class="stat-number">{{ $totalBuku }}</h2>
                                <small class="text-white-50">
                                    <i class="fas fa-arrow-up me-1"></i>Judul buku tersedia
                                </small>
                            </div>
                            <i class="icon-bg fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card card text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Anggota</h6>
                                <h2 class="stat-number">{{ $totalAnggota }}</h2>
                                <small class="text-white-50">
                                    <i class="fas fa-user-plus me-1"></i>Pengguna terdaftar
                                </small>
                            </div>
                            <i class="icon-bg fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Peminjaman</h6>
                                <h2 class="stat-number">{{ $totalPeminjaman }}</h2>
                                <small class="text-white-50">
                                    <i class="fas fa-clock me-1"></i>Transaksi peminjaman
                                </small>
                            </div>
                            <i class="icon-bg fas fa-hand-holding"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card card text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 text-uppercase fw-bold mb-1">Dipinjam Aktif</h6>
                                <h2 class="stat-number">{{ $peminjamanAktif }}</h2>
                                <small class="text-white-50">
                                    <i class="fas fa-spinner me-1"></i>Buku sedang dipinjam
                                </small>
                            </div>
                            <i class="icon-bg fas fa-book-reader"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Chart and Notifications -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card-modern card">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>
                            Statistik Peminjaman per Bulan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartPeminjaman"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card-modern card">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-bell me-2 text-warning"></i>
                            Notifikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-modern">
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-3">
                                    <span class="badge bg-success rounded-circle p-2">
                                        <i class="fas fa-check fa-sm"></i>
                                    </span>
                                </div>
                                <div>
                                    <small class="d-block fw-bold">Sistem berjalan normal</small>
                                    <small class="text-muted">Status: OK</small>
                                </div>
                            </div>
                            
                            @if($totalBuku == 0)
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-3">
                                    <span class="badge bg-warning rounded-circle p-2">
                                        <i class="fas fa-exclamation fa-sm"></i>
                                    </span>
                                </div>
                                <div>
                                    <small class="d-block fw-bold">Belum ada buku</small>
                                    <small class="text-muted">Tambahkan buku sekarang</small>
                                </div>
                            </div>
                            @endif
                            
                            @if($peminjamanAktif > 0)
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-3">
                                    <span class="badge bg-info rounded-circle p-2">
                                        <i class="fas fa-info fa-sm"></i>
                                    </span>
                                </div>
                                <div>
                                    <small class="d-block fw-bold">{{ $peminjamanAktif }} buku dipinjam</small>
                                    <small class="text-muted">Aktif saat ini</small>
                                </div>
                            </div>
                            @endif
                            
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-circle p-2">
                                        <i class="fas fa-users fa-sm"></i>
                                    </span>
                                </div>
                                <div>
                                    <small class="d-block fw-bold">{{ $totalAnggota }} anggota</small>
                                    <small class="text-muted">Terdaftar di sistem</small>
                                </div>
                            </div>
                            
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-3">
                                    <span class="badge bg-danger rounded-circle p-2">
                                        <i class="fas fa-heart fa-sm"></i>
                                    </span>
                                </div>
                                <div>
                                    <small class="d-block fw-bold">e-Pustaka v1.0</small>
                                    <small class="text-muted">Made with ❤️</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity / Buku Terbaru -->
        <div class="row">
            <div class="col-12">
                <div class="card-modern card">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-clock me-2 text-primary"></i>
                            Buku Terbaru
                        </h5>
                        <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @php
                                $bukus = App\Models\Buku::latest()->take(4)->get(); // Ubah take(3) jadi 4
                            @endphp
                            @forelse($bukus as $buku)
                            <div class="col-md-6 col-xl-3 mb-3"> <!-- Ubah grid agar rapi -->
                                <div class="d-flex align-items-center p-3 border rounded-3 h-100" style="background: #f8f9fa;">
                                    <div class="bg-primary text-white rounded-3 p-3 me-3">
                                        <i class="fas fa-book fa-2x"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold" style="font-size: 0.9rem;">{{ Str::limit($buku->judul, 30) }}</h6>
                                        <small class="text-muted d-block mb-2" style="font-size: 0.75rem;">
                                            <i class="fas fa-user me-1"></i>{{ $buku->pengarang }}
                                        </small>
                                        <span class="badge bg-success" style="font-size: 0.7rem;">Stok: {{ $buku->stok }}</span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center text-muted py-4">
                                <i class="fas fa-book-open fa-2x mb-3 text-muted"></i>
                                <p>Belum ada buku</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('chartPeminjaman');
    
    if (!canvas) {
        console.log('Chart element not found');
        return;
    }
    
    const ctx = canvas.getContext('2d');
    const chartData = @json($chartData);
    
    // Siapkan data untuk 12 bulan
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
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(118, 75, 162, 0.8)',
                    'rgba(17, 153, 142, 0.8)',
                    'rgba(56, 239, 125, 0.8)',
                    'rgba(240, 147, 251, 0.8)',
                    'rgba(245, 87, 108, 0.8)',
                    'rgba(79, 172, 254, 0.8)',
                    'rgba(0, 242, 254, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(255, 87, 34, 0.8)',
                    'rgba(233, 30, 99, 0.8)',
                    'rgba(63, 81, 181, 0.8)'
                ],
                borderColor: '#667eea',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: true, color: 'rgba(0,0,0,0.05)' },
                    ticks: { stepSize: 1, font: { size: 11 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
});
</script>
@endpush