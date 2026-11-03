<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $bukus = [
            [
                'judul' => 'Pemrograman Web dengan Laravel',
                'pengarang' => 'Satria Rahmansyah',
                'kategori' => 'Teknologi',
                'isbn' => '978-623-01-1234-5',
                'stok' => 5,
                'penerbit' => 'Penerbit Tekno',
                'tahun_terbit' => 2024,
                'sinopsis' => 'Buku panduan lengkap belajar Laravel dari dasar hingga mahir.',
            ],
            [
                'judul' => 'Matematika Diskrit',
                'pengarang' => 'Dr. Budi Santoso',
                'kategori' => 'Sains',
                'isbn' => '978-623-01-5678-9',
                'stok' => 3,
                'penerbit' => 'Penerbit Sains',
                'tahun_terbit' => 2023,
                'sinopsis' => 'Konsep matematika diskrit untuk ilmu komputer.',
            ],
            [
                'judul' => 'Bahasa Inggris untuk Pemula',
                'pengarang' => 'Siti Aminah',
                'kategori' => 'Non-Fiksi',
                'isbn' => '978-623-02-9876-5',
                'stok' => 7,
                'penerbit' => 'Penerbit Edukasi',
                'tahun_terbit' => 2024,
                'sinopsis' => 'Belajar bahasa Inggris dengan metode praktis.',
            ],
        ];

        foreach ($bukus as $buku) {
            Buku::create($buku);
        }
    }
}