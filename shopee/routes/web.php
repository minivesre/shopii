<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PembelianController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\UserAccess;

// Halaman utama (redirect ke login)
Route::get('/', function () {
    return redirect('/login');
});

// Autentikasi Laravel
Auth::routes();

// Middleware untuk user biasa
Route::middleware(['auth', UserAccess::class . ':user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// Middleware untuk admin
Route::middleware(['auth', UserAccess::class . ':admin'])->group(function () {
    Route::get('/admin/home', [ProdukController::class, 'index'])->name('adminHome');

    // Rute CRUD Produk
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});

// Middleware untuk manager
Route::middleware(['auth', 'user-access:manager'])->group(function () {
    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
});

// Logout
Route::post('/logout', [LogoutController::class, 'signout'])->name('logout');

// ✅ Middleware auth untuk transaksi
Route::middleware(['auth'])->group(function () {
    // Proses beli tiket
    Route::post('/beli', [PembelianController::class, 'beli'])->name('transaksi.beli');

    // Proses bayar tiket
    Route::post('/bayar', [PembelianController::class, 'bayar'])->name('transaksi.bayar');

    // Menampilkan halaman cart
    Route::get('/cart', [PembelianController::class, 'transaksiCart'])->name('transaksi.cart');

    // Hapus item dari cart
    Route::post('/transaksi/{id}/clearcart', [PembelianController::class, 'clearcart'])->name('transaksi.clearcart');

    // Halaman transaksi (khusus user login)
    Route::get('/transaksi2', [PembelianController::class, 'transaksiIndex'])->name('transaksi.transaksi');
});

// Update transaksi-related routes to handle GET and POST requests
Route::prefix('transaksi')->group(function () {
    // Allow both GET and POST for /transaksi
    Route::match(['get', 'post'], '/', [PembelianController::class, 'index'])->name('transaksi.transaksi');
    
    Route::post('{id}/clearcart', [PembelianController::class, 'clearcart'])->name('transaksi.clearcart');
    Route::post('{id}/clear', [PembelianController::class, 'clear'])->name('transaksi.clear');
    Route::post('{id}/hapus', [PembelianController::class, 'hapus'])->name('transaksi.hapus');
    Route::post('{id}/konfirmasi', [PembelianController::class, 'konfirmasiStatus'])->name('transaksi.konfirmasi');
    Route::get('{id}/cetak', [PembelianController::class, 'generatePdf'])->name('transaksi.cetak');

    // Daftar transaksi untuk user biasa & manager/admin
    Route::post('/', [PembelianController::class, 'index'])->name('transaksi.transaksi');

    // Daftar transaksi untuk manager/admin
    Route::get('transaksiManager', [PembelianController::class, 'transaksiIndexManager'])->name('transaksi.transaksiManager');
});

// Alternatif route jika dibutuhkan
Route::get('/transaksi2', [PembelianController::class, 'transaksiIndex']);
