<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // === TOTAL BUKU ===
        $totalBuku = Buku::count();

        // === HITUNG BUKU TERSEDIA ===
        $totalTersedia = 0;
        $totalDipinjam = 0;

        $bukus = Buku::all();
        foreach ($bukus as $buku) {
            $dipinjam = Loan::where('buku', $buku->judul_buku)
                ->where('status', 'Dipinjam')
                ->count();
            $totalDipinjam += $dipinjam;
            $totalTersedia += ($buku->stok - $dipinjam);
        }

        return view('dashboard.indexuser', compact(
            'totalBuku',
            'totalTersedia',
            'totalDipinjam'
        ));
    }
}
