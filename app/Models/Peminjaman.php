<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id', 
        'buku_id', 
        'tanggal_pinjam',
        'tanggal_kembali', 
        'tanggal_pengembalian_aktual',
        'status', 
        'denda',
        'catatan',
        'kode_pickup'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_pengembalian_aktual' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function isTerlambat()
    {
        if (in_array($this->status, ['dikembalikan', 'ditolak', 'pending'])) {
            return false;
        }
        return Carbon::now()->startOfDay()->gt($this->tanggal_kembali->startOfDay());
    }

    // FUNGSI PERBAIKAN: Hitung denda berjalan
    public function hitungDendaBerjalan()
    {
        // Jika sudah dikembalikan atau ditolak, pakai denda yang tersimpan
        if (in_array($this->status, ['dikembalikan', 'ditolak'])) {
            return $this->denda;
        }

        // Jika status pending, belum ada denda
        if ($this->status == 'pending') {
            return 0;
        }

        // Hitung selisih hari
        $hariIni = Carbon::now()->startOfDay();
        $tglKembali = $this->tanggal_kembali->startOfDay();

        if ($hariIni->gt($tglKembali)) {
            $hariTelat = $hariIni->diffInDays($tglKembali);
            return abs($hariTelat) * 2000; // Rp 2.000/hari
        }

        return 0;
    }
}