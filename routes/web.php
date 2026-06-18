<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class,'index']);

Route::get('/books',[BookController::class,'index']);

Route::get('/loans',[LoanController::class,'index']);

Route::get('/history',[ProfileController::class,'history']);