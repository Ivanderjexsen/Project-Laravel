<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserLoanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->input('status');

        $query = Loan::where('peminjam', $user->name);

        if ($status) {
            $query->where('status', $status);
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate(10);

        $totalPinjam = Loan::where('peminjam', $user->name)->count();
        $totalDipinjam = Loan::where('peminjam', $user->name)->where('status', 'Dipinjam')->count();
        $totalDikembalikan = Loan::where('peminjam', $user->name)->where('status', 'Dikembalikan')->count();

        return view('user.loans.index', compact('loans', 'status', 'totalPinjam', 'totalDipinjam', 'totalDikembalikan'));
    }

    public function create()
    {
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul_buku')->get();
        return view('user.loans.create', compact('bukus'));
    }

    public function store(Request $request)
    {
        Log::info('========================================');
        Log::info('📌 PROSES PEMINJAMAN DIMULAI');
        Log::info('📌 User: ' . Auth::user()->name);
        Log::info('========================================');

        $validator = Validator::make($request->all(), [
            'buku_id' => 'required|exists:bukus,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $buku = Buku::findOrFail($request->buku_id);

        // Cek stok tersedia
        $stokTersedia = $buku->getStokTersedia();

        if ($stokTersedia <= 0) {
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

        Log::info('📌 Buku: ' . $buku->judul_buku);
        Log::info('📌 Total Stok: ' . $buku->stok);
        Log::info('📌 Stok Tersedia SEBELUM: ' . $buku->getStokTersedia());

        // === JANGAN KURANGI TOTAL STOK ===
        // Total stok TETAP, stok tersedia dihitung dari total - dipinjam

        // Buat peminjaman
        $loan = Loan::create([
            'peminjam' => Auth::user()->name,
            'buku' => $buku->judul_buku,
            'tanggal_pinjam' => now(),
            'status' => 'Dipinjam',
        ]);

        Log::info('📌 Total Stok SETELAH: ' . $buku->stok . ' (TETAP)');
        Log::info('📌 Stok Tersedia SETELAH: ' . $buku->getStokTersedia());
        Log::info('📌 Peminjaman ID: ' . $loan->id);
        Log::info('========================================');

        return redirect()->route('user.loans.index')
            ->with('success', "Buku '{$buku->judul_buku}' berhasil dipinjam! Stok tersisa: {$buku->getStokTersedia()}");
    }

    public function show($id)
    {
        $loan = Loan::where('id', $id)
            ->where('peminjam', Auth::user()->name)
            ->firstOrFail();

        return view('user.loans.detail', compact('loan'));
    }

    public function returnBook($id)
    {
        Log::info('========================================');
        Log::info('📌 PROSES PENGEMBALIAN DIMULAI');
        Log::info('📌 User: ' . Auth::user()->name);
        Log::info('========================================');

        $loan = Loan::where('id', $id)
            ->where('peminjam', Auth::user()->name)
            ->firstOrFail();

        if ($loan->status === 'Dikembalikan') {
            return redirect()->back()
                ->with('error', 'Buku ini sudah dikembalikan!');
        }

        Log::info('📌 Buku: ' . $loan->buku);

        $buku = Buku::where('judul_buku', $loan->buku)->first();

        if ($buku) {
            Log::info('📌 Total Stok SEBELUM: ' . $buku->stok . ' (TETAP)');
            Log::info('📌 Stok Tersedia SEBELUM: ' . $buku->getStokTersedia());
        }

        // === JANGAN TAMBAH TOTAL STOK ===
        // Total stok TETAP

        $loan->update([
            'status' => 'Dikembalikan',
        ]);

        if ($buku) {
            Log::info('📌 Total Stok SETELAH: ' . $buku->stok . ' (TETAP)');
            Log::info('📌 Stok Tersedia SETELAH: ' . $buku->getStokTersedia());
        }

        Log::info('📌 Status diubah menjadi Dikembalikan');
        Log::info('========================================');

        return redirect()->route('user.loans.index')
            ->with('success', "Buku '{$loan->buku}' berhasil dikembalikan!");
    }

    public function getUserHistory($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $loans = Loan::where('peminjam', $user->name)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.history', compact('user', 'loans'));
    }
}
