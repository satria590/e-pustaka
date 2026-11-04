@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<style>
    .show-bg {
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 30px 0 60px 0;
    }
    .show-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    .breadcrumb-custom {
        display: flex; align-items: center; gap: 8px;
        font-size: 0.9rem; margin-bottom: 20px;
        position: relative; z-index: 1;
    }
    .breadcrumb-custom a { color: #1e3a8a; text-decoration: none; font-weight: 600; transition: color 0.2s; }
    .breadcrumb-custom a:hover { color: #3b82f6; text-decoration: underline; }
    .breadcrumb-custom .separator { color: #94a3b8; }
    .breadcrumb-custom .current { color: #64748b; }

    /* Card Desain Tiket */
    .card-ticket {
        border: none; border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        background: white; overflow: hidden;
        position: relative; z-index: 1;
    }

    .ticket-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        padding: 30px 40px; color: white;
        display: flex; justify-content: space-between; align-items: center;
        position: relative; overflow: hidden;
    }
    .ticket-header::after {
        content: '🎫'; position: absolute; right: 30px; top: 50%;
        transform: translateY(-50%); font-size: 100px; opacity: 0.1;
    }
    .ticket-header h3 { font-weight: 800; margin: 0; font-size: 1.5rem; }
    .ticket-header p { margin: 0; opacity: 0.8; font-size: 0.9rem; }

    /* Badge Status Header */
    .badge-status-lg {
        padding: 10px 20px; border-radius: 30px; font-weight: 700;
        font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-dipinjam { background: #dbeafe; color: #1e40af; }
    .status-dikembalikan { background: #d1fae5; color: #065f46; }
    .status-terlambat { background: #fee2e2; color: #991b1b; }
    .status-ditolak { background: #f1f5f9; color: #475569; }

    .ticket-body { padding: 40px; }

    /* Kotak Kode Pickup */
    .pickup-box {
        background: #f0fdf4; border: 2px dashed #22c55e;
        border-radius: 16px; padding: 25px; text-align: center;
        margin-bottom: 30px; position: relative;
    }
    .pickup-box h6 { color: #166534; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
    .pickup-code { font-size: 2.5rem; font-weight: 900; color: #15803d; letter-spacing: 5px; margin-bottom: 10px; }
    .pickup-box p { color: #166534; margin: 0; font-size: 0.9rem; }

    /* Info Grid */
    .section-title {
        font-size: 0.85rem; text-transform: uppercase; font-weight: 800;
        color: #1e3a8a; letter-spacing: 1px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 10px;
    }
    .section-title::after { content: ''; flex: 1; height: 2px; background: linear-gradient(90deg, #3b82f6, transparent); border-radius: 2px; }

    .info-box {
        background: #f8fafc; padding: 15px 20px; border-radius: 12px;
        border-left: 4px solid #3b82f6; margin-bottom: 15px;
    }
    .info-box .label { font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; margin-bottom: 5px; }
    .info-box .value { font-size: 1rem; color: #1e293b; font-weight: 600; }

    /* Kotak Lokasi Rak */
    .rak-box {
        background: #fffbeb; border: 1px solid #fcd34d;
        border-left: 5px solid #f59e0b; border-radius: 12px;
        padding: 20px; margin-bottom: 30px;
    }
    .rak-box h6 { color: #b45309; font-weight: 800; margin-bottom: 5px; }
    .rak-box p { color: #78350f; margin: 0; font-size: 1rem; }

    /* Buku Info */
    .buku-info-mini {
        display: flex; gap: 15px; align-items: center;
        background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0;
    }
    .buku-info-mini img { width: 60px; height: 85px; object-fit: cover; border-radius: 6px; }
    .buku-info-mini h6 { font-weight: 700; color: #1e293b; margin: 0 0 5px 0; }
    .buku-info-mini p { margin: 0; font-size: 0.85rem; color: #64748b; }

    /* Tombol */
    .btn-action-lg {
        padding: 12px 25px; border-radius: 10px; font-weight: 700;
        font-size: 0.95rem; transition: all 0.3s ease;
        display: inline-flex; align-items: center; gap: 8px; border: none;
    }
    .btn-action-lg:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
    .btn-back-detail { background: white; color: #475569; border: 2px solid #e2e8f0; }
    .btn-back-detail:hover { background: #f1f5f9; color: #1e293b; }

    @media (max-width: 768px) {
        .ticket-header { flex-direction: column; text-align: center; gap: 15px; padding: 25px 20px; }
        .ticket-header::after { display: none; }
        .ticket-body { padding: 25px 20px; }
        .pickup-code { font-size: 2rem; }
    }
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
            <div class="col-lg-9">
                <div class="card-ticket">
                    
                    <!-- HEADER TIKET -->
                    <div class="ticket-header">
                        <div>
                            <h3><i class="fas fa-receipt me-2"></i>Detail Peminjaman</h3>
                            <p>Kode Transaksi: #TRX-{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div>
                            @if($peminjaman->status == 'pending')
                                <span class="badge-status-lg status-pending"><i class="fas fa-hourglass-half"></i> Menunggu</span>
                            @elseif($peminjaman->status == 'dipinjam')
                                <span class="badge-status-lg status-dipinjam"><i class="fas fa-book-reader"></i> Dipinjam</span>
                            @elseif($peminjaman->status == 'terlambat')
                                <span class="badge-status-lg status-terlambat"><i class="fas fa-exclamation-triangle"></i> Terlambat</span>
                            @elseif($peminjaman->status == 'ditolak')
                                <span class="badge-status-lg status-ditolak"><i class="fas fa-times-circle"></i> Ditolak</span>
                            @else
                                <span class="badge-status-lg status-dikembalikan"><i class="fas fa-check-circle"></i> Dikembalikan</span>
                            @endif
                        </div>
                    </div>

                    <!-- BODY TIKET -->
                    <div class="ticket-body">

                        <!-- KOTAK KODE PICKUP (Hanya Muncul Jika Pending) -->
                        @if($peminjaman->status == 'pending' && $peminjaman->kode_pickup)
                        <div class="pickup-box">
                            <h6><i class="fas fa-key me-1"></i> Kode Pengambilan Buku</h6>
                            <div class="pickup-code">{{ $peminjaman->kode_pickup }}</div>
                            <p>Tunjukkan kode ini ke Admin perpustakaan untuk mengambil buku Anda.</p>
                        </div>
                        @endif

                        <div class="row">
                            <!-- KOLOM KIRI: Info Peminjam & Buku -->
                            <div class="col-md-6 mb-4">
                                <div class="section-title"><i class="fas fa-user"></i>Informasi Peminjam</div>
                                <div class="info-box">
                                    <div class="label">Nama Lengkap</div>
                                    <div class="value">{{ $peminjaman->user->name }}</div>
                                </div>
                                <div class="info-box">
                                    <div class="label">Kelas / NIS</div>
                                    <div class="value">{{ $peminjaman->user->kelas ?? '-' }} / {{ $peminjaman->user->nis ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="section-title"><i class="fas fa-book"></i>Informasi Buku</div>
                                <div class="buku-info-mini">
                                    @if($peminjaman->buku->foto)
                                        <img src="{{ $peminjaman->buku->foto }}" alt="Cover">
                                    @else
                                        <div style="width:60px; height:85px; background:#e2e8f0; border-radius:6px; display:flex; align-items:center; justify-content:center;">
                                            <i class="fas fa-book text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6>{{ $peminjaman->buku->judul }}</h6>
                                        <p><i class="fas fa-pen-nib me-1"></i> {{ $peminjaman->buku->pengarang }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KOTAK LOKASI RAK -->
                        @if($peminjaman->buku->lokasi_rak)
                        <div class="rak-box">
                            <h6><i class="fas fa-map-marker-alt me-1"></i> Lokasi Pengambilan Buku</h6>
                            <p>Silakan ambil buku ini di: <strong>{{ $peminjaman->buku->lokasi_rak }}</strong></p>
                        </div>
                        @endif

                        <!-- WAKTU & STATUS -->
                        <div class="section-title"><i class="fas fa-calendar-alt"></i>Waktu Transaksi</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-box" style="border-left-color: #10b981;">
                                    <div class="label">Tanggal Pinjam</div>
                                    <div class="value">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box" style="border-left-color: #f59e0b;">
                                    <div class="label">Batas Pengembalian</div>
                                    <div class="value">{{ $peminjaman->tanggal_kembali->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box" style="border-left-color: #3b82f6;">
                                    <div class="label">Denda Berjalan</div>
                                    <div class="value text-danger">
                                        @php $denda = $peminjaman->hitungDendaBerjalan(); @endphp
                                        @if($denda > 0)
                                            Rp {{ number_format($denda, 0, ',', '.') }}
                                        @else
                                            Rp 0
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        @if($peminjaman->catatan)
                        <div class="mt-3">
                            <div class="section-title"><i class="fas fa-edit"></i>Catatan Peminjam</div>
                            <div class="info-box" style="border-left-color: #8b5cf6;">
                                <div class="value" style="font-weight: 500; font-style: italic;">"{{ $peminjaman->catatan }}"</div>
                            </div>
                        </div>
                        @endif

                        <!-- Tombol Kembali -->
                        <div class="mt-5 pt-4 border-top text-end">
                            <a href="{{ route('peminjaman.index') }}" class="btn-action-lg btn-back-detail">
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