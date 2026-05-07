<?php

use Illuminate\Support\Facades\Route;
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
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN / OWNER / KURIR ROUTES (Guard: web)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'check.role:admin,owner,kurir'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Paket (Admin Only)
    Route::middleware(['check.role:admin'])->group(function () {
        Route::resource('pakets', PaketController::class);
        Route::resource('pelanggans', PelangganController::class);
        Route::resource('pemesanans', PemesananController::class);
        Route::resource('jenis-pembayaran', JenisPembayaranController::class);
        Route::resource('detail-jenis-pembayaran', DetailJenisPembayaranController::class);

        // PDF Invoice
        Route::get('/pemesanans/{pemesanan}/pdf', [PemesananController::class, 'downloadPDF'])->name('pemesanans.pdf');
    });

    // Pengiriman (Admin & Kurir)
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

    // Dashboard
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

    // Catalog
    Route::get('/catalog', [CustomerController::class, 'catalog'])->name('catalog');

    // Orders - Riwayat Pesanan
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');

    // Order - Buat Pesanan Baru
    Route::get('/order/create', [CustomerController::class, 'createOrder'])->name('order.create');
    Route::post('/order/store', [CustomerController::class, 'storeOrder'])->name('order.store');

    // Order - Detail Pesanan
    Route::get('/order/{id}', [CustomerController::class, 'orderDetail'])->name('order.detail');

    // 🔥 Order - Batalkan Pesanan (NEW)
    Route::delete('/order/{id}/cancel', [CustomerController::class, 'cancelOrder'])->name('order.cancel');

    // Profile
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [CustomerController::class, 'updateProfile'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| FALLBACK ROUTE
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
