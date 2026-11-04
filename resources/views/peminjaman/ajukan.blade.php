@extends('layouts.app')

@section('title', 'Form Pengajuan Peminjaman')

@section('content')
<style>
    /* Background Utama */
    .form-bg {
        position: relative;
        background: #f0f4f8;
        min-height: 100vh;
        padding: 40px 0 60px 0;
    }
    
    /* Ornamen Background Abstrak */
    .form-bg::before {
        content: '';
        position: absolute;
        top: -100px; right: -100px;
        width: 400px; height: 400px;
        background: #c7d2fe;
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
        background: #fde68a;
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
    /* SISI KIRI: INFO BUKU (CARD EKSKLUSIF)     */
    /* ========================================= */
    .info-buku-side {
        flex: 0 0 40%;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
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

    .buku-icon-large {
        width: 100px; height: 130px;
        background: rgba(255,255,255,0.15);
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem;
        margin-bottom: 25px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
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
        background: #d4edda; color: #155724;
        padding: 6px 15px; border-radius: 20px;
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
    .form-label i { color: #3b82f6; margin-right: 5px; }

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 15px;
        font-size: 0.95rem;
        background: #f8fafc;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
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
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white; border: none;
        border-radius: 12px; padding: 15px; font-weight: 700;
        width: 100%; font-size: 1rem; transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }
    .btn-ajukan:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 12px 25px rgba(59, 130, 246, 0.5);
        color: white;
    }
    
    .btn-batal {
        background: white; color: #64748b; border: 2px solid #e2e8f0;
        border-radius: 12px; padding: 12px; font-weight: 600;
        width: 100%; font-size: 0.95rem; transition: all 0.3s ease;
        display: block; text-align: center; text-decoration: none; margin-top: 12px;
    }
    .btn-batal:hover { background: #f1f5f9; color: #334155; border-color: #cbd5e1; }

    .form-check-input:checked { background-color: #3b82f6; border-color: #3b82f6; }
    .form-check-label { font-size: 0.85rem; color: #64748b; }
    .form-check-box {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
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
        .buku-icon-large {
            margin: 0 auto 20px auto;
            width: 80px; height: 100px;
            font-size: 2.5rem;
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
                <div class="buku-icon-large">
                    <i class="fas fa-book"></i>
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
                <h4><i class="fas fa-file-signature me-2 text-primary"></i>Form Pengajuan</h4>
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