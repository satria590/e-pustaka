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
        // 'alasan_tolak' // (Uncomment jika Anda menambah kolom ini di database)
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

    // Relasi ke tabel denda (jika ada)
    public function dendaRelation()
    {
        return $this->hasOne(Denda::class);
    }

    public function isTerlambat()
    {
        if (in_array($this->status, ['dikembalikan', 'ditolak', 'pending'])) {
            return false;
        }
        return Carbon::now()->gt($this->tanggal_kembali);
    }

    public function hitungDenda()
    {
        if ($this->tanggal_pengembalian_aktual) {
            $tanggalKembali = $this->tanggal_pengembalian_aktual;
        } else {
            $tanggalKembali = Carbon::now();
        }

        if ($tanggalKembali->gt($this->tanggal_kembali)) {
            // Gunakan diffInDays dengan parameter false agar hasilnya positif
            $hariTelat = $tanggalKembali->diffInDays($this->tanggal_kembali, false); 
            // Note: cek logika diffInDays Anda, jika minus dibalik
            if ($hariTelat < 0) {
                $hariTelat = abs($hariTelat);
                return $hariTelat * 2000;
            }
        }
        return 0;
    }
}