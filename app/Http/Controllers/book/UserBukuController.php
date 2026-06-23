<?php

namespace App\Http\Controllers\book;

use App\Models\Buku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBukuController extends Controller
{
    /**
     * Display a listing of books for user.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $query = Buku::query();

        if ($keyword) {
            $query->where('judul_buku', 'LIKE', "%{$keyword}%")
                ->orWhere('pengarang', 'LIKE', "%{$keyword}%")
                ->orWhere('penerbit', 'LIKE', "%{$keyword}%")
                ->orWhere('kode_buku', 'LIKE', "%{$keyword}%");
        }

        $bukus = $query->orderBy('judul_buku', 'asc')->paginate(8);

        // Hitung statistik
        $totalBuku = Buku::count();
        $totalTersedia = Buku::all()->filter(function ($buku) {
            return $buku->getStokTersedia() > 0;
        })->count();
        $totalTidakTersedia = $totalBuku - $totalTersedia;

        return view('user.book.index', compact('bukus', 'keyword', 'totalBuku', 'totalTersedia', 'totalTidakTersedia'));
    }

    /**
     * Display the specified book details.
     */
    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        $stokTersedia = $buku->getStokTersedia();
        $isAvailable = $stokTersedia > 0;

        return view('user.book.detail', compact('buku', 'stokTersedia', 'isAvailable'));
    }
}
