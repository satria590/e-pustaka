@extends('layouts.app')

@section('title', 'Form Pengajuan Peminjaman')

@section('content')
<style>
    /* Background Utama */
    .form-bg {
        position: relative;
        background: #f0fdf4; /* Latar hijau sangat lembut */
        min-height: 100vh;
        padding: 40px 0 60px 0;
    }
    
    /* Ornamen Background Abstrak (Hijau) */
    .form-bg::before {
        content: '';
        position: absolute;
        top: -100px; right: -100px;
        width: 400px; height: 400px;
        background: #bbf7d0; /* Hijau muda */
        border-radius: 50%;
        opacity: 0.5;
        filter: blur(80px);
        z-index: 0;
    }
    .form-bg::after {
        content: '';
        position: absolute;
        bottom: -100px; left: -100px;
        width: 300px; height: 300px;
        background: #fef08a; /* Kuning muda */
        border-radius: 50%;
        opacity: 0.4;
        filter: blur(80px);
        z-index: 0;
    }

    .form-card {
        max-width: 950px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.08);
        overflow: hidden;
        position: relative;
        z-index: 1;
        border: 1px solid rgba(255,255,255,0.8);
        display: flex;
        flex-direction: row;
    }

    /* ========================================= */
    /* SISI KIRI: INFO BUKU (TEMA HIJAU)         */
    /* ========================================= */
    .info-buku-side {
        flex: 0 0 40%;
        background: linear-gradient(135deg, #059669 0%, #10b981 100%); /* Hijau Navy */
        padding: 40px 30px;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    /* Ornamen di sisi kiri */
    .info-buku-side::after {
        content: '📖';
        position: absolute;
        bottom: -20px; right: -10px;
        font-size: 150px;
        opacity: 0.1;
        transform: rotate(-15deg);
    }

    /* Desain Cover Buku */
    .cover-buku-wrapper {
        width: 100%;
        height: 280px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        position: relative;
        z-index: 2;
    }
    .cover-buku-wrapper img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .cover-fallback {
        width: 100%; height: 100%;
        background: rgba(255,255,255,0.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 4rem; color: rgba(255,255,255,0.5);
        border: 2px dashed rgba(255,255,255,0.3);
    }

    .info-buku-side h3 {
        font-weight: 800;
        font-size: 1.5rem;
        line-height: 1.4;
        margin-bottom: 15px;
        position: relative;
        z-index: 2;
    }

    .info-buku-side .meta-info {
        font-size: 0.95rem;
        opacity: 0.9;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
        z-index: 2;
    }

    .status-tersedia {
        display: inline-block;
        background: #d1fae5; color: #065f46;
        padding: 8px 15px; border-radius: 20px;
        font-weight: 700; font-size: 0.85rem;
        margin-top: 20px;
        align-self: flex-start;
        position: relative;
        z-index: 2;
    }

    /* ========================================= */
    /* SISI KANAN: FORM PENGISIAN                */
    /* ========================================= */
    .form-side {
        flex: 1;
        padding: 40px 45px;
    }

    .form-side h4 {
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 5px;
        font-size: 1.5rem;
    }
    .form-side p.subtitle {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 30px;
    }

    .form-label { font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 8px; }
    .form-label i { color: #10b981; margin-right: 5px; } /* Ikon hijau */

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 15px;
        font-size: 0.95rem;
        background: #f8fafc;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #10b981; /* Fokus hijau */
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        background: white;
    }
    
    /* Desain Khusus Input yang Dikunci (Readonly) */
    .form-control[readonly] {
        background: #e2e8f0;
        cursor: not-allowed;
        font-weight: 600;
        color: #475569;
        border-color: #cbd5e1;
    }

    .btn-ajukan {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%); /* Tombol hijau */
        color: white; border: none;
        border-radius: 12px; padding: 15px; font-weight: 700;
        width: 100%; font-size: 1rem; transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }
    .btn-ajukan:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 12px 25px rgba(16, 185, 129, 0.5);
        color: white;
    }
    
    .btn-batal {
        background: white; color: #64748b; border: 2px solid #e2e8f0;
        border-radius: 12px; padding: 12px; font-weight: 600;
        width: 100%; font-size: 0.95rem; transition: all 0.3s ease;
        display: block; text-align: center; text-decoration: none; margin-top: 12px;
    }
    .btn-batal:hover { background: #f0fdf4; color: #059669; border-color: #10b981; }

    .form-check-input:checked { background-color: #10b981; border-color: #10b981; }
    .form-check-label { font-size: 0.85rem; color: #64748b; }
    .form-check-box {
        background: #f0fdf4;
        border: 1px dashed #6ee7b7;
        border-radius: 12px;
        padding: 15px;
    }

    /* ========================================= */
    /* RESPONSIVE (Tampilan HP)                  */
    /* ========================================= */
    @media (max-width: 768px) {
        .form-card {
            flex-direction: column;
            margin: 0 15px;
        }
        .info-buku-side {
            padding: 30px 20px;
            text-align: center;
        }
        .cover-buku-wrapper {
            width: 180px; height: 250px;
            margin: 0 auto 20px auto;
        }
        .status-tersedia {
            align-self: center;
        }
        .form-side {
            padding: 30px 20px;
        }
    }
</style>

<div class="form-bg">
    <div class="container">
        <div class="form-card">
            
            <!-- ========================================= -->
            <!-- SISI KIRI: INFO BUKU                      -->
            <!-- ========================================= -->
            <div class="info-buku-side">
                
                <!-- Tampilkan Foto Cover atau Ikon Fallback -->
                <div class="cover-buku-wrapper">
                    @if($buku->foto)
                        <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}">
                    @else
                        <div class="cover-fallback">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif
                </div>

                <h3>{{ $buku->judul }}</h3>
                <div class="meta-info">
                    <i class="fas fa-pen-nib"></i> {{ $buku->pengarang }}
                </div>
                <div class="meta-info">
                    <i class="fas fa-tag"></i> Kategori: {{ $buku->kategori }}
                </div>
                
                <span class="status-tersedia">
                    <i class="fas fa-check-circle me-1"></i> Stok Tersedia: {{ $buku->stok }}
                </span>
            </div>

            <!-- ========================================= -->
            <!-- SISI KANAN: FORMULIR                      -->
            <!-- ========================================= -->
            <div class="form-side">
                <h4><i class="fas fa-file-signature me-2 text-success"></i>Form Pengajuan</h4>
                <p class="subtitle">Lengkapi data di bawah untuk meminjam buku ini.</p>

                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                    <input type="hidden" name="is_pengajuan_siswa" value="1">

                    <!-- Data Siswa -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-user"></i>Nama Peminjam</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }} (otomatis)" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-school"></i>Kelas / NIS</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->kelas ?? '-' }} / {{ Auth::user()->nis ?? '-' }} (otomatis)" readonly>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-calendar-plus"></i>Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                            <small class="text-muted" style="font-size: 0.7rem;">*Dikunci oleh sistem.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-calendar-check"></i>Rencana Kembali</label>
                            <input type="date" name="tanggal_kembali" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" readonly>
                            <small class="text-muted" style="font-size: 0.7rem;">*Maksimal 7 hari.</small>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-edit"></i>Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Tulis catatan tambahan (misal: untuk tugas)..."></textarea>
                    </div>

                    <!-- Persetujuan -->
                    <div class="form-check-box mb-4">
                        <input class="form-check-input ms-0 me-2" type="checkbox" id="setuju" required>
                        <label class="form-check-label" for="setuju">
                            Saya menyetujui ketentuan peminjaman & sanksi keterlambatan yang berlaku.
                        </label>
                    </div>

                    <!-- Tombol -->
                    <button type="submit" class="btn-ajukan">
                        <i class="fas fa-paper-plane me-2"></i> Ajukan Peminjaman
                    </button>
                    <a href="{{ route('buku.index') }}" class="btn-batal">
                        Batal & Kembali ke Katalog
                    </a>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection