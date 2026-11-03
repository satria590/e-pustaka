@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<style>
    .peminjaman-bg {
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    
    .peminjaman-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }
    
    .header-peminjaman {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 25px 30px;
        color: white;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }
    
    .header-peminjaman::after {
        content: '📋';
        position: absolute; right: 30px; top: 50%;
        transform: translateY(-50%); font-size: 70px; opacity: 0.15;
    }
    
    .header-peminjaman h4 { font-weight: 600; margin-bottom: 5px; }
    .header-peminjaman p { opacity: 0.9; margin-bottom: 0; }
    
    .stat-mini {
        display: inline-block; padding: 5px 15px; border-radius: 20px;
        background: rgba(255,255,255,0.2); margin-right: 8px; font-size: 0.85rem;
    }
    
    .card-peminjaman {
        border: none; border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px); overflow: hidden;
    }
    
    .card-peminjaman .card-header {
        background: transparent; border-bottom: 2px solid #f1f3f5; padding: 18px 24px;
    }
    
    .card-peminjaman .card-body { padding: 0; }
    .table-peminjaman { margin-bottom: 0; }
    
    .table-peminjaman thead th {
        background: #f8f9fa; border-bottom: 2px solid #e9ecef;
        color: #495057; font-weight: 600; font-size: 0.85rem;
        text-transform: uppercase; padding: 12px 16px; letter-spacing: 0.5px;
    }
    
    .table-peminjaman tbody td {
        padding: 14px 16px; vertical-align: middle; border-bottom: 1px solid #f1f3f5;
    }
    
    .table-peminjaman tbody tr { transition: all 0.2s ease; }
    .table-peminjaman tbody tr:hover { background: #f8f9fa; }
    
    .badge-status {
        padding: 6px 14px; border-radius: 20px; font-weight: 500;
        font-size: 0.75rem; text-transform: capitalize;
    }
    
    .badge-pending { background: #cce5ff; color: #004085; }
    .badge-dipinjam { background: #fff3cd; color: #856404; }
    .badge-dikembalikan { background: #d4edda; color: #155724; }
    .badge-terlambat { background: #f8d7da; color: #721c24; }
    .badge-ditolak { background: #e2e3e5; color: #383d41; }
    
    .badge-denda {
        background: #dc3545; color: white; padding: 4px 12px;
        border-radius: 20px; font-weight: 600; font-size: 0.8rem;
    }
    
    .btn-action-sm {
        border-radius: 8px; padding: 4px 12px; font-size: 0.8rem; transition: all 0.3s ease;
    }
    .btn-action-sm:hover { transform: translateY(-2px); }
    
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state .empty-icon { font-size: 80px; color: #b2bec3; margin-bottom: 20px; }
    
    .filter-section { display: flex; gap: 10px; flex-wrap: wrap; }
    .filter-section .btn-filter {
        border-radius: 20px; padding: 5px 18px; font-size: 0.85rem;
        border: 2px solid #e9ecef; background: white; transition: all 0.3s ease;
    }
    .filter-section .btn-filter:hover,
    .filter-section .btn-filter.active {
        border-color: #667eea; background: #667eea; color: white;
    }
    
    .avatar-user {
        width: 35px; height: 35px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        color: white; font-weight: 600; font-size: 0.9rem; margin-right: 8px;
    }
    
    @media (max-width: 768px) {
        .header-peminjaman::after { display: none; }
        .table-peminjaman { font-size: 0.85rem; }
        .table-peminjaman thead th, .table-peminjaman tbody td { padding: 10px 12px; }
        .filter-section { justify-content: center; }
    }
</style>

<div class="peminjaman-bg">
    <div class="container">
        <!-- Header -->
        <div class="header-peminjaman">
            <div>
                <h4><i class="fas fa-hand-holding me-2"></i>Data Peminjaman</h4>
                <p><i class="fas fa-clock me-2"></i>Kelola semua transaksi peminjaman buku</p>
                <div class="mt-2">
                    <span class="stat-mini"><i class="fas fa-book me-1"></i>Total: {{ $peminjamans->total() }}</span>
                    <span class="stat-mini"><i class="fas fa-hourglass-half me-1"></i>Pending: {{ $peminjamans->where('status', 'pending')->count() }}</span>
                    <span class="stat-mini"><i class="fas fa-spinner me-1"></i>Dipinjam: {{ $peminjamans->where('status', 'dipinjam')->count() }}</span>
                    <span class="stat-mini"><i class="fas fa-check-circle me-1"></i>Selesai: {{ $peminjamans->where('status', 'dikembalikan')->count() }}</span>
                </div>
            </div>
        </div>
        
        <!-- Filter & Actions -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="filter-section">
                    <button class="btn-filter active" data-filter="all"><i class="fas fa-list me-1"></i>Semua</button>
                    <button class="btn-filter" data-filter="pending"><i class="fas fa-hourglass-half me-1"></i>Menunggu</button>
                    <button class="btn-filter" data-filter="dipinjam"><i class="fas fa-spinner me-1"></i>Dipinjam</button>
                    <button class="btn-filter" data-filter="dikembalikan"><i class="fas fa-check me-1"></i>Selesai</button>
                    <button class="btn-filter" data-filter="terlambat"><i class="fas fa-exclamation me-1"></i>Terlambat</button>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Peminjaman
                    </a>
                @endif
            </div>
        </div>
        
        <!-- Table -->
        <div class="card-peminjaman card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="fas fa-table me-2 text-primary"></i>Daftar Peminjaman</span>
                    <span class="text-muted" style="font-size: 0.85rem;"><i class="fas fa-arrow-up me-1"></i>Terbaru</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-peminjaman" id="peminjamanTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Denda</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamans as $key => $peminjaman)
                            <tr data-status="{{ $peminjaman->status }}">
                                <td><span class="fw-bold text-muted">{{ $peminjamans->firstItem() + $key }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-user" style="background: {{ ['#667eea', '#11998e', '#f093fb', '#4facfe', '#f5576c', '#ffd93d'][$key % 6] }};">
                                            {{ strtoupper(substr($peminjaman->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="font-size: 0.9rem;">{{ $peminjaman->user->name }}</div>
                                            <small class="text-muted">{{ $peminjaman->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-bold" style="font-size: 0.9rem;">{{ Str::limit($peminjaman->buku->judul, 25) }}</div>
                                        <small class="text-muted"><i class="fas fa-user me-1"></i>{{ $peminjaman->buku->pengarang }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.9rem;">
                                        <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                        {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.9rem;">
                                        <i class="fas fa-calendar-check me-1 text-success"></i>
                                        {{ $peminjaman->tanggal_kembali->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td>
                                    @if($peminjaman->status == 'pending')
                                        <span class="badge-status badge-pending"><i class="fas fa-hourglass-half me-1"></i>Menunggu</span>
                                    @elseif($peminjaman->status == 'dipinjam')
                                        <span class="badge-status badge-dipinjam"><i class="fas fa-spinner fa-spin me-1"></i>Dipinjam</span>
                                    @elseif($peminjaman->status == 'terlambat')
                                        <span class="badge-status badge-terlambat"><i class="fas fa-exclamation-triangle me-1"></i>Terlambat</span>
                                    @elseif($peminjaman->status == 'ditolak')
                                        <span class="badge-status badge-ditolak"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                                    @else
                                        <span class="badge-status badge-dikembalikan"><i class="fas fa-check-circle me-1"></i>Dikembalikan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($peminjaman->denda > 0)
                                        <span class="badge-denda"><i class="fas fa-money-bill-wave me-1"></i>Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted"><i class="fas fa-minus-circle me-1"></i>-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                                        
                                        {{-- ========================================== --}}
                                        {{-- AKSI UNTUK STATUS PENDING                 --}}
                                        {{-- ========================================== --}}
                                        @if($peminjaman->status == 'pending')
                                            @if(Auth::user()->role == 'admin')
                                                <a href="{{ route('peminjaman.verifikasi', $peminjaman->id) }}" 
                                                   class="btn btn-success btn-action-sm"
                                                   onclick="return confirm('Verifikasi peminjaman ini? Pastikan stok fisik tersedia.')">
                                                    <i class="fas fa-check"></i> Verifikasi
                                                </a>
                                                <a href="{{ route('peminjaman.tolak', $peminjaman->id) }}" 
                                                   class="btn btn-danger btn-action-sm"
                                                   onclick="return confirm('Yakin tolak pengajuan ini?')">
                                                    <i class="fas fa-times"></i> Tolak
                                                </a>
                                            @else
                                                <span class="text-muted"><i class="fas fa-clock me-1"></i>Menunggu Admin</span>
                                            @endif
                                        
                                        {{-- ========================================== --}}
                                        {{-- AKSI UNTUK STATUS DIPINJAM / TERLAMBAT     --}}
                                        {{-- ========================================== --}}
                                        @elseif($peminjaman->status == 'dipinjam' || $peminjaman->status == 'terlambat')
                                            
                                            {{-- TOMBOL KHUSUS ADMIN (Kembali, Edit, Hapus) --}}
                                            @if(Auth::user()->role == 'admin')
                                                <a href="{{ route('peminjaman.kembali', $peminjaman->id) }}" 
                                                   class="btn btn-success btn-action-sm"
                                                   onclick="return confirm('Yakin buku sudah dikembalikan?')">
                                                    <i class="fas fa-undo"></i> Kembali
                                                </a>
                                                <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" 
                                                   class="btn btn-warning btn-action-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-action-sm" onclick="return confirm('Yakin hapus data ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            
                                            {{-- TOMBOL KHUSUS SISWA (Hanya Lihat) --}}
                                            @else
                                                <a href="{{ route('peminjaman.show', $peminjaman->id) }}" 
                                                   class="btn btn-info btn-action-sm text-white">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            @endif
                                        
                                        {{-- ========================================== --}}
                                        {{-- AKSI UNTUK STATUS SELESAI / DITOLAK        --}}
                                        {{-- ========================================== --}}
                                        @else
                                            <a href="{{ route('peminjaman.show', $peminjaman->id) }}" 
                                               class="btn btn-info btn-action-sm text-white">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                                        <h4 class="text-muted">Belum ada data peminjaman</h4>
                                        <p class="text-muted">Mulai lakukan peminjaman buku pertama</p>
                                        @if(Auth::user()->role == 'admin')
                                            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mt-3">
                                                <i class="fas fa-plus me-1"></i>Tambah Peminjaman
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
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
        });
    });
});
</script>
@endsection