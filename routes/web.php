<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\DetailJenisPembayaranController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Tanpa Auth - Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/

// 🏠 LANDING PAGE (Halaman Utama Marketing)
Route::get('/', function () {
    return view('landing');
})->name('home');

// 🔑 AUTH ROUTES
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🎯 HOME REDIRECT (Untuk yang sudah login)
Route::get('/home', function () {
    if (Auth::guard('web')->check()) {
        return redirect()->route('dashboard');
    } elseif (Auth::guard('pelanggan')->check()) {
        return redirect()->route('customer.orders'); // Redirect ke Pemesanan, bukan dashboard
    }
    return redirect()->route('home');
})->name('home.redirect');

/*
|--------------------------------------------------------------------------
| ADMIN / OWNER / KURIR ROUTES (Guard: web)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'check.role:admin,owner,kurir'])->group(function () {

    // 📊 Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🔒 ADMIN ONLY ROUTES
    Route::middleware(['check.role:admin'])->group(function () {
        // Paket Management
        Route::resource('pakets', PaketController::class);

        // Pelanggan Management
        Route::resource('pelanggans', PelangganController::class);

        // Pemesanan Management
        Route::resource('pemesanans', PemesananController::class);
        Route::get('/pemesanans/{pemesanan}/pdf', [PemesananController::class, 'downloadPDF'])->name('pemesanans.pdf');

        // Pembayaran Management
        Route::resource('jenis-pembayaran', JenisPembayaranController::class);
        Route::resource('detail-jenis-pembayaran', DetailJenisPembayaranController::class);
    });

    // 🚚 PENGIRIMAN (Admin & Kurir)
    Route::middleware(['check.role:admin,kurir'])->group(function () {
        Route::resource('pengirimans', PengirimanController::class);
    });
});

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES (Guard: pelanggan)
| Prefix: /customer
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:pelanggan'])->prefix('customer')->name('customer.')->group(function () {

    // 📊 Customer Dashboard
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

    // 📖 Katalog Paket
    Route::get('/catalog', [CustomerController::class, 'catalog'])->name('catalog');

    // 🛒 Pemesanan - Riwayat & Buat Pesanan (Gabung)
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');

    // 📝 Buat Pesanan Baru
    Route::get('/order/create', [CustomerController::class, 'createOrder'])->name('order.create');
    Route::post('/order', [CustomerController::class, 'storeOrder'])->name('order.store'); // ✅ FIX: POST /order (bukan /order/store)

    // 🔍 Detail Pesanan
    Route::get('/order/{order}', [CustomerController::class, 'showOrder'])->name('order.show'); // ✅ FIX: {order} model binding

    // ❌ Batalkan Pesanan
    Route::patch('/order/{order}/cancel', [CustomerController::class, 'cancelOrder'])->name('order.cancel'); // ✅ FIX: PATCH method

    // 👤 Profile Management
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update'); // ✅ FIX: PUT /profile (bukan /profile/update)
});

/*
|--------------------------------------------------------------------------
| FALLBACK ROUTE (404)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return view('errors.404');
});
