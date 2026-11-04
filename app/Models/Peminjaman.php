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
        'kode_pickup' // <-- TAMBAHAN
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
        return Carbon::now()->gt($this->tanggal_kembali);
    }

    public function hitungDendaBerjalan()
    {
        if (in_array($this->status, ['dikembalikan', 'terlambat', 'ditolak', 'pending'])) {
            return $this->denda;
        }

        $hariIni = Carbon::now();
        if ($hariIni->gt($this->tanggal_kembali)) {
            $hariTelat = $hariIni->diffInDays($this->tanggal_kembali);
            return $hariTelat * 2000;
        }

        return 0;
    }
}