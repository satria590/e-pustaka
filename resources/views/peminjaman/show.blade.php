@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<style>
    .show-bg {
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 30px 0;
    }
    .show-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

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

    .card-show {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        overflow: hidden;
        position: relative;
        z-index: 1;
    }

    .card-header-show {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px 30px;
        color: white;
    }
    .card-header-show h4 { font-weight: 700; margin: 0 0 5px 0; font-size: 1.3rem; }
    .card-header-show p { margin: 0; opacity: 0.9; font-size: 0.9rem; }

    .detail-body { padding: 30px; }

    .section-title {
        font-size: 0.85rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #667eea;
        letter-spacing: 1px;
        margin-bottom: 15px;
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

    .info-box {
        background: #f8f9fa;
        padding: 15px 18px;
        border-radius: 12px;
        border-left: 4px solid #667eea;
        margin-bottom: 15px;
    }
    .info-box .label { font-size: 0.75rem; color: #6c757d; text-transform: uppercase; font-weight: 600; margin-bottom: 4px; }
    .info-box .value { font-size: 1rem; color: #2d3436; font-weight: 600; }

    /* Badge Status */
    .badge-status {
        padding: 8px 16px; border-radius: 20px; font-weight: 600;
        font-size: 0.85rem; text-transform: capitalize;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .badge-pending { background: #cce5ff; color: #004085; }
    .badge-dipinjam { background: #fff3cd; color: #856404; }
    .badge-dikembalikan { background: #d4edda; color: #155724; }
    .badge-terlambat { background: #f8d7da; color: #721c24; }
    .badge-ditolak { background: #e2e3e5; color: #383d41; }

    .badge-denda {
        background: #dc3545; color: white; padding: 6px 14px;
        border-radius: 20px; font-weight: 700; font-size: 0.9rem;
    }

    .btn-back {
        border-radius: 10px; padding: 12px 25px; font-weight: 600;
        transition: all 0.3s ease; border: 2px solid #e9ecef;
        background: white; color: #495057; text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-back:hover { background: #f8f9fa; color: #495057; transform: translateY(-2px); }
</style>

<div class="show-bg">
    <div class="container">

        <!-- Breadcrumb -->
        <div class="breadcrumb-custom">
            <a href="{{ route('peminjaman.index') }}">
                <i class="fas fa-home me-1"></i>Data Peminjaman
            </a>
            <i class="fas fa-chevron-right separator" style="font-size: 0.7rem;"></i>
            <span class="current">Detail Transaksi</span>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card-show">
                    <div class="card-header-show d-flex justify-content-between align-items-center">
                        <div>
                            <h4><i class="fas fa-receipt me-2"></i>Detail Peminjaman</h4>
                            <p>Kode Transaksi: #TRX-{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        {{-- Badge Status Utama --}}
                        <div>
                            @if($peminjaman->status == 'pending')
                                <span class="badge-status badge-pending"><i class="fas fa-hourglass-half"></i> Menunggu</span>
                            @elseif($peminjaman->status == 'dipinjam')
                                <span class="badge-status badge-dipinjam"><i class="fas fa-spinner fa-spin"></i> Dipinjam</span>
                            @elseif($peminjaman->status == 'terlambat')
                                <span class="badge-status badge-terlambat"><i class="fas fa-exclamation-triangle"></i> Terlambat</span>
                            @elseif($peminjaman->status == 'ditolak')
                                <span class="badge-status badge-ditolak"><i class="fas fa-times-circle"></i> Ditolak</span>
                            @else
                                <span class="badge-status badge-dikembalikan"><i class="fas fa-check-circle"></i> Dikembalikan</span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-body">
                        <div class="row">
                            
                            <!-- KOLOM KIRI: Info Peminjam -->
                            <div class="col-md-6 mb-4">
                                <div class="section-title"><i class="fas fa-user"></i>Informasi Peminjam</div>
                                
                                <div class="info-box">
                                    <div class="label">Nama Lengkap</div>
                                    <div class="value">{{ $peminjaman->user->name }}</div>
                                </div>
                                <div class="info-box">
                                    <div class="label">Alamat Email</div>
                                    <div class="value">{{ $peminjaman->user->email }}</div>
                                </div>
                                @if($peminjaman->user->role == 'siswa')
                                <div class="row">
                                    <div class="col-6">
                                        <div class="info-box">
                                            <div class="label">Kelas</div>
                                            <div class="value">{{ $peminjaman->user->kelas ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-box">
                                            <div class="label">NIS</div>
                                            <div class="value">{{ $peminjaman->user->nis ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- KOLOM KANAN: Info Buku -->
                            <div class="col-md-6 mb-4">
                                <div class="section-title"><i class="fas fa-book"></i>Informasi Buku</div>
                                
                                <div class="info-box">
                                    <div class="label">Judul Buku</div>
                                    <div class="value">{{ $peminjaman->buku->judul }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="info-box">
                                            <div class="label">Pengarang</div>
                                            <div class="value">{{ $peminjaman->buku->pengarang }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-box">
                                            <div class="label">Kategori</div>
                                            <div class="value">{{ $peminjaman->buku->kategori }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-box">
                                    <div class="label">ISBN</div>
                                    <div class="value">{{ $peminjaman->buku->isbn }}</div>
                                </div>
                            </div>

                            <!-- KOLOM BAWAH: Waktu & Status -->
                            <div class="col-md-12">
                                <div class="section-title"><i class="fas fa-calendar-alt"></i>Waktu & Status Transaksi</div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="info-box" style="border-left-color: #28a745;">
                                            <div class="label">Tanggal Pinjam</div>
                                            <div class="value">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box" style="border-left-color: #ffc107;">
                                            <div class="label">Batas Pengembalian</div>
                                            <div class="value">{{ $peminjaman->tanggal_kembali->format('d F Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box" style="border-left-color: #17a2b8;">
                                            <div class="label">Tanggal Dikembalikan</div>
                                            <div class="value">
                                                {{ $peminjaman->tanggal_pengembalian_aktual ? $peminjaman->tanggal_pengembalian_aktual->format('d F Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Denda & Catatan -->
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <div class="info-box" style="border-left-color: #dc3545; background: #fff5f5;">
                                            <div class="label">Denda Keterlambatan</div>
                                            <div class="value text-danger">
                                                @if($peminjaman->denda > 0)
                                                    Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                                                @else
                                                    Rp 0 (Tidak ada denda)
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="info-box" style="border-left-color: #6c757d;">
                                            <div class="label">Catatan / Keterangan</div>
                                            <div class="value" style="font-weight: 500;">
                                                {{ $peminjaman->catatan ?? 'Tidak ada catatan tambahan.' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Tombol Kembali -->
                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="{{ route('peminjaman.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection