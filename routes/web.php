<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShoeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // DASHBOARD (Beranda dengan statistik)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // DATA SEPATU (Tabel CRUD lengkap)
    Route::get('/shoes', [ShoeController::class, 'index'])->name('shoes.index');
    Route::get('/shoes/create', [ShoeController::class, 'create'])->name('shoes.create');
    Route::post('/shoes', [ShoeController::class, 'store'])->name('shoes.store');
    Route::get('/shoes/{shoe}/edit', [ShoeController::class, 'edit'])->name('shoes.edit');
    Route::put('/shoes/{shoe}', [ShoeController::class, 'update'])->name('shoes.update');
    Route::delete('/shoes/{shoe}', [ShoeController::class, 'destroy'])->name('shoes.destroy');
    
    Route::get('/export-excel', [ShoeController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export-pdf', [ShoeController::class, 'exportPDF'])->name('export.pdf');

    // BRANDS
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

    // CUSTOMERS
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // TRANSACTIONS
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});