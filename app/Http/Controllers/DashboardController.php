<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';

        // === DATA UNTUK ADMIN ===
        if ($isAdmin) {
            // Statistik Admin
            $totalBuku = Buku::count();
            $totalUser = User::count();

            // Hitung stok
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

            // Data grafik admin
            $months = [];
            $counts = [];

            $grouped = Loan::selectRaw('MONTH(tanggal_pinjam) as month, YEAR(tanggal_pinjam) as year, COUNT(*) as total')
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

            foreach ($grouped as $item) {
                $months[] = date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year));
                $counts[] = $item->total;
            }

            if (empty($months)) {
                $months = ['Belum ada data'];
                $counts = [0];
            }

            // Data peminjaman terbaru admin
            $recentLoans = Loan::with(['user', 'buku'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return view('dashboard.index', compact(
                'isAdmin',
                'totalBuku',
                'totalUser',
                'totalTersedia',
                'totalDipinjam',
                'months',
                'counts',
                'recentLoans'
            ));
        }

        // === DATA UNTUK USER ===
        else {
            // Statistik User
            $totalBuku = Buku::count();

            // Hitung stok
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

            // Histori peminjaman user
            $userLoans = Loan::where('peminjam', $user->name)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            $totalUserPinjam = Loan::where('peminjam', $user->name)->count();
            $totalUserDipinjam = Loan::where('peminjam', $user->name)->where('status', 'Dipinjam')->count();
            $totalUserDikembalikan = Loan::where('peminjam', $user->name)->where('status', 'Dikembalikan')->count();

            return view('dashboard.index', compact(
                'isAdmin',
                'totalBuku',
                'totalTersedia',
                'totalDipinjam',
                'userLoans',
                'totalUserPinjam',
                'totalUserDipinjam',
                'totalUserDikembalikan'
            ));
        }
    }
}
