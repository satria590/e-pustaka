@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<style>
    .create-bg {
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 30px 0 60px 0;
    }
    .create-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px; padding: 25px 30px; color: white;
        margin-bottom: 25px; position: relative; overflow: hidden;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
    }
    .page-header::after { content: '📖'; position: absolute; right: 30px; top: 50%; transform: translateY(-50%); font-size: 80px; opacity: 0.15; }
    .page-header h4 { font-weight: 700; margin-bottom: 5px; font-size: 1.4rem; }
    .page-header p { opacity: 0.9; margin-bottom: 0; font-size: 0.95rem; }
    .breadcrumb-custom { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; opacity: 0.85; margin-top: 8px; }
    .breadcrumb-custom a { color: white; text-decoration: none; transition: opacity 0.2s; }
    .breadcrumb-custom a:hover { opacity: 0.7; }

    .card-create { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); overflow: hidden; position: relative; z-index: 1; height: 100%; }
    .card-create .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-bottom: none; padding: 18px 25px; }
    .card-create .card-header h5 { font-weight: 600; margin: 0; font-size: 1.05rem; }
    .card-create .card-body { padding: 25px; }

    .info-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 25px; color: white; height: 100%; position: relative; overflow: hidden; box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3); }
    .info-card::before { content: ''; position: absolute; width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,0.08); top: -80px; right: -80px; }
    .info-card::after { content: ''; position: absolute; width: 150px; height: 150px; border-radius: 50%; background: rgba(255,255,255,0.05); bottom: -60px; left: -60px; }
    .info-card h5 { font-weight: 700; margin-bottom: 20px; position: relative; z-index: 1; }
    .info-item { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 18px; position: relative; z-index: 1; }
    .info-item .info-icon { width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
    .info-item .info-text h6 { margin: 0 0 3px 0; font-weight: 600; font-size: 0.9rem; }
    .info-item .info-text p { margin: 0; font-size: 0.8rem; opacity: 0.85; line-height: 1.4; }

    .form-label { font-weight: 500; color: #495057; font-size: 0.88rem; margin-bottom: 8px; }
    .form-label i { color: #667eea; }
    .form-control, .form-select { border-radius: 10px; border: 2px solid #e9ecef; padding: 10px 15px; font-size: 0.92rem; transition: all 0.3s ease; background-color: #f8f9fa; }
    .form-control:focus, .form-select:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25); background-color: white; }
    .form-control:hover, .form-select:hover { border-color: #c3cfe2; }
    textarea.form-control { resize: vertical; min-height: 100px; }

    .btn-save { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 10px; padding: 11px 28px; font-weight: 500; color: white; transition: all 0.3s ease; font-size: 0.92rem; }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.45); color: white; }
    .btn-back { border-radius: 10px; padding: 11px 28px; font-weight: 500; transition: all 0.3s ease; font-size: 0.92rem; border: 2px solid #e9ecef; background: white; color: #495057; }
    .btn-back:hover { transform: translateY(-2px); background: #f8f9fa; border-color: #c3cfe2; color: #495057; }

    .tips-box { background: #fff9e6; border-left: 4px solid #ffc107; border-radius: 10px; padding: 15px 18px; margin-top: 20px; font-size: 0.85rem; color: #856404; }
    .tips-box i { color: #ffc107; margin-right: 6px; }

    @media (max-width: 768px) {
        .page-header::after { display: none; }
        .info-card { margin-bottom: 20px; }
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

                            <!-- TAMBAHAN: LOKASI RAK -->
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

                            <!-- INPUT FOTO URL -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-link me-1"></i>Link Foto Cover (Opsional)
                                </label>
                                <input type="url" name="foto" class="form-control @error('foto') is-invalid @enderror" value="{{ old('foto') }}" placeholder="Contoh: https://images.unsplash.com/photo-1544947950-fa07a98d237f">
                                <small class="text-muted">Tempelkan link gambar dari internet (Google/Pinterest).</small>
                                @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="tips-box">
                                <i class="fas fa-lightbulb"></i>
                                <strong>Catatan:</strong> Pastikan ISBN unik dan tidak duplikat. 
                                Stok akan otomatis bertambah jika buku ini sudah ada sebelumnya.
                            </div>
                            
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-save">
                                    <i class="fas fa-save me-1"></i>Simpan Buku
                                </button>
                                <a href="{{ route('buku.index') }}" class="btn btn-back">
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