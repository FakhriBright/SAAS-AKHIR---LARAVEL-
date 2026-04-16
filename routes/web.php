<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\DetailPemesananController;
use App\Http\Controllers\PengirimanController;

Route::get('/', [DashboardController::class, 'index']);

Route::resource('pakets', PaketController::class);
Route::resource('pelanggans', PelangganController::class);
Route::resource('pemesanans', PemesananController::class);
Route::resource('detail-pemesanans', DetailPemesananController::class);
Route::resource('pengirimans', PengirimanController::class);
