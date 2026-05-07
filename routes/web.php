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
| PUBLIC ROUTES (Tanpa Auth)
|--------------------------------------------------------------------------
*/

// Home redirect
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN / OWNER / KURIR ROUTES (Guard: web)
| Middleware: auth:web + check.role
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'check.role:admin,owner,kurir'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ─────────────────────────────────────────────────────
    // PAKET (Admin Only)
    // ─────────────────────────────────────────────────────
    Route::middleware(['check.role:admin'])->group(function () {
        Route::get('/pakets', [PaketController::class, 'index'])->name('pakets.index');
        Route::get('/pakets/create', [PaketController::class, 'create'])->name('pakets.create');
        Route::post('/pakets', [PaketController::class, 'store'])->name('pakets.store');
        Route::get('/pakets/{paket}', [PaketController::class, 'show'])->name('pakets.show');
        Route::get('/pakets/{paket}/edit', [PaketController::class, 'edit'])->name('pakets.edit');
        Route::put('/pakets/{paket}', [PaketController::class, 'update'])->name('pakets.update');
        Route::delete('/pakets/{paket}', [PaketController::class, 'destroy'])->name('pakets.destroy');
    });

    // ─────────────────────────────────────────────────────
    // PELANGGAN (Admin Only)
    // ─────────────────────────────────────────────────────
    Route::middleware(['check.role:admin'])->group(function () {
        Route::get('/pelanggans', [PelangganController::class, 'index'])->name('pelanggans.index');
        Route::get('/pelanggans/create', [PelangganController::class, 'create'])->name('pelanggans.create');
        Route::post('/pelanggans', [PelangganController::class, 'store'])->name('pelanggans.store');
        Route::get('/pelanggans/{pelanggan}', [PelangganController::class, 'show'])->name('pelanggans.show');
        Route::get('/pelanggans/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('pelanggans.edit');
        Route::put('/pelanggans/{pelanggan}', [PelangganController::class, 'update'])->name('pelanggans.update');
        Route::delete('/pelanggans/{pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggans.destroy');
    });

    // ─────────────────────────────────────────────────────
    // PEMESANAN (Admin Only)
    // ─────────────────────────────────────────────────────
    Route::middleware(['check.role:admin'])->group(function () {
        Route::get('/pemesanans', [PemesananController::class, 'index'])->name('pemesanans.index');
        Route::get('/pemesanans/create', [PemesananController::class, 'create'])->name('pemesanans.create');
        Route::post('/pemesanans', [PemesananController::class, 'store'])->name('pemesanans.store');
        Route::get('/pemesanans/{pemesanan}', [PemesananController::class, 'show'])->name('pemesanans.show');
        Route::get('/pemesanans/{pemesanan}/edit', [PemesananController::class, 'edit'])->name('pemesanans.edit');
        Route::put('/pemesanans/{pemesanan}', [PemesananController::class, 'update'])->name('pemesanans.update');
        Route::delete('/pemesanans/{pemesanan}', [PemesananController::class, 'destroy'])->name('pemesanans.destroy');

        // PDF Invoice
        Route::get('/pemesanans/{pemesanan}/pdf', [PemesananController::class, 'downloadPDF'])->name('pemesanans.pdf');
    });

    // ─────────────────────────────────────────────────────
    // JENIS PEMBAYARAN (Admin Only)
    // ─────────────────────────────────────────────────────
    Route::middleware(['check.role:admin'])->group(function () {
        Route::get('/jenis-pembayaran', [JenisPembayaranController::class, 'index'])->name('jenis-pembayaran.index');
        Route::get('/jenis-pembayaran/create', [JenisPembayaranController::class, 'create'])->name('jenis-pembayaran.create');
        Route::post('/jenis-pembayaran', [JenisPembayaranController::class, 'store'])->name('jenis-pembayaran.store');
        Route::get('/jenis-pembayaran/{jenisPembayaran}', [JenisPembayaranController::class, 'show'])->name('jenis-pembayaran.show');
        Route::get('/jenis-pembayaran/{jenisPembayaran}/edit', [JenisPembayaranController::class, 'edit'])->name('jenis-pembayaran.edit');
        Route::put('/jenis-pembayaran/{jenisPembayaran}', [JenisPembayaranController::class, 'update'])->name('jenis-pembayaran.update');
        Route::delete('/jenis-pembayaran/{jenisPembayaran}', [JenisPembayaranController::class, 'destroy'])->name('jenis-pembayaran.destroy');
    });

    // ─────────────────────────────────────────────────────
    // DETAIL JENIS PEMBAYARAN (Admin Only)
    // ─────────────────────────────────────────────────────
    Route::middleware(['check.role:admin'])->group(function () {
        Route::get('/detail-jenis-pembayaran', [DetailJenisPembayaranController::class, 'index'])->name('detail-jenis-pembayaran.index');
        Route::get('/detail-jenis-pembayaran/create', [DetailJenisPembayaranController::class, 'create'])->name('detail-jenis-pembayaran.create');
        Route::post('/detail-jenis-pembayaran', [DetailJenisPembayaranController::class, 'store'])->name('detail-jenis-pembayaran.store');
        Route::get('/detail-jenis-pembayaran/{detailJenisPembayaran}', [DetailJenisPembayaranController::class, 'show'])->name('detail-jenis-pembayaran.show');
        Route::get('/detail-jenis-pembayaran/{detailJenisPembayaran}/edit', [DetailJenisPembayaranController::class, 'edit'])->name('detail-jenis-pembayaran.edit');
        Route::put('/detail-jenis-pembayaran/{detailJenisPembayaran}', [DetailJenisPembayaranController::class, 'update'])->name('detail-jenis-pembayaran.update');
        Route::delete('/detail-jenis-pembayaran/{detailJenisPembayaran}', [DetailJenisPembayaranController::class, 'destroy'])->name('detail-jenis-pembayaran.destroy');
    });

    // ─────────────────────────────────────────────────────
    // PENGIRIMAN (Admin & Kurir)
    // ─────────────────────────────────────────────────────
    Route::middleware(['check.role:admin,kurir'])->group(function () {
        Route::get('/pengirimans', [PengirimanController::class, 'index'])->name('pengirimans.index');
        Route::get('/pengirimans/create', [PengirimanController::class, 'create'])->name('pengirimans.create');
        Route::post('/pengirimans', [PengirimanController::class, 'store'])->name('pengirimans.store');
        Route::get('/pengirimans/{pengiriman}', [PengirimanController::class, 'show'])->name('pengirimans.show');
        Route::get('/pengirimans/{pengiriman}/edit', [PengirimanController::class, 'edit'])->name('pengirimans.edit');
        Route::put('/pengirimans/{pengiriman}', [PengirimanController::class, 'update'])->name('pengirimans.update');
        Route::delete('/pengirimans/{pengiriman}', [PengirimanController::class, 'destroy'])->name('pengirimans.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES (Guard: pelanggan)
| Prefix: /customer
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:pelanggan'])->prefix('customer')->name('customer.')->group(function () {

    // Dashboard Customer
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

    // Catalog (Public boleh lihat, tapi customer bisa order)
    Route::get('/catalog', [CustomerController::class, 'catalog'])->name('catalog');

    // Orders - Riwayat Pesanan
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');

    // Order - Buat Pesanan Baru
    Route::get('/order/create', [CustomerController::class, 'createOrder'])->name('order.create');
    Route::post('/order/store', [CustomerController::class, 'storeOrder'])->name('order.store');

    // Order - Detail Pesanan
    Route::get('/order/{id}', [CustomerController::class, 'orderDetail'])->name('order.detail');

    // Profile Customer
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [CustomerController::class, 'updateProfile'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| FALLBACK ROUTE (404)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
