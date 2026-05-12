<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class CustomerViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // ✅ Otomatis inject $pelanggan ke SEMUA view di folder customer/*
        View::composer('customer.*', function ($view) {
            // Ambil user yang login via guard 'pelanggan'
            $pelanggan = Auth::guard('pelanggan')->user();

            // Kirim variabel $pelanggan ke view
            $view->with('pelanggan', $pelanggan);
        });
    }
}
