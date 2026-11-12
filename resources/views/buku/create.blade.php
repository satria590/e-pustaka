@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<style>
    .create-bg {
        position: relative;
        background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
        min-height: 100vh;
        padding: 30px 0 60px 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-radius: 20px; padding: 30px 40px; color: white;
        margin-bottom: 30px; position: relative; overflow: hidden;
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.25);
    }
    .page-header::after { content: '📖'; position: absolute; right: 40px; top: 50%; transform: translateY(-50%); font-size: 100px; opacity: 0.15; }
    .page-header h4 { font-weight: 800; margin-bottom: 5px; font-size: 1.6rem; }
    .page-header p { opacity: 0.9; margin-bottom: 0; font-size: 1rem; }
    .breadcrumb-custom { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; opacity: 0.85; margin-top: 10px; }
    .breadcrumb-custom a { color: white; text-decoration: none; transition: opacity 0.2s; font-weight: 500; }
    .breadcrumb-custom a:hover { opacity: 0.7; }

    .card-create { border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); background: white; overflow: hidden; position: relative; z-index: 1; height: 100%; }
    .card-create .card-header { background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 20px 25px; }
    .card-create .card-header h5 { font-weight: 800; color: #1e3a8a; margin: 0; font-size: 1.1rem; }
    .card-create .card-body { padding: 30px; }

    .info-card { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 20px; padding: 30px; color: white; height: 100%; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.25); }
    .info-card::before { content: ''; position: absolute; width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,0.08); top: -80px; right: -80px; }
    .info-card h5 { font-weight: 800; margin-bottom: 25px; position: relative; z-index: 1; font-size: 1.2rem; }
    .info-item { display: flex; align-items: flex-start; gap: 15px; margin-bottom: 20px; position: relative; z-index: 1; }
    .info-item .info-icon { width: 40px; height: 40px; border-radius: 12px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .info-item .info-text h6 { margin: 0 0 4px 0; font-weight: 700; font-size: 0.95rem; }
    .info-item .info-text p { margin: 0; font-size: 0.85rem; opacity: 0.85; line-height: 1.4; }

    .form-label { font-weight: 600; color: #334155; font-size: 0.9rem; margin-bottom: 8px; }
    .form-label i { color: #3b82f6; }
    .form-control, .form-select { border-radius: 12px; border: 2px solid #e2e8f0; padding: 12px 15px; font-size: 0.95rem; transition: all 0.3s ease; background-color: #f8fafc; }
    .form-control:focus, .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15); background-color: white; }
    .form-control:hover, .form-select:hover { border-color: #cbd5e1; }
    textarea.form-control { resize: vertical; min-height: 120px; }

    .btn-save { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none; border-radius: 12px; padding: 12px 30px; font-weight: 700; color: white; transition: all 0.3s ease; font-size: 0.95rem; box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3); }
    .btn-save:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4); color: white; }
    .btn-back { border-radius: 12px; padding: 12px 30px; font-weight: 600; transition: all 0.3s ease; font-size: 0.95rem; border: 2px solid #e2e8f0; background: white; color: #475569; }
    .btn-back:hover { transform: translateY(-3px); background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

    .tips-box { background: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 12px; padding: 15px 20px; margin-top: 25px; font-size: 0.9rem; color: #92400e; }
    .tips-box i { color: #f59e0b; margin-right: 8px; }

    @media (max-width: 768px) {
        .page-header::after { display: none; }
        .info-card { margin-bottom: 20px; }
        .card-create .card-body { padding: 20px; }
    }
</style>

<div class="create-bg">
    <div class="container">
        <div class="page-header">
            <h4><i class="fas fa-plus-circle me-2"></i>Tambah Buku Baru</h4>
            <p>Lengkapi formulir di bawah untuk menambahkan koleksi buku baru</p>
            <div class="breadcrumb-custom">
                <a href="{{ route('buku.index') }}"><i class="fas fa-home me-1"></i>Buku</a>
                <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
                <span>Tambah Data</span>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="info-card">
                    <h5><i class="fas fa-info-circle me-2"></i>Informasi</h5>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-heading"></i></div>
                        <div class="info-text"><h6>Judul Buku</h6><p>Masukkan judul buku secara lengkap dan jelas.</p></div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-user-edit"></i></div>
                        <div class="info-text"><h6>Pengarang</h6><p>Tulis nama pengarang atau penulis buku.</p></div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-building"></i></div>
                        <div class="info-text"><h6>Penerbit</h6><p>Nama penerbit dan tahun terbit buku.</p></div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-boxes"></i></div>
                        <div class="info-text"><h6>Stok Buku</h6><p>Jumlah stok yang tersedia di perpustakaan.</p></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card-create card">
                    <div class="card-header">
                        <h5><i class="fas fa-book-medical me-2"></i>Formulir Tambah Buku</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('buku.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-8 mb-4">
                                    <label class="form-label"><i class="fas fa-book me-1"></i>Judul Buku <span class="text-danger">*</span></label>
                                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Contoh: Pemrograman Web dengan Laravel" required>
                                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label"><i class="fas fa-barcode me-1"></i>ISBN <span class="text-danger">*</span></label>
                                    <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn') }}" placeholder="978-xxx-xxx-xxx-x" required>
                                    @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label"><i class="fas fa-user-edit me-1"></i>Pengarang <span class="text-danger">*</span></label>
                                    <input type="text" name="pengarang" class="form-control @error('pengarang') is-invalid @enderror" value="{{ old('pengarang') }}" placeholder="Nama pengarang" required>
                                    @error('pengarang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label"><i class="fas fa-building me-1"></i>Penerbit <span class="text-danger">*</span></label>
                                    <input type="text" name="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit') }}" placeholder="Nama penerbit" required>
                                    @error('penerbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label class="form-label"><i class="fas fa-calendar me-1"></i>Tahun Terbit <span class="text-danger">*</span></label>
                                    <input type="number" name="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}" required>
                                    @error('tahun_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label"><i class="fas fa-boxes me-1"></i>Stok <span class="text-danger">*</span></label>
                                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', 1) }}" min="0" required>
                                    @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label"><i class="fas fa-tags me-1"></i>Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Teknologi" {{ old('kategori') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                        <option value="Sains" {{ old('kategori') == 'Sains' ? 'selected' : '' }}>Sains</option>
                                        <option value="Non-Fiksi" {{ old('kategori') == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                                        <option value="Fiksi" {{ old('kategori') == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                                        <option value="Sejarah" {{ old('kategori') == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                                        <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <!-- LOKASI RAK -->
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Lokasi Rak</label>
                                    <input type="text" name="lokasi_rak" class="form-control @error('lokasi_rak') is-invalid @enderror" value="{{ old('lokasi_rak') }}" placeholder="Contoh: Rak A-01, Lantai 2">
                                    <small class="text-muted">Isi lokasi rak agar memudahkan siswa saat mengambil buku.</small>
                                    @error('lokasi_rak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-align-left me-1"></i>Sinopsis</label>
                                <textarea name="sinopsis" class="form-control @error('sinopsis') is-invalid @enderror" placeholder="Tulis sinopsis singkat tentang buku ini...">{{ old('sinopsis') }}</textarea>
                                @error('sinopsis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- FOTO URL -->
                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-link me-1"></i>Link Foto Cover (Opsional)</label>
                                <input type="url" name="foto" class="form-control @error('foto') is-invalid @enderror" value="{{ old('foto') }}" placeholder="Contoh: https://images.unsplash.com/photo-1544947950-fa07a98d237f">
                                <small class="text-muted">Tempelkan link gambar dari internet (Google/Pinterest).</small>
                                @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="tips-box">
                                <i class="fas fa-lightbulb"></i>
                                <strong>Catatan:</strong> Pastikan ISBN unik dan tidak duplikat. Stok akan otomatis bertambah jika buku ini sudah ada sebelumnya.
                            </div>
                            
                            <div class="d-flex gap-3 mt-4">
                                <button type="submit" class="btn btn-save">
                                    <i class="fas fa-save me-2"></i>Simpan Buku
                                </button>
                                <a href="{{ route('buku.index') }}" class="btn btn-back">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
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