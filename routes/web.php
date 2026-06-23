<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\book\BukuController;
use App\Http\Controllers\LoanController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk Buku
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::get('/books/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    // Tambahkan POST, PUT, DELETE untuk buku nanti

    // Route untuk peminjaman (lengkap)
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/{id}', [LoanController::class, 'show'])->name('loans.show');
    Route::get('/loans/{id}/edit', [LoanController::class, 'edit'])->name('loans.edit');
    Route::put('/loans/{id}', [LoanController::class, 'update'])->name('loans.update');
    Route::delete('/loans/{id}', [LoanController::class, 'destroy'])->name('loans.destroy');
    // Nanti tambahkan route untuk update & delete

    Route::get('/history', [LoanController::class, 'index'])->name('history.index');
});



//book
Route::get('/buku', function () {
    return redirect()->route('buku.index');
});

// Route resource untuk CRUD Buku
Route::resource('buku', BukuController::class);

require __DIR__ . '/auth.php';
