<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. HAPUS BUKU YANG TIDAK ADA FOTONYA
        // (Hati-hati: Ini akan menghapus buku lama Anda yang belum ada fotonya)
        Buku::whereNull('foto')->orWhere('foto', '')->delete();

        // 2. DAFTAR BUKU BESERTA LINK FOTONYA
        $bukus = [
            [
                'judul' => 'Algoritma dan Pemrograman',
                'isbn' => '978-602-01-1111-1',
                'pengarang' => 'Rinaldi Munir',
                'penerbit' => 'Informatika',
                'tahun_terbit' => 2020,
                'kategori' => 'Teknologi',
                'stok' => 5,
                'sinopsis' => 'Buku panduan lengkap mempelajari algoritma dasar dan logika pemrograman komputer.',
                'foto' => 'https://umsupress.umsu.ac.id/wp-content/uploads/2024/08/Algoritma-Pemprograman.png'
            ],
            [
                'judul' => 'Pemrograman Web dengan Laravel',
                'isbn' => '978-623-01-1234-5',
                'pengarang' => 'Satria Rahmansyah',
                'penerbit' => 'Informatika',
                'tahun_terbit' => 2024,
                'kategori' => 'Teknologi',
                'stok' => 5,
                'sinopsis' => 'Buku panduan lengkap belajar Laravel dari dasar hingga mahir.',
                'foto' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'judul' => 'Matematika Diskrit',
                'isbn' => '978-623-01-5678-9',
                'pengarang' => 'Dr. Budi Santoso',
                'penerbit' => 'Sains',
                'tahun_terbit' => 2023,
                'kategori' => 'Sains',
                'stok' => 3,
                'sinopsis' => 'Konsep matematika diskrit untuk ilmu komputer.',
                'foto' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'judul' => 'Fisika Dasar untuk SMA',
                'isbn' => '978-602-01-3333-3',
                'pengarang' => 'Mikrajuddin Abdullah',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2021,
                'kategori' => 'Sains',
                'stok' => 10,
                'sinopsis' => 'Buku pelajaran fisika lengkap dengan contoh soal dan pembahasan.',
                'foto' => 'https://images.unsplash.com/photo-1636466497217-26a8cbeaf0aa?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'judul' => 'Bumi Manusia',
                'isbn' => '978-979-97312-3-3',
                'pengarang' => 'Pramoedya Ananta Toer',
                'penerbit' => 'Lentera Dipantara',
                'tahun_terbit' => 1980,
                'kategori' => 'Fiksi',
                'stok' => 6,
                'sinopsis' => 'Novel sejarah legendaris karya sastrawan Indonesia.',
                'foto' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'judul' => 'Laskar Pelangi',
                'isbn' => '978-979-3062-79-2',
                'pengarang' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => 2005,
                'kategori' => 'Fiksi',
                'stok' => 8,
                'sinopsis' => 'Kisah inspiratif anak-anak Belitung dalam menempuh pendidikan.',
                'foto' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'judul' => 'Sejarah Indonesia Modern',
                'isbn' => '978-602-01-5555-5',
                'pengarang' => 'M.C. Ricklefs',
                'penerbit' => 'Serambi',
                'tahun_terbit' => 2008,
                'kategori' => 'Sejarah',
                'stok' => 4,
                'sinopsis' => 'Membahas perjalanan sejarah Indonesia dari masa kolonial hingga reformasi.',
                'foto' => 'https://images.unsplash.com/photo-1461360370896-922624d12aa1?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'judul' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'isbn' => '978-602-01-6666-6',
                'pengarang' => 'Yuval Noah Harari',
                'penerbit' => 'Kepustakaan Populer Gramedia',
                'tahun_terbit' => 2017,
                'kategori' => 'Non-Fiksi',
                'stok' => 5,
                'sinopsis' => 'Buku non-fiksi terlaris yang membedah sejarah evolusi manusia.',
                'foto' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'judul' => 'Manajemen Perpustakaan Sekolah',
                'isbn' => '978-602-01-7777-7',
                'pengarang' => 'Sutarno NS',
                'penerbit' => 'Sagung Seto',
                'tahun_terbit' => 2016,
                'kategori' => 'Non-Fiksi',
                'stok' => 2,
                'sinopsis' => 'Panduan mengelola perpustakaan sekolah yang efektif dan efisien.',
                'foto' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'judul' => 'Pemrograman Python untuk Pemula',
                'isbn' => '978-602-01-9999-9',
                'pengarang' => 'Abdul Kadir',
                'penerbit' => 'Andi Publisher',
                'tahun_terbit' => 2022,
                'kategori' => 'Teknologi',
                'stok' => 4,
                'sinopsis' => 'Belajar bahasa pemrograman Python dari nol hingga bisa membuat aplikasi sederhana.',
                'foto' => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?auto=format&fit=crop&w=600&q=80'
            ],
        ];

        // 3. MASUKKAN DATA KE DATABASE
        foreach ($bukus as $buku) {
            Buku::create($buku);
        }
    }
}