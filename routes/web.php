<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers - Public & Auth
use App\Http\Controllers\AuthController;

// Controllers - Admin
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
| PUBLIC ROUTES (Tanpa Auth)
|--------------------------------------------------------------------------
*/

// 🏠 Landing Page
Route::get('/', function () {
    return view('landing');
})->name('home');

// 📄 Static Pages (Anchor links to landing page sections)
Route::get('/tentang-kami', function () {
    return redirect()->route('home');
})->name('about');

Route::get('/menu', function () {
    return redirect()->route('customer.catalog');
})->name('menu');

Route::get('/galeri', function () {
    return redirect()->route('home');
})->name('gallery');

Route::get('/testimoni', function () {
    return redirect()->route('home');
})->name('testimoni');

// 🔑 Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🎯 Home Redirect (Stay on landing page)
Route::get('/home', function () {
    return view('landing');
})->name('home.redirect');

/*
|--------------------------------------------------------------------------
| ADMIN / OWNER / KURIR ROUTES
| Middleware: auth:web + check.role
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'check.role:admin,owner,kurir'])->group(function () {

    // 📊 Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 📦 Paket Management (Admin Only)
    Route::middleware(['check.role:admin'])->group(function () {
        Route::resource('pakets', PaketController::class);
        Route::resource('pelanggans', PelangganController::class);
        Route::resource('pemesanans', PemesananController::class);
        Route::get('/pemesanans/{pemesanan}/pdf', [PemesananController::class, 'downloadPDF'])->name('pemesanans.pdf');
        Route::resource('jenis-pembayaran', JenisPembayaranController::class);
        Route::resource('detail-jenis-pembayaran', DetailJenisPembayaranController::class);
    });

    // 🚚 Pengiriman (Admin & Kurir)
    Route::middleware(['check.role:admin,kurir'])->group(function () {
        Route::resource('pengirimans', PengirimanController::class);
    });

    // 📄 REPORTS (Admin Only)
    Route::middleware(['check.role:admin'])->group(function () {
        Route::get('/download-report', [ReportController::class, 'downloadMonthlyReport'])->name('report.download');
        Route::get('/preview-report', [ReportController::class, 'previewMonthlyReport'])->name('report.preview');
    });
});

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES (Guard: pelanggan)
| Prefix: /customer
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:pelanggan'])->prefix('customer')->name('customer.')->group(function () {

    // ✅ DASHBOARD PELANGGAN
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

    // 📦 Catalog & Orders
    Route::get('/catalog', [CustomerController::class, 'catalog'])->name('catalog');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/order/{order}', [CustomerController::class, 'showOrder'])->name('order.show');
    Route::patch('/order/{order}/cancel', [CustomerController::class, 'cancelOrder'])->name('order.cancel');

    // 🛒 Shopping Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{paketId}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // 💳 Checkout & Order Processing
    Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
    Route::post('/order', [CustomerController::class, 'storeOrder'])->name('order.store');

    // 👤 Profile Management
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| FALLBACK ROUTE (404)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return redirect()->route('home')->with('error', 'Halaman tidak ditemukan.');
});