<?php

use App\Http\Controllers\AdminLoanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\book\BukuController;
use App\Http\Controllers\book\UserBukuController;
use App\Http\Controllers\ProfileController;  // ✅ TAMBAHKAN INI
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLoanController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // ============================================
    // DASHBOARD
    // ============================================
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

    // Auth::routes();

    // Route untuk Buku
    // Route::get('/books', [BookController::class, 'index'])->name('books.index');
    // Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    // Route::get('/books/edit', [BookController::class, 'edit'])->name('books.edit');
    // Tambahkan POST, PUT, DELETE untuk buku nanti

    // Route untuk peminjaman (lengkap)
    // Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    // Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    // Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    // Route::get('/loans/{id}', [LoanController::class, 'show'])->name('loans.show');
    // Route::get('/loans/{id}/edit', [LoanController::class, 'edit'])->name('loans.edit');
    // Route::put('/loans/{id}', [LoanController::class, 'update'])->name('loans.update');
    // Route::delete('/loans/{id}', [LoanController::class, 'destroy'])->name('loans.destroy');
    // Nanti tambahkan route untuk update & delete

    // Route::get('/history', [LoanController::class, 'index'])->name('history.index');
});



//book
Route::get('/buku', function () {
    return redirect()->route('buku.index');
});


require __DIR__ . '/auth.php';
// ============================================
// ROUTE PROFILE
// ============================================
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// ============================================
// ROUTE BUKU - PAKAI BookController
// ============================================
Route::prefix('books')->name('buku.')->group(function () {
    // SEARCH - Taruh paling atas
    Route::get('/search', [BukuController::class, 'search'])->name('search');

    // CRUD Buku
    Route::get('/', [BukuController::class, 'index'])->name('index');
    Route::get('/create', [BukuController::class, 'create'])->name('create');
    Route::post('/', [BukuController::class, 'store'])->name('store');
    Route::get('/{id}', [BukuController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [BukuController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BukuController::class, 'update'])->name('update');
    Route::delete('/{id}', [BukuController::class, 'destroy'])->name('destroy');
});

// ============================================
// ROUTE BUKU - PAKAI BukuController (ADMIN ONLY)
// ============================================
Route::middleware(['admin'])->group(function () {
    Route::resource('buku', BukuController::class);
});

// ============================================
// ROUTE PEMINJAMAN (ADMIN ONLY)
// ============================================
Route::middleware(['admin'])->group(function () {
    Route::resource('loans', LoanController::class);
});

// ============================================
// ROUTE RIWAYAT (SEMUA USER)
// ============================================
Route::get('/history', [LoanController::class, 'history'])->name('history.index');


// ==================== ROUTE USER ====================
Route::prefix('users')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/register', [UserController::class, 'create'])->name('create');
    Route::post('/register', [UserController::class, 'store'])->name('store');
    Route::get('/{id}', [UserController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
});

// // ==================== ROUTE LOANS ====================
// Route::prefix('loans')->name('loans.')->group(function () {
//     Route::get('/', [LoanController::class, 'index'])->name('index');
//     Route::get('/create', [LoanController::class, 'create'])->name('create');
//     Route::post('/', [LoanController::class, 'store'])->name('store');
//     Route::get('/{id}', [LoanController::class, 'show'])->name('show');
//     Route::get('/{id}/edit', [LoanController::class, 'edit'])->name('edit');
//     Route::put('/{id}', [LoanController::class, 'update'])->name('update');
//     Route::put('/{id}/return', [LoanController::class, 'returnBook'])->name('return');
//     Route::put('/{id}/status', [LoanController::class, 'updateStatus'])->name('update-status');
//     Route::delete('/{id}', [LoanController::class, 'destroy'])->name('destroy');
// });

// ==================== ROUTE USER LOANS ====================
// Route untuk Admin (Data Peminjaman)
Route::prefix('admin/loans')->name('admin.loans.')->middleware('auth')->group(function () {
    Route::get('/', [AdminLoanController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [AdminLoanController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdminLoanController::class, 'update'])->name('update');
    Route::put('/{id}/status', [AdminLoanController::class, 'updateStatus'])->name('update-status');
    Route::delete('/{id}', [AdminLoanController::class, 'destroy'])->name('destroy');
});

// ==================== ROUTE USER LOANS (HISTORY) ====================
Route::prefix('user/loans')->name('user.loans.')->middleware('auth')->group(function () {
    Route::get('/', [UserLoanController::class, 'index'])->name('index');
    Route::get('/create', [UserLoanController::class, 'create'])->name('create');
    Route::post('/', [UserLoanController::class, 'store'])->name('store');
    Route::get('/{id}', [UserLoanController::class, 'show'])->name('show');
    Route::put('/{id}/return', [UserLoanController::class, 'returnBook'])->name('return');
});

// ==========================================
// ROUTE USER BUKU (Untuk User Lihat Buku)
// ==========================================
Route::prefix('user/books')->name('user.buku.')->middleware('auth')->group(function () {
    Route::get('/', [UserBukuController::class, 'index'])->name('index');
    Route::get('/{id}', [UserBukuController::class, 'show'])->name('show');
});

// ============================================
// LOGOUT
// ============================================
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

require __DIR__ . '/auth.php';
