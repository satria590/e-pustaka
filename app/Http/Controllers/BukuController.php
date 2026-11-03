<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::latest()->paginate(10);
        return view('buku.index', compact('bukus'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'isbn' => 'required|string|unique:bukus|max:20',
            'stok' => 'required|integer|min:0',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'sinopsis' => 'nullable|string',
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'isbn' => 'required|string|unique:bukus,isbn,' . $buku->id . '|max:20',
            'stok' => 'required|integer|min:0',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'sinopsis' => 'nullable|string',
        ]);

        $buku->update($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy(Buku $buku)
    {
        // Cek apakah buku sedang dipinjam
        if ($buku->peminjamans()->where('status', 'dipinjam')->exists()) {
            return back()->with('error', 'Buku sedang dipinjam, tidak bisa dihapus!');
        }

        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $bukus = Buku::where('judul', 'LIKE', "%{$keyword}%")
            ->orWhere('pengarang', 'LIKE', "%{$keyword}%")
            ->orWhere('kategori', 'LIKE', "%{$keyword}%")
            ->orWhere('isbn', 'LIKE', "%{$keyword}%")
            ->paginate(10);

        return view('buku.index', compact('bukus', 'keyword'));
    }
}