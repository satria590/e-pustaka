<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    protected $fillable = [
        'judul', 
        'pengarang', 
        'kategori', 
        'isbn',
        'stok', 
        'penerbit', 
        'tahun_terbit', 
        'sinopsis',
        'foto',
        'lokasi_rak' // <-- Tambahan Lokasi Rak
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function isAvailable()
    {
        return $this->stok > 0;
    }
}