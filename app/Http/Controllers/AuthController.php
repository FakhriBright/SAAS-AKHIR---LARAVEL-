<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        // Jika sudah login sebagai pelanggan, redirect ke dashboard customer
        if (Auth::guard('pelanggan')->check()) {
            return redirect()->route('customer.dashboard');
        }
        // Jika sudah login sebagai admin/owner/kurir, redirect ke dashboard
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Process login - ✅ HANDLE DUA GUARD
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        // 🔹 CEK DI GUARD 'web' (Admin/Owner/Kurir)
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::guard('web')->user();

            if ($user->level === 'admin' || $user->level === 'owner') {
                return redirect()->intended('/dashboard');
            } elseif ($user->level === 'kurir') {
                return redirect()->intended('/pengirimans');
            }
            return redirect()->intended('/dashboard');
        }

        // 🔹 CEK DI GUARD 'pelanggan' (Customer)
        if (Auth::guard('pelanggan')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/customer/dashboard');
        }

        // ❌ Jika semua gagal
        throw ValidationException::withMessages([
            'email' => ['Email atau password yang Anda masukkan salah.'],
        ]);
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Process register (untuk pelanggan/customer)
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|string|email|unique:pelanggans,email',
            'password' => 'required|string|min:8|confirmed',
            'telepon' => 'required|string|max:15',
            'alamat1' => 'required|string',
        ], [
            'nama_pelanggan.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'telepon.required' => 'Nomor telepon harus diisi',
            'alamat1.required' => 'Alamat harus diisi',
        ]);

        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'telepon' => $validated['telepon'],
            'alamat1' => $validated['alamat1'],
            'alamat2' => $request->alamat2,
            'alamat3' => $request->alamat3,
        ]);

        // Auto login setelah register
        Auth::guard('pelanggan')->login($pelanggan);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    /**
     * Logout - ✅ LOGOUT DARI SEMUA GUARD
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('pelanggan')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
