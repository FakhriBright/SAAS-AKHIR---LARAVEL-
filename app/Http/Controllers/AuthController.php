<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pelanggan;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Process login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek login sebagai Admin (guard: web)
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect ke admin dashboard
            return redirect()->intended('/dashboard');
        }

        // Cek login sebagai Pelanggan (guard: pelanggan)
        if (Auth::guard('pelanggan')->attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect ke customer dashboard
            return redirect()->intended('/customer/dashboard');
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Process register (as Pelanggan)
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email',
            'telepon' => 'required|string',
            'alamat1' => 'required|string',
            'password' => 'required|min:6|confirmed'
        ]);

        // Buat akun pelanggan baru
        Pelanggan::create([
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'],
            'alamat1' => $validated['alamat1'],
            'alamat2' => $validated['alamat2'] ?? null,
            'alamat3' => $validated['alamat3'] ?? null,
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        // Logout dari semua guard
        Auth::guard('web')->logout();
        Auth::guard('pelanggan')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}