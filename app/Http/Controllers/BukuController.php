<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::paginate(10);
        return view('books.index', compact('bukus'));
    }

    public function create()
    {
        // Generate kode buku otomatis
        $tahunBulan = date('Ym');
        $lastBuku = Buku::where('kode_buku', 'LIKE', 'B-' . $tahunBulan . '-%')
                        ->orderBy('kode_buku', 'desc')
                        ->first();
        
        if ($lastBuku) {
            $lastNumber = (int) substr($lastBuku->kode_buku, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }
        
        $kode_buku = 'B-' . $tahunBulan . '-' . $newNumber;
        
        return view('books.create', compact('kode_buku'));
    }

    public function store(Request $request)
    {
        // VALIDASI - PASTIKAN NAMA FIELD SESUAI DENGAN FORM
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',  // ✅ PAKAI pengarang
            'penerbit' => 'required|string|max:255',
            'tahun' => 'required|numeric|min:1900|max:' . date('Y'),
            'stok' => 'required|numeric|min:0',
        ]);

        // CEK DUPLIKAT
        $existingBuku = Buku::where('judul', $request->judul)
                            ->where('pengarang', $request->pengarang)
                            ->where('penerbit', $request->penerbit)
                            ->first();

        if ($existingBuku) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Buku dengan judul "' . $request->judul . '", pengarang "' . $request->pengarang . '", dan penerbit "' . $request->penerbit . '" sudah ada!');
        }

        // Generate kode buku
        $tahunBulan = date('Ym');
        $lastBuku = Buku::where('kode_buku', 'LIKE', 'B-' . $tahunBulan . '-%')
                        ->orderBy('kode_buku', 'desc')
                        ->first();
        
        if ($lastBuku) {
            $lastNumber = (int) substr($lastBuku->kode_buku, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }
        
        $kode_buku = 'B-' . $tahunBulan . '-' . $newNumber;

        // Simpan data
        Buku::create([
            'kode_buku' => $kode_buku,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,  // ✅ PAKAI pengarang
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun,
            'stok' => $request->stok,
        ]);

        return redirect()->route('buku.index')
                         ->with('success', 'Buku "' . $request->judul . '" berhasil ditambahkan dengan kode: ' . $kode_buku);
    }

    // Method lainnya...
}