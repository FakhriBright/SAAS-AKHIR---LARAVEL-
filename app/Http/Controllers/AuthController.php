<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pelanggan;

class AuthController extends Controller
{
    /**
     * Show Login Form (Dynamic based on ?role parameter)
     */
    public function showLogin(Request $request)
    {
        // Deteksi role dari URL parameter: /login?role=admin
        $role = $request->query('role', 'pelanggan'); // default: pelanggan

        return view('auth.login', compact('role'));
    }

    /**
     * Process Login (Auto-detect guard based on role)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:pelanggan,admin,owner,kurir',
        ]);

        $role = $credentials['role'];

        // ✅ LOGIN BERDASARKAN ROLE
        if ($role === 'pelanggan') {
            // Login pelanggan
            if (Auth::guard('pelanggan')->attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ])) {
                $request->session()->regenerate();
                return redirect()->intended(route('customer.dashboard'));
            }
        } else {
            // Login Admin/Owner/Kurir
            if (Auth::guard('web')->attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ])) {
                $request->session()->regenerate();
                $user = Auth::guard('web')->user();

                // Validasi role cocok
                if ($user->role === $role) {
                    // Redirect sesuai role
                    if ($role === 'admin') {
                        return redirect()->route('dashboard');
                    } elseif ($role === 'owner') {
                        return redirect()->route('owner.dashboard');
                    } elseif ($role === 'kurir') {
                        return redirect()->route('kurir.pengirimans.index');
                    }
                }

                Auth::guard('web')->logout();
                return back()->withErrors(['email' => 'Role tidak sesuai dengan akun Anda.']);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Show Register (Pelanggan only)
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggans,email',
            'telepon' => 'required|string',
            'alamat1' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            \App\Models\Pelanggan::create([
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'email' => $validated['email'],
                'telepon' => $validated['telepon'],
                'alamat1' => $validated['alamat1'],
                'alamat2' => $validated['alamat2'] ?? null,
                'alamat3' => $validated['alamat3'] ?? null,
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()->route('login')
                ->with('success', '✅ Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', '❌ Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        if (Auth::guard('pelanggan')->check()) {
            Auth::guard('pelanggan')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
