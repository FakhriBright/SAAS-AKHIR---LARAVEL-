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
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Cek untuk Admin/Owner/Kurir (guard 'web')
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if (in_array($user->level, $roles)) {
                return $next($request);
            }
        }

        // Cek untuk Customer (guard 'pelanggan')
        if (Auth::guard('pelanggan')->check()) {
            $pelanggan = Auth::guard('pelanggan')->user();
            // Izinkan customer akses route customer
            if (in_array('customer', $roles)) {
                return $next($request);
            }
        }

        // Jika tidak authorized
        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
