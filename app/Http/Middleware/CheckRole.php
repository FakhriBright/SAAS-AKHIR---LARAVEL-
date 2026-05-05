<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Cek apakah level user ada di dalam daftar role yang diizinkan
        // Contoh: if ($next, 'admin', 'owner') -> user harus admin ATAU owner
        $user = Auth::user();

        if (in_array($user->level, $roles)) {
            return $next($request);
        }

        // 3. Jika tidak punya akses, redirect ke halaman sesuai role
        if ($user->level === 'kurir') {
            return redirect()->route('pengirimans.index')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
    }
}
