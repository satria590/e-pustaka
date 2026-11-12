<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index()
    {
        // ==========================================
        // LOGIKA BARU: Update Denda & Status Otomatis
        // ==========================================
        $peminjamansAktif = Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->get();

        foreach ($peminjamansAktif as $pt) {
            $hariIni = Carbon::now()->startOfDay();
            $tglKembali = $pt->tanggal_kembali->startOfDay();

            if ($hariIni->gt($tglKembali)) {
                $hariTelat = $hariIni->diffInDays($tglKembali);
                $denda = abs($hariTelat) * 2000;
                
                $pt->update([
                    'status' => 'terlambat',
                    'denda' => $denda
                ]);
            }
        }
        // ==========================================

        if (Auth::user()->role == 'admin') {
            $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->paginate(10);
        } else {
            $peminjamans = Peminjaman::with(['user', 'buku'])->where('user_id', Auth::id())->latest()->paginate(10);
        }

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function laporan(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Akses ditolak.');
        }
        $query = Peminjaman::with(['user', 'buku'])->latest();
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        $peminjamans = $query->get();
        $statusFilter = $request->status ?? 'all';
        return view('peminjaman.laporan', compact('peminjamans', 'statusFilter'));
    }

    public function create()
    {
        $bukus = Buku::where('stok', '>', 0)->get();
        $users = User::all();
        return view('peminjaman.create', compact('bukus', 'users'));
    }

    public function formAjukan($buku_id)
    {
        $buku = Buku::findOrFail($buku_id);
        if ($buku->stok <= 0) {
            return redirect()->route('buku.index')->with('error', 'Maaf, stok buku ini sedang habis.');
        }
        return view('peminjaman.ajukan', compact('buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'catatan' => 'nullable|string',
        ]);

        $isPengajuanSiswa = $request->has('is_pengajuan_siswa');

        if (!$isPengajuanSiswa) {
            $request->validate(['user_id' => 'required|exists:users,id']);
        }

        DB::beginTransaction();
        try {
            $buku = Buku::where('id', $request->buku_id)->lockForUpdate()->first();

            if ($buku->stok <= 0) {
                DB::rollBack();
                return back()->with('error', 'Stok buku habis!');
            }

            if ($isPengajuanSiswa) {
                $kodePickup = 'PKP-' . strtoupper(Str::random(5));
                Peminjaman::create([
                    'user_id' => Auth::id(),
                    'buku_id' => $request->buku_id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => 'pending',
                    'kode_pickup' => $kodePickup,
                    'catatan' => $request->catatan,
                    'denda' => 0,
                ]);
                $pesan = 'Pengajuan berhasil! Tunjukkan Kode Pickup ' . $kodePickup . ' ke Admin saat mengambil buku.';
                $redirect = redirect()->route('peminjaman.index')->with('success', $pesan);
            } else {
                $buku->decrement('stok');
                Peminjaman::create([
                    'user_id' => $request->user_id,
                    'buku_id' => $request->buku_id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => 'dipinjam',
                    'denda' => 0,
                ]);
                $pesan = 'Peminjaman offline berhasil dicatat!';
                $redirect = redirect()->route('peminjaman.index')->with('success', $pesan);
            }

            DB::commit();
            return $redirect;

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        if (Auth::user()->role !== 'admin' && $peminjaman->user_id !== Auth::id()) {
            return back()->with('error', 'Akses ditolak.');
        }
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Akses ditolak.');
        }
        $bukus = Buku::all();
        $users = User::all();
        return view('peminjaman.edit', compact('peminjaman', 'bukus', 'users'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        $peminjaman->update($request->all());

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diupdate!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Akses ditolak.');
        }

        if ($peminjaman->status == 'dipinjam' || $peminjaman->status == 'terlambat') {
            $peminjaman->buku->increment('stok');
        }

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus!');
    }

    public function kembali($id)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Akses ditolak.');
        }

        $peminjaman = Peminjaman::findOrFail($id);
        
        // Blokir jika sudah dikembalikan
        if ($peminjaman->status == 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        $tanggalKembali = Carbon::now();
        $peminjaman->tanggal_pengembalian_aktual = $tanggalKembali;

        // Hitung denda jika telat
        if ($tanggalKembali->startOfDay()->gt($peminjaman->tanggal_kembali->startOfDay())) {
            $hariTelat = $tanggalKembali->startOfDay()->diffInDays($peminjaman->tanggal_kembali->startOfDay());
            $peminjaman->denda = abs($hariTelat) * 2000;
        } else {
            $peminjaman->denda = 0;
        }

        // ==========================================
        // PERBAIKAN: Apapun statusnya, setelah dikembalikan
        // Statusnya harus berubah menjadi 'dikembalikan'
        // ==========================================
        $peminjaman->status = 'dikembalikan'; 

        $peminjaman->buku->increment('stok');
        $peminjaman->save();

        return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dikembalikan!');
    }

    public function verifikasi($id)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Akses ditolak.');
        }

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::findOrFail($id);
            $buku = Buku::where('id', $peminjaman->buku_id)->lockForUpdate()->first();

            if ($buku->stok <= 0) {
                DB::rollBack();
                return back()->with('error', 'GAGAL VERIFIKASI! Stok buku sudah habis.');
            }

            $buku->decrement('stok');
            $peminjaman->update(['status' => 'dipinjam']);

            DB::commit();
            return back()->with('success', 'Peminjaman berhasil diverifikasi! Stok berkurang 1.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function tolak($id)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Akses ditolak.');
        }

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'ditolak']);

        return back()->with('success', 'Pengajuan peminjaman telah ditolak.');
    }
}