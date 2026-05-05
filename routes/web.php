<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\DetailJenisPembayaranController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
// Homepage redirect ke customer login
Route::get('/', function () {
    return redirect()->route('customer.login');
});

// Katalog Paket (Public - Tanpa Login)
Route::get('/katalog', [CustomerController::class, 'catalog'])->name('customer.catalog');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/customer/login', function() {
    return view('auth.customer-login');
})->name('customer.login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES (Login Required - Level: customer)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'check.role:customer'])->group(function () {
    // Dashboard Customer
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

    // Order Routes
    Route::get('/customer/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/customer/order/{id}', [CustomerController::class, 'orderDetail'])->name('customer.order.detail');

    // Create Order
    Route::get('/customer/order/create', [CustomerController::class, 'createOrder'])->name('customer.order.create');
    Route::post('/customer/order/store', [CustomerController::class, 'storeOrder'])->name('customer.order.store');
});

/*
|--------------------------------------------------------------------------
| INTERNAL ROUTES (Admin/Owner/Kurir)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout (Semua role)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ✅ OWNER ONLY: Cuma Dashboard (Read-Only)
    Route::middleware('owner.only')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // ✅ ADMIN ONLY: Full CRUD Access
    Route::middleware('check.role:admin')->group(function () {
        Route::resource('pakets', PaketController::class);
        Route::resource('pelanggans', PelangganController::class);

        // PDF Invoice Route (WAJIB sebelum resource)
        Route::get('/pemesanans/{pemesanan}/pdf', [PemesananController::class, 'downloadPDF'])->name('pemesanans.pdf');
        Route::resource('pemesanans', PemesananController::class);

        Route::resource('jenis-pembayaran', JenisPembayaranController::class);
        Route::resource('detail-jenis-pembayaran', DetailJenisPembayaranController::class);
    });

    // ✅ PENGIRIMAN: Admin & Kurir
    Route::middleware('check.role:admin,kurir')->group(function () {
        Route::resource('pengirimans', PengirimanController::class);
    });
});
