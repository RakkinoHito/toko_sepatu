<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShoeController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [ShoeController::class, 'index'])->name('dashboard');
    Route::resource('shoes', ShoeController::class);
    Route::get('/export-excel', [ShoeController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export-pdf', [ShoeController::class, 'exportPDF'])->name('export.pdf');
});