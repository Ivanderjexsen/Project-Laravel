<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // untuk query agregat (opsional, tapi disiapkan)

class LoanController extends Controller
{
    /**
     * Menampilkan daftar semua peminjaman dan data chart.
     */
    public function index()
{
    $loans = Loan::all();

    // Ambil data per bulan (dari semua data yang ada)
    $months = [];
    $counts = [];

    // Group by bulan dan tahun
    $grouped = Loan::selectRaw('MONTH(tanggal_pinjam) as month, YEAR(tanggal_pinjam) as year, COUNT(*) as total')
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'asc')
                    ->orderBy('month', 'asc')
                    ->get();

    foreach ($grouped as $item) {
        $months[] = date('M Y', mktime(0,0,0, $item->month, 1, $item->year));
        $counts[] = $item->total;
    }

    // Jika tidak ada data sama sekali, beri dummy agar grafik tetap tampil dengan pesan
    if (empty($months)) {
        $months = ['Belum ada data'];
        $counts = [0];
    }

    return view('loans.index', compact('loans', 'months', 'counts'));
}

    /**
     * Menampilkan form untuk membuat peminjaman baru.
     */
    public function create()
    {
        return view('loans.create');
    }

    /**
     * Menyimpan data peminjaman baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'peminjam'       => 'required|string|max:255',
            'buku'           => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
        ]);

        // Simpan ke database
        Loan::create([
            'peminjam'       => $validated['peminjam'],
            'buku'           => $validated['buku'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'status'         => 'Dipinjam', // default
        ]);

        return redirect()->route('loans.index')
                         ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu peminjaman (opsional).
     */
    public function show($id)
    {
        $loan = Loan::findOrFail($id);
        return view('loans.show', compact('loan'));
    }

    /**
     * Menampilkan form untuk mengedit peminjaman.
     */
    public function edit($id)
    {
        $loan = Loan::findOrFail($id);
        return view('loans.edit', compact('loan'));
    }

    /**
     * Memperbarui data peminjaman di database.
     */
    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        $validated = $request->validate([
            'peminjam'       => 'required|string|max:255',
            'buku'           => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'status'         => 'required|in:Dipinjam,Dikembalikan',
        ]);

        $loan->update($validated);

        return redirect()->route('loans.index')
                         ->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Menghapus data peminjaman dari database.
     */
    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete();

        return redirect()->route('loans.index')
                         ->with('success', 'Peminjaman berhasil dihapus.');
    }
}