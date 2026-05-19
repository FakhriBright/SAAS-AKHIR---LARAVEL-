<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers - Auth & Public
use App\Http\Controllers\AuthController;

// Controllers - Admin Panel
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\DetailJenisPembayaranController;
use App\Http\Controllers\ReportController;

// Controllers - Customer
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| PUBLIC & AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('landing'))->name('home');
Route::get('/tentang-kami', fn() => redirect()->route('home'))->name('about');
Route::get('/menu', fn() => redirect()->route('customer.catalog'))->name('menu');
Route::get('/galeri', fn() => redirect()->route('home'))->name('gallery');
Route::get('/testimoni', fn() => redirect()->route('home'))->name('testimoni');

Route::get('/', fn() => view('landing'))->name('home');

// ✅ LOGIN PELANGGAN (CUSTOMER)
Route::get('/login', [AuthController::class, 'showCustomerLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginCustomer'])->name('login.process');

// ✅ SATU ROUTE LOGIN UNTUK SEMUA (Pelanggan & Admin/Owner/Kurir)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (FULL ACCESS) - ✅ TANPA PREFIX, PAKAI MIDDLEWARE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'check.role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('pakets', PaketController::class);
    Route::resource('pelanggans', PelangganController::class);
    Route::resource('pemesanans', PemesananController::class);
    Route::get('/pemesanans/{pemesanan}/pdf', [PemesananController::class, 'downloadPDF'])->name('pemesanans.pdf');

    Route::resource('pengirimans', PengirimanController::class);

    Route::resource('jenis-pembayaran', JenisPembayaranController::class);
    Route::resource('detail-jenis-pembayaran', DetailJenisPembayaranController::class);

    Route::get('/download-report', [ReportController::class, 'downloadMonthlyReport'])->name('report.download');
});

/*
|--------------------------------------------------------------------------
| OWNER ROUTES (DASHBOARD ONLY)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'check.role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/download-report', [ReportController::class, 'downloadMonthlyReport'])->name('report.download'); // ✅ TAMBAH INI
});

/*
|--------------------------------------------------------------------------
| KURIR ROUTES (PENGIRIMAN & KONFIRMASI FOTO)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'check.role:kurir'])->prefix('kurir')->name('kurir.')->group(function () {
    Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengirimans.index');
    Route::get('/pengiriman/{pengiriman}', [PengirimanController::class, 'show'])->name('pengirimans.show');
    Route::get('/pengiriman/{pengiriman}/konfirmasi', [PengirimanController::class, 'editKurir'])->name('pengirimans.edit');
    Route::put('/pengiriman/{pengiriman}', [PengirimanController::class, 'update'])->name('pengirimans.update');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:pelanggan'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/catalog', [CustomerController::class, 'catalog'])->name('catalog');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{paketId}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
    Route::post('/order', [CustomerController::class, 'storeOrder'])->name('order.store');

    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/order/{order}', [CustomerController::class, 'showOrder'])->name('order.show');
    Route::patch('/order/{order}/cancel', [CustomerController::class, 'cancelOrder'])->name('order.cancel');

    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
Route::fallback(fn() => redirect()->route('home')->with('error', 'Halaman tidak ditemukan.'));
