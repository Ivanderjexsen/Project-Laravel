<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $userFilter = $request->input('user');

        $query = Loan::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($userFilter) {
            $query->where('peminjam', $userFilter);
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate(10);

        $totalPinjam = Loan::count();
        $totalDipinjam = Loan::where('status', 'Dipinjam')->count();
        $totalDikembalikan = Loan::where('status', 'Dikembalikan')->count();

        $users = User::all();

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

        return view('admin.loans.index', compact('loans', 'status', 'userFilter', 'users', 'totalPinjam', 'totalDipinjam', 'totalDikembalikan', 'months', 'counts'));
    }

    public function edit($id)
    {
        $loan = Loan::findOrFail($id);
        $users = User::all();
        return view('admin.loans.edit', compact('loan', 'users'));
    }

    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'peminjam' => 'required|string|max:255',
            'buku' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required|in:Dipinjam,Dikembalikan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldStatus = $loan->status;

        $loan->update([
            'peminjam' => $request->peminjam,
            'buku' => $request->buku,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => $request->status,
        ]);

        // === UPDATE STOK TOTAL ===
        if ($oldStatus !== $request->status) {
            $buku = Buku::where('judul_buku', $request->buku)->first();
            if ($buku) {
                if ($request->status === 'Dikembalikan' && $oldStatus === 'Dipinjam') {
                    $buku->tambahStok();  // ✅ TAMBAH STOK TOTAL
                } elseif ($request->status === 'Dipinjam' && $oldStatus === 'Dikembalikan') {
                    $buku->kurangiStok();  // ✅ KURANGI STOK TOTAL
                }
            }
        }

        return redirect()->route('admin.loans.index')
            ->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    public function updateStatus(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Dipinjam,Dikembalikan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldStatus = $loan->status;

        $loan->update([
            'status' => $request->status,
        ]);

        // === UPDATE STOK TOTAL ===
        if ($oldStatus !== $request->status) {
            $buku = Buku::where('judul_buku', $loan->buku)->first();
            if ($buku) {
                if ($request->status === 'Dikembalikan' && $oldStatus === 'Dipinjam') {
                    $buku->tambahStok();  // ✅ TAMBAH STOK TOTAL
                } elseif ($request->status === 'Dipinjam' && $oldStatus === 'Dikembalikan') {
                    $buku->kurangiStok();  // ✅ KURANGI STOK TOTAL
                }
            }
        }

        return redirect()->route('admin.loans.index')
            ->with('success', 'Status peminjaman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);

        // === KEMBALIKAN STOK TOTAL ===
        if ($loan->status === 'Dipinjam') {
            $buku = Buku::where('judul_buku', $loan->buku)->first();
            if ($buku) {
                $buku->tambahStok();  // ✅ TAMBAH STOK TOTAL
            }
        }

        $loan->delete();

        return redirect()->route('admin.loans.index')
            ->with('success', 'Data peminjaman berhasil dihapus!');
    }

    public function userHistory($userId)
    {
        $user = User::findOrFail($userId);
        $loans = Loan::where('peminjam', $user->name)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.history', compact('user', 'loans'));
    }
}
