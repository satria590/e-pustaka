@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
@php
    // Cek apakah yang login adalah Siswa
    $isSiswa = Auth::user()->role == 'siswa';
    
    // Tentukan warna Header
    $headerBg = $isSiswa 
        ? 'linear-gradient(135deg, #059669 0%, #10b981 100%)' // Hijau untuk Siswa
        : 'linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%)'; // Biru untuk Admin
        
    // Tentukan warna Filter Aktif & Tombol
    $primaryColor = $isSiswa ? '#10b981' : '#1e3a8a';
@endphp

<style>
    .peminjaman-bg { position: relative; background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%); min-height: 100vh; padding: 30px 0 60px 0; }
    .container-wide { width: 95%; max-width: 1500px; margin: 0 auto; position: relative; z-index: 1; }
    
    .header-peminjaman {
        background: {{ $headerBg }};
        border-radius: 20px; padding: 30px 40px; color: white;
        margin-bottom: 25px; position: relative; overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .header-peminjaman::after { content: '📋'; position: absolute; right: 40px; top: 50%; transform: translateY(-50%); font-size: 90px; opacity: 0.15; }
    .header-peminjaman h4 { font-weight: 800; margin-bottom: 8px; font-size: 1.6rem; }
    .header-peminjaman p { opacity: 0.9; margin-bottom: 0; font-size: 1rem; }
    
    .stat-mini { display: inline-block; padding: 8px 18px; border-radius: 20px; background: rgba(255,255,255,0.15); margin-right: 10px; font-size: 0.9rem; backdrop-filter: blur(5px); }
    
    .card-peminjaman { border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); background: white; overflow: hidden; }
    .card-peminjaman .card-header { background: white; border-bottom: 2px solid #f1f5f9; padding: 20px 25px; }
    
    .table-peminjaman { margin-bottom: 0; }
    .table-peminjaman thead th { background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; padding: 15px 20px; letter-spacing: 0.5px; white-space: nowrap; }
    .table-peminjaman tbody td { padding: 15px 20px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
    .table-peminjaman tbody tr { transition: all 0.2s ease; }
    .table-peminjaman tbody tr:hover { background: #f8fafc; }
    
    /* Baris Tabel Terlambat */
    .row-terlambat { background-color: #fef2f2 !important; }
    .row-terlambat:hover { background-color: #fee2e2 !important; }
    
    .td-peminjam { max-width: 180px; }
    .td-buku { max-width: 200px; }
    .text-truncate-custom { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }
    
    .badge-status { padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; }
    .badge-pending { background: #e0e7ff; color: #3730a3; }
    .badge-dipinjam { background: #fef3c7; color: #92400e; }
    .badge-dikembalikan { background: #d1fae5; color: #065f46; }
    .badge-terlambat { background: #fee2e2; color: #991b1b; }
    .badge-ditolak { background: #e2e8f0; color: #475569; }
    .badge-denda { background: #dc3545; color: white; padding: 5px 12px; border-radius: 20px; font-weight: 700; font-size: 0.8rem; white-space: nowrap; }
    
    .btn-action-sm { border-radius: 8px; padding: 6px 10px; font-size: 0.75rem; font-weight: 700; transition: all 0.3s ease; }
    .btn-action-sm:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.15); }
    
    .avatar-user { width: 35px; height: 35px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.9rem; margin-right: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); flex-shrink: 0; }
    
    .filter-section { display: flex; gap: 8px; flex-wrap: wrap; }
    .filter-section .btn-filter { border-radius: 20px; padding: 6px 16px; font-size: 0.8rem; font-weight: 700; border: 2px solid #e2e8f0; background: white; color: #64748b; transition: all 0.3s ease; }
    .filter-section .btn-filter:hover, .filter-section .btn-filter.active { border-color: {{ $primaryColor }}; background: {{ $primaryColor }}; color: white; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
    
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state .empty-icon { font-size: 80px; color: #cbd5e1; margin-bottom: 20px; }

    .mobile-card-container { display: none; }
    .mobile-card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 15px; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); position: relative; border-left: 5px solid {{ $primaryColor }}; }
    .mobile-card-terlambat { border-left-color: #ef4444; background: #fef2f2; }
    
    .mobile-card-header { display: flex; align-items: center; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed #e2e8f0; }
    .mobile-card-body p { margin-bottom: 5px; font-size: 0.85rem; color: #475569; }
    .mobile-card-body p strong { color: #1e293b; }
    .mobile-card-actions { margin-top: 15px; display: flex; gap: 5px; flex-wrap: wrap; }
    .mobile-card-actions .btn { flex: 1; font-size: 0.8rem; padding: 8px; }

    @media (max-width: 768px) {
        .header-peminjaman::after { display: none; }
        .header-peminjaman { padding: 20px; }
        .header-peminjaman h4 { font-size: 1.3rem; }
        .filter-section { justify-content: center; margin-bottom: 15px; }
        .filter-section .btn-filter { padding: 5px 12px; font-size: 0.75rem; }
        .desktop-table { display: none !important; }
        .mobile-card-container { display: block !important; }
    }

    @media print {
        body { background: white !important; }
        .navbar, footer, .header-peminjaman, .filter-section, .btn, .btn-action-sm, .avatar-user, .card-header, .d-flex.justify-content-between.mt-4, .mobile-card-container { display: none !important; }
        .desktop-table { display: block !important; }
        .container-wide { width: 100% !important; max-width: 100% !important; }
        .peminjaman-bg { background: white !important; padding: 0 !important; }
        .card-peminjaman { box-shadow: none !important; border: 1px solid #ccc !important; }
        .print-title { display: block !important; text-align: center; margin-bottom: 20px; }
        .table-peminjaman thead th { background-color: #f0f0f0 !important; color: black !important; border: 1px solid #000 !important; padding: 8px !important; }
        .table-peminjaman tbody td { border: 1px solid #000 !important; padding: 8px !important; color: black !important; }
        tr[style*="display: none"] { display: none !important; }
        th:last-child, td:last-child { display: none !important; }
        .text-truncate-custom { white-space: normal !important; overflow: visible !important; }
    }
</style>

<div class="peminjaman-bg">
    <div class="container-wide">
        
        <div class="print-title" style="display: none;">
            <h2 style="font-weight: 800; text-transform: uppercase;">Laporan Data Peminjaman Buku</h2>
            <p>Sistem Informasi e-Pustaka - SMK Negeri 5</p>
            <p>Tanggal Cetak: {{ date('d F Y') }}</p>
            <hr style="border: 2px solid #000;">
        </div>

        <div class="header-peminjaman">
            <div>
                <h4><i class="fas fa-hand-holding me-2"></i>{{ $isSiswa ? 'Riwayat Peminjaman Saya' : 'Data Peminjaman' }}</h4>
                <p><i class="fas fa-clock me-2"></i>{{ $isSiswa ? 'Pantau status pinjaman dan denda Anda' : 'Kelola semua transaksi peminjaman buku' }}</p>
                
                @if(!$isSiswa)
                <div class="mt-3">
                    <span class="stat-mini"><i class="fas fa-book me-1"></i>Total: {{ $peminjamans->total() }}</span>
                    <span class="stat-mini"><i class="fas fa-hourglass-half me-1"></i>Pending: {{ $peminjamans->where('status', 'pending')->count() }}</span>
                    <span class="stat-mini"><i class="fas fa-spinner me-1"></i>Dipinjam: {{ $peminjamans->where('status', 'dipinjam')->count() }}</span>
                    <span class="stat-mini"><i class="fas fa-check-circle me-1"></i>Selesai: {{ $peminjamans->where('status', 'dikembalikan')->count() }}</span>
                </div>
                @endif
            </div>
        </div>
        
        <div class="row align-items-center mb-4">
            <div class="col-lg-8 col-md-12">
                <div class="filter-section">
                    <button class="btn-filter active" data-filter="all"><i class="fas fa-list me-1"></i>Semua</button>
                    <button class="btn-filter" data-filter="pending"><i class="fas fa-hourglass-half me-1"></i>Menunggu</button>
                    <button class="btn-filter" data-filter="dipinjam"><i class="fas fa-spinner me-1"></i>Dipinjam</button>
                    <button class="btn-filter" data-filter="dikembalikan"><i class="fas fa-check me-1"></i>Selesai</button>
                    <button class="btn-filter" data-filter="terlambat"><i class="fas fa-exclamation me-1"></i>Terlambat</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 text-lg-end text-center mt-3 mt-lg-0">
                @if(!$isSiswa)
                    <div class="d-flex gap-2 justify-content-lg-end justify-content-center">
                        <button onclick="window.print()" class="btn btn-secondary px-3 py-2" style="border-radius: 10px; font-weight: 600; box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);">
                            <i class="fas fa-print me-1"></i> Cetak
                        </button>
                        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary px-4 py-2" style="border-radius: 10px; font-weight: 600; box-shadow: 0 4px 10px rgba(30, 58, 138, 0.3); background: #1e3a8a; border-color: #1e3a8a;">
                            <i class="fas fa-plus me-1"></i>Tambah
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card-peminjaman card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold fs-5" style="color: {{ $primaryColor }};"><i class="fas fa-table me-2"></i>Daftar Peminjaman</span>
                <span class="text-muted" style="font-size: 0.85rem;"><i class="fas fa-arrow-up me-1"></i>Data Terbaru</span>
            </div>
            <div class="card-body p-0">
                
                <div class="table-responsive desktop-table">
                    <table class="table table-peminjaman" id="peminjamanTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Peminjam & Kelas</th>
                                <th>Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Denda</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamans as $key => $peminjaman)
                            @php
                                // CEK KETERLAMBATAN REAL-TIME
                                $dendaSaatIni = $peminjaman->hitungDendaBerjalan();
                                $isTerlambat = ($peminjaman->status == 'dipinjam' && \Carbon\Carbon::now()->gt($peminjaman->tanggal_kembali));
                            @endphp
                            <tr data-status="{{ $peminjaman->status }}" class="{{ $isTerlambat ? 'row-terlambat' : '' }}">
                                <td><span class="fw-bold text-muted">{{ $peminjamans->firstItem() + $key }}</span></td>
                                <td class="td-peminjam">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-user" style="background: {{ ['#1e3a8a', '#0ea5e9', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'][$key % 6] }};">
                                            {{ strtoupper(substr($peminjaman->user->name, 0, 1)) }}
                                        </div>
                                        <div style="min-width: 0;">
                                            <div class="fw-bold text-truncate-custom" style="font-size: 0.9rem;" title="{{ $peminjaman->user->name }}">{{ $peminjaman->user->name }}</div>
                                            <small class="text-muted text-truncate-custom" style="font-size: 0.75rem;">
                                                <i class="fas fa-school me-1"></i>{{ $peminjaman->user->kelas ?? '-' }} / {{ $peminjaman->user->nis ?? '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="td-buku">
                                    <div class="fw-bold text-truncate-custom" style="font-size: 0.9rem;" title="{{ $peminjaman->buku->judul }}">{{ $peminjaman->buku->judul }}</div>
                                    <small class="text-muted text-truncate-custom" style="font-size: 0.75rem;" title="{{ $peminjaman->buku->pengarang }}"><i class="fas fa-pen-nib me-1"></i>{{ $peminjaman->buku->pengarang }}</small>
                                </td>
                                <td>
                                    <div style="font-size: 0.8rem; white-space: nowrap;">
                                        <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                        {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.8rem; white-space: nowrap;">
                                        <i class="fas fa-calendar-check me-1 text-success"></i>
                                        {{ $peminjaman->tanggal_kembali->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td>
                                    @if($isTerlambat)
                                        <span class="badge-status badge-terlambat"><i class="fas fa-exclamation-triangle"></i>Terlambat!</span>
                                    @elseif($peminjaman->status == 'pending')
                                        <span class="badge-status badge-pending"><i class="fas fa-hourglass-half"></i>Menunggu</span>
                                        @if($peminjaman->kode_pickup)
                                            <br><small class="text-primary fw-bold" style="font-size: 0.7rem;"><i class="fas fa-key me-1"></i>{{ $peminjaman->kode_pickup }}</small>
                                        @endif
                                    @elseif($peminjaman->status == 'dipinjam')
                                        <span class="badge-status badge-dipinjam"><i class="fas fa-spinner fa-spin"></i>Dipinjam</span>
                                    @elseif($peminjaman->status == 'terlambat')
                                        <span class="badge-status badge-terlambat"><i class="fas fa-exclamation-triangle"></i>Terlambat</span>
                                    @elseif($peminjaman->status == 'ditolak')
                                        <span class="badge-status badge-ditolak"><i class="fas fa-times-circle"></i>Ditolak</span>
                                    @else
                                        <span class="badge-status badge-dikembalikan"><i class="fas fa-check-circle"></i>Dikembalikan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($dendaSaatIni > 0)
                                        <span class="badge-denda"><i class="fas fa-money-bill-wave me-1"></i>Rp {{ number_format($dendaSaatIni, 0, ',', '.') }}</span>
                                        @if($peminjaman->status == 'dipinjam' || $isTerlambat)
                                            <br><small class="text-danger" style="font-size: 0.65rem;"><i class="fas fa-arrow-up"></i> Berjalan</small>
                                        @endif
                                    @else
                                        <span class="text-muted" style="font-size: 0.85rem;"><i class="fas fa-minus me-1"></i>-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                                        @if($peminjaman->status == 'pending')
                                            @if(!$isSiswa)
                                                <a href="{{ route('peminjaman.verifikasi', $peminjaman->id) }}" class="btn btn-success btn-action-sm" onclick="return confirm('Verifikasi peminjaman ini?')"><i class="fas fa-check"></i></a>
                                                <a href="{{ route('peminjaman.tolak', $peminjaman->id) }}" class="btn btn-danger btn-action-sm" onclick="return confirm('Yakin tolak pengajuan ini?')"><i class="fas fa-times"></i></a>
                                            @else
                                                <span class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-clock me-1"></i>Menunggu</span>
                                            @endif
                                        @elseif($peminjaman->status == 'dipinjam' || $peminjaman->status == 'terlambat' || $isTerlambat)
                                            @if(!$isSiswa)
                                                <a href="{{ route('peminjaman.kembali', $peminjaman->id) }}" class="btn btn-success btn-action-sm" onclick="return confirm('Yakin buku sudah dikembalikan?')"><i class="fas fa-undo"></i></a>
                                                <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-warning btn-action-sm"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-action-sm" onclick="return confirm('Yakin hapus data ini?')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            @else
                                                <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="btn btn-info btn-action-sm text-white"><i class="fas fa-eye"></i></a>
                                            @endif
                                        @else
                                            <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="btn btn-info btn-action-sm text-white"><i class="fas fa-eye"></i></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                                        <h4 class="text-muted fw-bold">Belum ada data peminjaman</h4>
                                        @if(!$isSiswa)
                                            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mt-3 px-4 py-2" style="border-radius: 10px; background: #1e3a8a; border-color: #1e3a8a;">
                                                <i class="fas fa-plus me-1"></i>Tambah Peminjaman
                                            </a>
                                        @else
                                            <p class="text-muted">Anda belum pernah meminjam buku.</p>
                                            <a href="{{ route('buku.index') }}" class="btn btn-success mt-3 px-4 py-2" style="border-radius: 10px;">
                                                <i class="fas fa-search me-1"></i>Cari Buku
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mobile-card-container p-3">
                    @forelse($peminjamans as $key => $peminjaman)
                    @php
                        $dendaSaatIni = $peminjaman->hitungDendaBerjalan();
                        $isTerlambat = ($peminjaman->status == 'dipinjam' && \Carbon\Carbon::now()->gt($peminjaman->tanggal_kembali));
                    @endphp
                    <div class="mobile-card {{ $isTerlambat ? 'mobile-card-terlambat' : '' }}" data-status="{{ $peminjaman->status }}">
                        <div class="mobile-card-header">
                            <div class="avatar-user" style="background: {{ ['#1e3a8a', '#0ea5e9', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'][$key % 6] }};">
                                {{ strtoupper(substr($peminjaman->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold" style="font-size: 0.95rem;">{{ $peminjaman->user->name }}</div>
                                <small class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-school me-1"></i>{{ $peminjaman->user->kelas ?? '-' }} / {{ $peminjaman->user->nis ?? '-' }}</small>
                            </div>
                            <div class="ms-auto text-end">
                                @if($isTerlambat)
                                    <span class="badge-status badge-terlambat">Terlambat!</span>
                                @elseif($peminjaman->status == 'pending')
                                    <span class="badge-status badge-pending">Menunggu</span>
                                    @if($peminjaman->kode_pickup)
                                        <br><small class="text-primary fw-bold" style="font-size: 0.7rem;">{{ $peminjaman->kode_pickup }}</small>
                                    @endif
                                @elseif($peminjaman->status == 'dipinjam')
                                    <span class="badge-status badge-dipinjam">Dipinjam</span>
                                @elseif($peminjaman->status == 'terlambat')
                                    <span class="badge-status badge-terlambat">Terlambat</span>
                                @elseif($peminjaman->status == 'ditolak')
                                    <span class="badge-status badge-ditolak">Ditolak</span>
                                @else
                                    <span class="badge-status badge-dikembalikan">Selesai</span>
                                @endif
                            </div>
                        </div>

                        <div class="mobile-card-body">
                            <p><strong>Buku:</strong> {{ $peminjaman->buku->judul }}</p>
                            <p><strong>Tgl Pinjam:</strong> {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</p>
                            <p><strong>Tgl Kembali:</strong> {{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</p>
                            @if($dendaSaatIni > 0)
                                <p class="text-danger mt-1 mb-0"><strong>Denda:</strong> Rp {{ number_format($dendaSaatIni, 0, ',', '.') }}</p>
                            @endif
                        </div>

                        <div class="mobile-card-actions">
                            @if($peminjaman->status == 'pending')
                                @if(!$isSiswa)
                                    <a href="{{ route('peminjaman.verifikasi', $peminjaman->id) }}" class="btn btn-success" onclick="return confirm('Verifikasi?')"><i class="fas fa-check"></i> Verifikasi</a>
                                    <a href="{{ route('peminjaman.tolak', $peminjaman->id) }}" class="btn btn-danger" onclick="return confirm('Tolak?')"><i class="fas fa-times"></i> Tolak</a>
                                @endif
                            @elseif($peminjaman->status == 'dipinjam' || $peminjaman->status == 'terlambat' || $isTerlambat)
                                @if(!$isSiswa)
                                    <a href="{{ route('peminjaman.kembali', $peminjaman->id) }}" class="btn btn-success" onclick="return confirm('Kembalikan?')"><i class="fas fa-undo"></i> Kembali</a>
                                    <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                @else
                                    <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="btn btn-info text-white"><i class="fas fa-eye"></i> Detail</a>
                                @endif
                            @else
                                <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="btn btn-info text-white"><i class="fas fa-eye"></i> Detail</a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                        <h4 class="text-muted fw-bold">Belum ada data</h4>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
            <div class="text-muted" style="font-size: 0.9rem;">
                <i class="fas fa-info-circle me-1"></i>
                Menampilkan {{ $peminjamans->firstItem() ?? 0 }} - {{ $peminjamans->lastItem() ?? 0 }} 
                dari {{ $peminjamans->total() }} data
            </div>
            <div>{{ $peminjamans->links() }}</div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.btn-filter');
    const tableRows = document.querySelectorAll('#peminjamanTable tbody tr');
    const mobileCards = document.querySelectorAll('.mobile-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            
            tableRows.forEach(row => {
                if (filter === 'all') {
                    row.style.display = '';
                } else {
                    const status = row.dataset.status;
                    row.style.display = (status === filter) ? '' : 'none';
                }
            });

            mobileCards.forEach(card => {
                if (filter === 'all') {
                    card.style.display = '';
                } else {
                    const status = card.dataset.status;
                    card.style.display = (status === filter) ? '' : 'none';
                }
            });
        });
    });
});
</script>
@endsection