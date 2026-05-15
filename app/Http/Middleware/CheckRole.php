<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        Log::info('CheckRole middleware', [
            'url' => $request->url(),
            'roles_required' => $roles,
            'authenticated' => Auth::guard('web')->check(),
        ]);

        if (!Auth::guard('web')->check()) {
            Log::warning('User not authenticated, redirecting to login');
            return redirect()->route('login');
        }

        $user = Auth::guard('web')->user();
        $userRole = $user->role ?? '';
        
        Log::info('User role check', [
            'user_id' => $user->id,
            'user_role' => $userRole,
            'required_roles' => $roles,
        ]);

        // Flatten roles array
        $allowedRoles = collect($roles)->flatten()->map(fn($r) => trim($r))->filter()->toArray();

        if (in_array($userRole, $allowedRoles)) {
            Log::info('Role check passed');
            return $next($request);
        }

        // Role not allowed - redirect to appropriate dashboard
        Log::warning('Access denied for role: ' . $userRole);
        
        switch($userRole) {
            case 'admin':
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            case 'owner':
                return redirect()->route('owner.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            case 'kurir':
                return redirect()->route('kurir.pengirimans.index')
                    ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            default:
                return redirect()->route('login')
                    ->with('error', 'Role tidak dikenali.');
        }
    }
}