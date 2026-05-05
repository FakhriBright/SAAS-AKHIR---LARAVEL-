<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        // Owner cuma boleh akses dashboard
        if (Auth::user()->level === 'owner') {
            // Kalau owner coba akses selain dashboard, redirect
            if (!$request->routeIs('dashboard')) {
                return redirect()->route('dashboard')
                    ->with('error', 'Akses Owner terbatas hanya untuk Dashboard.');
            }
        }

        return $next($request);
    }
}
