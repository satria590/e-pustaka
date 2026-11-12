<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk Admin
        $totalBuku = Buku::count();
        $totalAnggota = User::count();
        $totalPeminjaman = Peminjaman::count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();

        // Data Grafik Admin
        $chartData = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // ==========================================
        // DATA KHUSUS SISWA
        // ==========================================
        $totalPinjamSiswa = 0;
        $pinjamAktifSiswa = 0;
        $totalDendaSiswa = 0;
        $pinjamSelesaiSiswa = 0;
        $pinjamanAktifDetail = collect();
        $adaKeterlambatan = false;

        if (Auth::check() && Auth::user()->role == 'siswa') {
            $userId = Auth::id();
            
            $totalPinjamSiswa = Peminjaman::where('user_id', $userId)->count();
            $pinjamAktifSiswa = Peminjaman::where('user_id', $userId)->whereIn('status', ['dipinjam', 'pending', 'terlambat'])->count();
            $pinjamSelesaiSiswa = Peminjaman::where('user_id', $userId)->where('status', 'dikembalikan')->count();
            
            // Ambil detail buku yang sedang dipinjam
            $pinjamanAktifDetail = Peminjaman::with('buku')
                ->where('user_id', $userId)
                ->whereIn('status', ['dipinjam', 'pending', 'terlambat'])
                ->latest()
                ->take(2)
                ->get();

            // Cek Keterlambatan secara Real-time & Hitung Denda Berjalan
            foreach ($pinjamanAktifDetail as $pa) {
                if ($pa->status == 'dipinjam' && Carbon::now()->startOfDay()->gt($pa->tanggal_kembali->startOfDay())) {
                    $adaKeterlambatan = true;
                    $hariTelat = Carbon::now()->startOfDay()->diffInDays($pa->tanggal_kembali->startOfDay());
                    $totalDendaSiswa += (abs($hariTelat) * 2000);
                }
            }
            
            // ==========================================
            // PERBAIKAN: Hanya jumlahkan denda yang BELUM dibayar 
            // (Statusnya masih dipinjam atau terlambat)
            // ==========================================
            $totalDendaSiswa += Peminjaman::where('user_id', $userId)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->sum('denda');
        }

        return view('dashboard', compact(
            'totalBuku', 'totalAnggota', 'totalPeminjaman', 'peminjamanAktif', 'chartData',
            'totalPinjamSiswa', 'pinjamAktifSiswa', 'totalDendaSiswa', 'pinjamSelesaiSiswa', 
            'pinjamanAktifDetail', 'adaKeterlambatan'
        ));
    }
}