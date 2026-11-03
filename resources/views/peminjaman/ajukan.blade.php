@extends('layouts.app')

@section('title', 'Form Pengajuan Peminjaman')

@section('content')
<style>
    .form-bg {
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 40px 0;
    }
    .form-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    .form-card {
        max-width: 750px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        position: relative;
        z-index: 1;
        border: 1px solid rgba(255,255,255,0.5);
    }

    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px 30px;
        position: relative;
    }
    .form-header::after {
        content: '📝';
        position: absolute;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 60px;
        opacity: 0.15;
    }
    .form-header h4 { font-weight: 700; margin: 0 0 5px 0; font-size: 1.4rem; }
    .form-header p { margin: 0; opacity: 0.9; font-size: 0.9rem; }

    .form-body { padding: 35px 30px; }
    
    /* Kartu Info Buku */
    .buku-info {
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        border: 1px solid #e9ecef;
        border-left: 5px solid #667eea;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .buku-icon {
        width: 70px; height: 90px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; color: white;
        flex-shrink: 0;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    .buku-info h5 { margin: 0 0 8px 0; font-size: 1.2rem; font-weight: 700; color: #2d3436; }
    .buku-info p { margin: 0 0 8px 0; font-size: 0.9rem; color: #636e72; }
    .status-tersedia {
        display: inline-block;
        background: #d4edda; color: #155724;
        padding: 4px 12px; border-radius: 20px;
        font-weight: 600; font-size: 0.8rem;
    }

    .form-label { font-weight: 600; font-size: 0.88rem; color: #495057; margin-bottom: 8px; }
    .form-label i { color: #667eea; }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 0.95rem;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
        background: white;
    }
    .form-control[readonly] {
        background: #e9ecef;
        cursor: not-allowed;
        font-weight: 600;
        color: #495057;
    }

    .btn-ajukan {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white; border: none;
        border-radius: 12px; padding: 15px; font-weight: 700;
        width: 100%; font-size: 1.05rem; transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .btn-ajukan:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        color: white;
    }
    
    .btn-batal {
        background: white; color: #6c757d; border: 2px solid #e9ecef;
        border-radius: 12px; padding: 14px; font-weight: 600;
        width: 100%; font-size: 1rem; transition: all 0.3s ease;
        display: block; text-align: center; text-decoration: none; margin-top: 12px;
    }
    .btn-batal:hover { background: #f8f9fa; color: #495057; border-color: #dee2e6; }

    .form-check-input:checked { background-color: #667eea; border-color: #667eea; }
    .form-check-label { font-size: 0.9rem; color: #495057; }
</style>

<div class="form-bg">
    <div class="container">
        <div class="form-card">
            <div class="form-header">
                <h4><i class="fas fa-file-signature me-2"></i> Form Pengajuan Peminjaman</h4>
                <p>Lengkapi data di bawah untuk mengajukan peminjaman buku</p>
            </div>
            <div class="form-body">
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                    {{-- Tanda bahwa ini pengajuan siswa --}}
                    <input type="hidden" name="is_pengajuan_siswa" value="1">

                    <!-- Info Buku -->
                    <div class="buku-info">
                        <div class="buku-icon"><i class="fas fa-book"></i></div>
                        <div>
                            <h5>{{ $buku->judul }}</h5>
                            <p><i class="fas fa-user-edit me-1"></i> {{ $buku->pengarang }} &nbsp;|&nbsp; <i class="fas fa-tag me-1"></i> {{ $buku->kategori }}</p>
                            <span class="status-tersedia"><i class="fas fa-check-circle me-1"></i> Tersedia ({{ $buku->stok }} eksemplar)</span>
                        </div>
                    </div>

                    <!-- Data Siswa -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-user me-1"></i>Nama Peminjam</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }} (otomatis)" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-school me-1"></i>Kelas / NIS</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->kelas ?? '-' }} / {{ Auth::user()->nis ?? '-' }} (otomatis)" readonly>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-calendar-plus me-1"></i>Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-calendar-check me-1"></i>Tanggal Rencana Kembali <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kembali" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-edit me-1"></i>Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Tulis catatan tambahan di sini (misal: untuk tugas, dll)..."></textarea>
                    </div>

                    <!-- Persetujuan -->
                    <div class="form-check mb-4 p-3 bg-light rounded-3 border">
                        <input class="form-check-input ms-0 me-2" type="checkbox" id="setuju" required>
                        <label class="form-check-label" for="setuju">
                            Saya menyetujui ketentuan peminjaman & sanksi keterlambatan yang berlaku.
                        </label>
                    </div>

                    <!-- Tombol -->
                    <button type="submit" class="btn-ajukan">
                        <i class="fas fa-paper-plane me-2"></i> Ajukan Peminjaman Sekarang
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