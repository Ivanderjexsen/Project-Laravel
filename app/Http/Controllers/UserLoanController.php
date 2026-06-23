<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserLoanController extends Controller
{
    /**
     * Display a listing of user's own loans (HISTORY).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->input('status');

        // Query hanya untuk user yang login
        $query = Loan::where('peminjam', $user->name);

        if ($status) {
            $query->where('status', $status);
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistik user
        $totalPinjam = Loan::where('peminjam', $user->name)->count();
        $totalDipinjam = Loan::where('peminjam', $user->name)->where('status', 'Dipinjam')->count();
        $totalDikembalikan = Loan::where('peminjam', $user->name)->where('status', 'Dikembalikan')->count();

        return view('user.loans.index', compact('loans', 'status', 'totalPinjam', 'totalDipinjam', 'totalDikembalikan'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create()
    {
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul_buku')->get();
        return view('user.loans.create', compact('bukus'));
    }

    /**
     * Store a newly created loan.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'buku_id' => 'required|exists:bukus,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $buku = Buku::findOrFail($request->buku_id);

        // Cek stok
        if ($buku->getStokTersedia() <= 0) {
            return redirect()->back()
                ->with('error', 'Stok buku "' . $buku->judul_buku . '" sedang habis!')
                ->withInput();
        }

        // Cek apakah user sudah meminjam buku ini
        $existing = Loan::where('peminjam', Auth::user()->name)
            ->where('buku', $buku->judul_buku)
            ->where('status', 'Dipinjam')
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Anda sudah meminjam buku "' . $buku->judul_buku . '" ini!')
                ->withInput();
        }

        // Buat peminjaman
        $loan = Loan::create([
            'peminjam' => Auth::user()->name,
            'buku' => $buku->judul_buku,
            'tanggal_pinjam' => now(),
            'status' => 'Dipinjam',
        ]);

        return redirect()->route('user.loans.index')
            ->with('success', "Buku '{$buku->judul_buku}' berhasil dipinjam!");
    }

    /**
     * Display the specified loan (HISTORY DETAIL).
     */
    public function show($id)
    {
        // Ambil data loan milik user yang login
        $loan = Loan::where('id', $id)
            ->where('peminjam', Auth::user()->name)
            ->firstOrFail();

        return view('user.loans.detail', compact('loan'));
    }

    /**
     * Return book (User only).
     */
    public function returnBook($id)
    {
        $loan = Loan::where('id', $id)
            ->where('peminjam', Auth::user()->name)
            ->firstOrFail();

        if ($loan->status === 'Dikembalikan') {
            return redirect()->back()
                ->with('error', 'Buku ini sudah dikembalikan!');
        }

        $loan->update([
            'status' => 'Dikembalikan',
        ]);

        return redirect()->route('user.loans.index')
            ->with('success', 'Buku berhasil dikembalikan!');
    }

    /**
     * Get loan history for a specific user (for admin view).
     */
    public function getUserHistory($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $loans = Loan::where('peminjam', $user->name)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.history', compact('user', 'loans'));
    }
}
