<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;  // ✅ TAMBAHKAN INI

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // ============================================
    // DASHBOARD
    // ============================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ============================================
    // ROUTE PROFILE
    // ============================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // ============================================
    // ROUTE BUKU - PAKAI BookController
    // ============================================
    Route::prefix('books')->name('books.')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('index');
        Route::get('/create', [BookController::class, 'create'])->name('create');
        Route::post('/', [BookController::class, 'store'])->name('store');
        Route::get('/{id}', [BookController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BookController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BookController::class, 'update'])->name('update');
        Route::delete('/{id}', [BookController::class, 'destroy'])->name('destroy');
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

    // ============================================
    // LOGOUT
    // ============================================
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

require __DIR__ . '/auth.php';