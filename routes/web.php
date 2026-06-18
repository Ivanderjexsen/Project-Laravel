<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard',
        [DashboardController::class,'index'])
        ->name('dashboard');

    Route::get('/books',
        [BookController::class,'index']);

    Route::get('/books/create',
        [BookController::class,'create']);

    Route::get('/books/edit',
        [BookController::class,'edit']);

    Route::get('/loans',
        [LoanController::class,'index']);

    Route::get('/loans/create',
        [LoanController::class,'create']);

    Route::get('/loans/edit',
        [LoanController::class,'edit']);


});

require __DIR__.'/auth.php';