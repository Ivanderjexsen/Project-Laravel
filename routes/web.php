<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================
// ROUTE VERIFIKASI EMAIL
// ============================================

// Halaman notifikasi verifikasi
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// ✅ Proses verifikasi (klik link di email) - REDIRECT KE LOGIN
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    // Verifikasi email
    $request->fulfill();
    
    // ✅ Ambil email user sebelum logout
    $email = auth()->user()->email;
    
    // ✅ Logout user setelah verifikasi
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    // ✅ Redirect ke LOGIN (BUKAN REGISTER)
    return redirect()->route('login')
        ->with('success', 'Email ' . $email . ' berhasil diverifikasi! Silahkan login.');
    
})->middleware(['auth', 'signed'])->name('verification.verify');

// Kirim ulang link verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi telah dikirim ulang!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ============================================
// ROUTE YANG MEMBUTUHKAN VERIFIKASI
// ============================================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware(['admin'])->group(function () {
        Route::resource('buku', BukuController::class);
        Route::resource('loans', LoanController::class);
    });

    Route::get('/history', [LoanController::class, 'history'])->name('history.index');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

require __DIR__ . '/auth.php';