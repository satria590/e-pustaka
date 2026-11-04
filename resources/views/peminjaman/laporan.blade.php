@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')
<style>
    .laporan-container {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        max-width: 1200px;
        margin: 0 auto;
    }

    .header-laporan {
        text-align: center;
        border-bottom: 3px double #000;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .header-laporan h2 { font-weight: 800; margin-bottom: 5px; text-transform: uppercase; }
    .header-laporan p { margin: 0; font-size: 0.9rem; color: #666; }

    .table-laporan {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .table-laporan th, .table-laporan td {
        border: 1px solid #ddd;
        padding: 10px 12px;
        text-align: left;
    }

    .table-laporan th {
        background-color: #f2f2f2;
        font-weight: 700;
        text-align: center;
    }

    .table-laporan td { vertical-align: middle; }

    .ttd-area {
        margin-top: 50px;
        display: flex;
        justify-content: flex-end;
        page-break-inside: avoid;
    }

    .ttd-box {
        text-align: center;
        width: 250px;
    }

    .ttd-box p { margin-bottom: 80px; }

    /* CSS Khusus Saat Di-Print */
    @media print {
        body { background: white !important; }
        .navbar, footer, .btn-print, .filter-section {
            display: none !important; /* Sembunyikan navbar, footer, dan tombol saat print */
        }
        .laporan-container {
            box-shadow: none !important;
            padding: 0 !important;
            max-width: 100% !important;
        }
        .table-laporan th { background-color: #e0e0e0 !important; -webkit-print-color-adjust: exact; }
    }
</style>

<div class="container py-4">
    
    <!-- Tombol Aksi (Akan hilang saat di-print) -->
    <div class="d-flex justify-content-between align-items-center mb-4 btn-print">
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary px-4 py-2" style="border-radius: 10px; font-weight: 600;">
            <i class="fas fa-print me-2"></i> Cetak / Simpan PDF
        </button>
    </div>

    <!-- Area Laporan -->
    <div class="laporan-container">
        <div class="header-laporan">
            <h2>Laporan Data Peminjaman Buku</h2>
            <p>Sistem Informasi e-Pustaka - SMK Negeri 5</p>
            <p>Tanggal Cetak: {{ date('d F Y') }}</p>
        </div>

        <table class="table-laporan">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Peminjam</th>
                    <th width="25%">Judul Buku</th>
                    <th width="12%">Tgl Pinjam</th>
                    <th width="12%">Tgl Kembali</th>
                    <th width="13%">Status</th>
                    <th width="13%">Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $key => $peminjaman)
                <tr>
                    <td style="text-align: center;">{{ $key + 1 }}</td>
                    <td>
                        <strong>{{ $peminjaman->user->name }}</strong><br>
                        <small style="color: #666;">{{ $peminjaman->user->email }}</small>
                    </td>
                    <td>{{ $peminjaman->buku->judul }}</td>
                    <td style="text-align: center;">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td style="text-align: center;">{{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</td>
                    <td style="text-align: center;">
                        {{ ucfirst($peminjaman->status) }}
                    </td>
                    <td style="text-align: right;">
                        @if($peminjaman->denda > 0)
                            Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px;">Belum ada data peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Area Tanda Tangan -->
        <div class="ttd-area">
            <div class="ttd-box">
                <p>Mengetahui,<br>Kepala Perpustakaan</p>
                <strong><u>...........................................</u></strong>
                <br>NIP. ................................
            </div>
        </div>
    </div>
</div>
@endsection