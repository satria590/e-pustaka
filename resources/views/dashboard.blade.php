@extends('layouts.app')

@section('title', 'Dashboard - e-Pustaka')

@section('content')
<style>
    /* Background Utama */
    .dashboard-bg {
        position: relative;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        min-height: 100vh;
        padding: 25px 0 60px 0;
    }

    .container-wide { width: 95%; max-width: 1400px; margin: 0 auto; position: relative; z-index: 1; }

    /* Header Siswa */
    .student-header {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        border-radius: 24px; padding: 40px; color: white; margin-bottom: 30px;
        position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }
    .student-header::after { content: '📚'; position: absolute; right: 40px; top: 50%; transform: translateY(-50%); font-size: 120px; opacity: 0.15; }
    .student-header h3 { font-weight: 800; font-size: 2rem; margin-bottom: 10px; }
    .student-header p { font-size: 1.1rem; opacity: 0.9; margin-bottom: 0; }

    /* Tombol Aksi Cepat */
    .action-btn { background: white; color: #047857; border-radius: 16px; padding: 15px 25px; font-weight: 700; font-size: 1rem; display: inline-flex; align-items: center; gap: 10px; text-decoration: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: all 0.3s ease; border: 2px solid transparent; }
    .action-btn:hover { background: #ecfdf5; color: #059669; border-color: #10b981; transform: translateY(-3px); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2); }
    .action-btn-primary { background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); }
    .action-btn-primary:hover { background: linear-gradient(135deg, #047857 0%, #059669 100%); color: white; border-color: transparent; }

    /* Statistik Mini */
    .mini-stat-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 15px; height: 100%; transition: all 0.3s ease; }
    .mini-stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(16, 185, 129, 0.15); border-color: #10b981; }
    .mini-stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; transition: transform 0.3s ease; }
    .mini-stat-card:hover .mini-stat-icon { transform: scale(1.1) rotate(-5deg); }
    .mini-stat-text h6 { margin: 0; font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase; }
    .mini-stat-text h3 { margin: 0; font-size: 1.5rem; font-weight: 800; color: #1e293b; }

    /* Kartu Motivasi */
    .motivation-card { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 20px; padding: 30px; text-align: center; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #92400e; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.15); }
    .motivation-card i { font-size: 3rem; margin-bottom: 15px; color: #d97706; }
    .motivation-card h5 { font-weight: 800; font-size: 1.3rem; margin-bottom: 10px; }
    .motivation-card p { font-size: 0.95rem; opacity: 0.8; margin: 0; }

    /* Kartu Pinjaman Aktif */
    .loan-card { background: #f8fafc; border: 1px solid #e2e8f0; border-left: 5px solid #10b981; border-radius: 12px; padding: 15px; height: 100%; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s ease; }
    .loan-card:hover { background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-color: #10b981; }
    .loan-card h6 { font-weight: 800; color: #1e293b; margin-bottom: 5px; font-size: 0.95rem; }
    .loan-card p { color: #64748b; font-size: 0.8rem; margin-bottom: 10px; }
    .loan-card-terlambat { border-left-color: #ef4444; background: #fef2f2; }
    .loan-card-terlambat:hover { border-color: #ef4444; }

    /* Card Buku Rekomendasi */
    .card-rekomendasi { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: all 0.3s ease; height: 100%; border: 1px solid #e2e8f0; display: flex; flex-direction: column; }
    .card-rekomendasi:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(16, 185, 129, 0.15); border-color: #10b981; }
    .cover-rekomendasi { height: 180px; overflow: hidden; position: relative; }
    .cover-rekomendasi img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
    .card-rekomendasi:hover .cover-rekomendasi img { transform: scale(1.1); }
    .cover-rekomendasi-fallback { width: 100%; height: 100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display: flex; align-items: center; justify-content: center; }
    .cover-rekomendasi-fallback i { font-size: 4rem; color: white; opacity: 0.3; }
    .body-rekomendasi { padding: 15px; flex-grow: 1; display: flex; flex-direction: column; }
    .body-rekomendasi h6 { font-weight: 700; font-size: 1rem; color: #1e293b; margin-bottom: 5px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .body-rekomendasi p { font-size: 0.8rem; color: #64748b; margin-bottom: 10px; flex-grow: 1; }

    /* Card Modern */
    .card-modern { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); background: white; height: 100%; }

    /* Quote Banner (Pengganti Kategori) */
    .quote-banner {
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-left: 6px solid #3b82f6;
        border-radius: 16px;
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .quote-banner i.big-quote {
        font-size: 4rem;
        color: #bfdbfe;
        flex-shrink: 0;
    }
    .quote-text h5 { font-weight: 800; color: #1e293b; margin-bottom: 8px; }
    .quote-text p { font-size: 1.05rem; color: #64748b; font-style: italic; margin: 0; }

    @media (max-width: 768px) {
        .student-header::after { display: none; }
        .student-header { padding: 25px 20px; }
        .student-header h3 { font-size: 1.5rem; }
        .quote-banner { flex-direction: column; text-align: center; gap: 10px; }
    }
</style>

<div class="dashboard-bg">
    <div class="container-wide">
        
        <!-- TAMPILAN UNTUK SISWA -->
        @if(Auth::user()->role == 'siswa')
            
            <div class="student-header">
                <h3>👋 Halo, {{ Auth::user()->name }}!</h3>
                <p>Selamat datang di perpustakaan digital. Mau baca buku apa hari ini?</p>
            </div>

            {{-- PERINGATAN KETERLAMBATAN --}}
            @if(isset($adaKeterlambatan) && $adaKeterlambatan)
            <div class="alert alert-danger d-flex align-items-center shadow-sm border-0 mb-4" style="border-radius: 16px; background: #fef2f2; border-left: 5px solid #ef4444 !important;">
                <i class="fas fa-exclamation-triangle fa-2x text-danger me-3"></i>
                <div>
                    <h5 class="fw-bold text-danger mb-1">Peringatan Keterlambatan!</h5>
                    <p class="mb-0 text-danger" style="opacity: 0.9;">Anda memiliki buku yang melewati batas pengembalian. Mohon segera kembalikan ke perpustakaan untuk menghindari denda yang terus bertambah.</p>
                </div>
            </div>
            @endif

            <div class="d-flex flex-wrap gap-3 mb-4">
                <a href="{{ route('buku.index') }}" class="action-btn action-btn-primary">
                    <i class="fas fa-search"></i> Cari & Pinjam Buku
                </a>
                <a href="{{ route('peminjaman.index') }}" class="action-btn">
                    <i class="fas fa-history"></i> Riwayat Pinjam Saya
                </a>
            </div>

            <!-- Statistik Mini -->
            <div class="row g-4 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="mini-stat-card">
                        <div class="mini-stat-icon bg-primary bg-opacity-10 text-primary"><i class="fas fa-book-reader"></i></div>
                        <div class="mini-stat-text"><h6>Total Dipinjam</h6><h3>{{ $totalPinjamSiswa ?? 0 }} Buku</h3></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="mini-stat-card">
                        <div class="mini-stat-icon bg-warning bg-opacity-10 text-warning"><i class="fas fa-clock"></i></div>
                        <div class="mini-stat-text"><h6>Sedang Dipinjam</h6><h3>{{ $pinjamAktifSiswa ?? 0 }} Buku</h3></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="mini-stat-card">
                        <div class="mini-stat-icon bg-danger bg-opacity-10 text-danger"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="mini-stat-text"><h6>Total Denda</h6><h3>Rp {{ number_format($totalDendaSiswa ?? 0, 0, ',', '.') }}</h3></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="mini-stat-card">
                        <div class="mini-stat-icon bg-success bg-opacity-10 text-success"><i class="fas fa-check-circle"></i></div>
                        <div class="mini-stat-text"><h6>Riwayat Selesai</h6><h3>{{ $pinjamSelesaiSiswa ?? 0 }} Buku</h3></div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- Kartu Motivasi -->
                <div class="col-lg-4">
                    <div class="motivation-card">
                        <i class="fas fa-book-reader"></i>
                        <h5>Mari Tingkatkan Literasi!</h5>
                        <p>Membaca adalah jendela dunia. Jangan lupa kembalikan buku tepat waktu ya agar terhindar dari denda.</p>
                    </div>
                </div>

                <!-- Pinjaman Aktif -->
                <div class="col-lg-8">
                    <div class="card-modern card p-4 h-100">
                        <h5 class="fw-bold mb-3"><i class="fas fa-book-open text-warning me-2"></i>Pinjaman Aktif Saat Ini</h5>
                        
                        @if(isset($pinjamanAktifDetail) && $pinjamanAktifDetail->count() > 0)
                            <div class="row g-3">
                                @foreach($pinjamanAktifDetail as $pa)
                                @php
                                    $terlambat = \Carbon\Carbon::now()->startOfDay()->gt($pa->tanggal_kembali->startOfDay()) && $pa->status == 'dipinjam';
                                @endphp
                                <div class="col-md-6">
                                    <div class="loan-card {{ $terlambat ? 'loan-card-terlambat' : '' }}">
                                        <span class="badge bg-{{ $terlambat ? 'danger' : ($pa->status == 'pending' ? 'secondary' : 'warning') }} mb-2 align-self-start">
                                            {{ $terlambat ? 'Terlambat!' : ucfirst($pa->status) }}
                                        </span>
                                        <h6>{{ $pa->buku->judul }}</h6>
                                        <p><i class="fas fa-calendar-alt me-1"></i> Kembali: {{ $pa->tanggal_kembali->format('d M Y') }}</p>
                                        <a href="{{ route('peminjaman.show', $pa->id) }}" class="btn btn-sm btn-outline-{{ $terlambat ? 'danger' : 'success' }} w-100 mt-auto">Lihat Detail</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 my-auto">
                                <i class="fas fa-check-circle fa-3x text-success mb-3" style="opacity: 0.5;"></i>
                                <h6 class="text-muted">Tidak ada buku yang sedang dipinjam.</h6>
                                <p class="text-muted small">Ayo pinjam buku baru di katalog!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- QUOTE BANNER (Pengganti Kategori) -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="quote-banner">
                        <i class="fas fa-quote-left big-quote"></i>
                        <div class="quote-text">
                            <h5>Kutipan Hari Ini</h5>
                            <p>"Membaca adalah jendela dunia, dan buku adalah teman terbaik yang tak pernah mengeluh."</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rekomendasi Buku -->
            <div class="row">
                <div class="col-12">
                    <div class="card-modern card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0"><i class="fas fa-star text-warning me-2"></i>Rekomendasi Buku Terbaru</h5>
                            <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">Lihat Semua</a>
                        </div>
                        
                        <div class="row g-3">
                            @php $rekomendasi = \App\Models\Buku::latest()->take(4)->get(); @endphp
                            @forelse($rekomendasi as $buku)
                            <div class="col-xl-3 col-md-6">
                                <a href="{{ route('buku.show', $buku->id) }}" class="text-decoration-none">
                                    <div class="card-rekomendasi">
                                        <div class="cover-rekomendasi">
                                            @if($buku->foto)
                                                <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}">
                                            @else
                                                <div class="cover-rekomendasi-fallback"><i class="fas fa-book"></i></div>
                                            @endif
                                        </div>
                                        <div class="body-rekomendasi">
                                            <h6>{{ $buku->judul }}</h6>
                                            <p><i class="fas fa-pen-nib me-1"></i> {{ $buku->pengarang }}</p>
                                            <span class="badge bg-success align-self-start" style="font-size: 0.7rem;">Stok: {{ $buku->stok }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @empty
                            <div class="col-12 text-center text-muted py-4"><p>Belum ada buku.</p></div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        @else
        <!-- TAMPILAN UNTUK ADMIN -->
            <div class="student-header" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); box-shadow: 0 10px 30px rgba(30, 58, 138, 0.3);">
                <h3>👋 Selamat Datang, Admin {{ Auth::user()->name }}!</h3>
                <p>Kelola data perpustakaan dan pantau aktivitas peminjaman hari ini.</p>
            </div>

            <div class="d-flex flex-wrap gap-3 mb-4">
                <a href="{{ route('buku.create') }}" class="action-btn action-btn-primary" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);">
                    <i class="fas fa-plus"></i> Tambah Buku
                </a>
                <a href="{{ route('peminjaman.create') }}" class="action-btn" style="color: #b45309;">
                    <i class="fas fa-hand-holding"></i> Pinjam Offline
                </a>
                <a href="{{ route('peminjaman.index') }}" class="action-btn" style="color: #1e40af;">
                    <i class="fas fa-list"></i> Verifikasi Peminjaman
                </a>
            </div>

            <!-- Statistik Admin -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card text-white border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px;">
                        <div class="card-body">
                            <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Buku</h6>
                            <h2 class="fw-bold mb-0">{{ $totalBuku }}</h2>
                            <small class="text-white-50"><i class="fas fa-book me-1"></i> Judul tersedia</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card text-white border-0 shadow-sm" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 16px;">
                        <div class="card-body">
                            <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Anggota</h6>
                            <h2 class="fw-bold mb-0">{{ $totalAnggota }}</h2>
                            <small class="text-white-50"><i class="fas fa-users me-1"></i> Pengguna terdaftar</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card text-white border-0 shadow-sm" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 16px;">
                        <div class="card-body">
                            <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Peminjaman</h6>
                            <h2 class="fw-bold mb-0">{{ $totalPeminjaman }}</h2>
                            <small class="text-white-50"><i class="fas fa-history me-1"></i> Transaksi</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card text-white border-0 shadow-sm" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 16px;">
                        <div class="card-body">
                            <h6 class="text-white-50 text-uppercase fw-bold mb-1">Dipinjam Aktif</h6>
                            <h2 class="fw-bold mb-0">{{ $peminjamanAktif }}</h2>
                            <small class="text-white-50"><i class="fas fa-spinner me-1"></i> Sedang dipinjam</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Admin -->
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="card-modern card p-4">
                        <h5 class="fw-bold mb-4"><i class="fas fa-chart-line text-primary me-2"></i>Statistik Peminjaman per Bulan</h5>
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="chartPeminjaman"></canvas>
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
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: '#1e3a8a',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endif
@endpush