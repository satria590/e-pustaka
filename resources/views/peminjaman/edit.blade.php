@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
<style>
    /* Background yang sama dengan halaman Index */
    .edit-bg {
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 30px 0 60px 0;
    }
    
    .edit-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    /* ====== HEADER SECTION ====== */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 25px 30px;
        color: white;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
    }

    .page-header::after {
        content: '✏️';
        position: absolute;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 80px;
        opacity: 0.15;
    }

    .page-header h4 {
        font-weight: 700;
        margin-bottom: 5px;
        font-size: 1.4rem;
    }

    .page-header p {
        opacity: 0.9;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .breadcrumb-custom {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        opacity: 0.85;
        margin-top: 8px;
    }

    .breadcrumb-custom a {
        color: white;
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .breadcrumb-custom a:hover {
        opacity: 0.7;
    }

    /* ====== CARD MODERN ====== */
    .card-edit {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        overflow: hidden;
        position: relative;
        z-index: 1;
        height: 100%;
    }

    .card-edit .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom: none;
        padding: 18px 25px;
    }

    .card-edit .card-header h5 {
        font-weight: 600;
        margin: 0;
        font-size: 1.05rem;
    }

    .card-edit .card-body {
        padding: 25px;
    }

    /* ====== INFO SIDE CARD (KIRI) ====== */
    .info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 25px;
        color: white;
        height: 100%;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
    }

    .info-card::before {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
        top: -80px;
        right: -80px;
    }

    .info-card::after {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        bottom: -60px;
        left: -60px;
    }

    .info-card h5 {
        font-weight: 700;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 18px;
        position: relative;
        z-index: 1;
    }

    .info-item .info-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .info-item .info-text h6 {
        margin: 0 0 3px 0;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .info-item .info-text p {
        margin: 0;
        font-size: 0.8rem;
        opacity: 0.85;
        line-height: 1.4;
    }

    /* ====== FORM ====== */
    .form-label {
        font-weight: 500;
        color: #495057;
        font-size: 0.88rem;
        margin-bottom: 8px;
    }

    .form-label i {
        color: #667eea;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 10px 15px;
        font-size: 0.92rem;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background-color: white;
    }

    .form-control:hover, .form-select:hover {
        border-color: #c3cfe2;
    }

    /* ====== TOMBOL ====== */
    .btn-update {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 11px 28px;
        font-weight: 500;
        color: white;
        transition: all 0.3s ease;
        font-size: 0.92rem;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.45);
        color: white;
    }

    .btn-back {
        border-radius: 10px;
        padding: 11px 28px;
        font-weight: 500;
        transition: all 0.3s ease;
        font-size: 0.92rem;
        border: 2px solid #e9ecef;
        background: white;
        color: #495057;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        background: #f8f9fa;
        border-color: #c3cfe2;
        color: #495057;
    }

    /* ====== TIPS BOX ====== */
    .tips-box {
        background: #fff9e6;
        border-left: 4px solid #ffc107;
        border-radius: 10px;
        padding: 15px 18px;
        margin-top: 20px;
        font-size: 0.85rem;
        color: #856404;
    }

    .tips-box i {
        color: #ffc107;
        margin-right: 6px;
    }

    @media (max-width: 768px) {
        .page-header::after { display: none; }
        .info-card { margin-bottom: 20px; }
    }
</style>

<div class="edit-bg">
    <div class="container">

        <!-- ====== PAGE HEADER ====== -->
        <div class="page-header">
            <h4><i class="fas fa-edit me-2"></i>Edit Peminjaman</h4>
            <p>Perbarui data peminjaman yang sudah ada di sistem</p>
            <div class="breadcrumb-custom">
                <a href="{{ route('peminjaman.index') }}"><i class="fas fa-home me-1"></i>Peminjaman</a>
                <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
                <span>Edit Data</span>
            </div>
        </div>

        <div class="row g-4">
            <!-- ====== KOLOM KIRI: INFO CARD ====== -->
            <div class="col-lg-4">
                <div class="info-card">
                    <h5><i class="fas fa-info-circle me-2"></i>Informasi Edit</h5>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="info-text">
                            <h6>Ubah Peminjam</h6>
                            <p>Pilih peminjam lain jika terjadi kesalahan input.</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="info-text">
                            <h6>Ubah Buku</h6>
                            <p>Ganti buku yang dipinjam jika diperlukan.</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="info-text">
                            <h6>Perbarui Tanggal</h6>
                            <p>Ubah tanggal pinjam atau tanggal kembali.</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="info-text">
                            <h6>Riwayat Perubahan</h6>
                            <p>Pastikan perubahan sudah sesuai sebelum disimpan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====== KOLOM KANAN: FORM ====== -->
            <div class="col-lg-8">
                <div class="card-edit card">
                    <div class="card-header">
                        <h5><i class="fas fa-pen me-2"></i>Formulir Edit Peminjaman</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-user me-1"></i>Peminjam <span class="text-danger">*</span>
                                    </label>
                                    <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Peminjam --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $peminjaman->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->role }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-book me-1"></i>Buku <span class="text-danger">*</span>
                                    </label>
                                    <select name="buku_id" class="form-select @error('buku_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Buku --</option>
                                        @foreach($bukus as $buku)
                                            <option value="{{ $buku->id }}" {{ $peminjaman->buku_id == $buku->id ? 'selected' : '' }}>
                                                {{ $buku->judul }} (Stok: {{ $buku->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('buku_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-plus me-1"></i>Tanggal Pinjam <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal_pinjam" 
                                           class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                                           value="{{ $peminjaman->tanggal_pinjam->format('Y-m-d') }}" required>
                                    @error('tanggal_pinjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-check me-1"></i>Tanggal Kembali <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal_kembali" 
                                           class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                                           value="{{ $peminjaman->tanggal_kembali->format('Y-m-d') }}" required>
                                    @error('tanggal_kembali')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tips Box -->
                            <div class="tips-box">
                                <i class="fas fa-lightbulb"></i>
                                <strong>Catatan:</strong> Perubahan data akan langsung tersimpan di sistem. 
                                Pastikan data yang diubah sudah benar sebelum menekan tombol Update.
                            </div>
                            
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-update">
                                    <i class="fas fa-save me-1"></i>Update Data
                                </button>
                                <a href="{{ route('peminjaman.index') }}" class="btn btn-back">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection