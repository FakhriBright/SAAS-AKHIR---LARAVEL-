<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Pelanggan;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        Log::info('=== LOGIN ATTEMPT ===', ['email' => $request->email]);

        // 1. Coba login sebagai User (Admin/Owner/Kurir) via guard 'web'
        if (Auth::guard('web')->attempt($credentials)) {
            Log::info('Guard WEB login success', ['user_id' => Auth::guard('web')->id()]);
            
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();
            
            Log::info('User role detected: ' . $user->role);

            // ✅ REDIRECT BASED ON ROLE (SESUAI ROUTE NAMES TERBARU)
            if ($user->role === 'admin') {
                // ✅ Admin → route 'dashboard' (tanpa prefix)
                return redirect()->route('dashboard');
            } elseif ($user->role === 'owner') {
                // ✅ Owner → route 'owner.dashboard' (punya prefix sendiri)
                return redirect()->route('owner.dashboard');
            } elseif ($user->role === 'kurir') {
                // ✅ Kurir → route 'kurir.pengirimans.index' (punya prefix sendiri)
                return redirect()->route('kurir.pengirimans.index');
            }

            // Fallback kalau role aneh
            Log::error('Unknown role: ' . ($user->role ?? 'NULL'));
            Auth::guard('web')->logout();
            return back()->withErrors(['email' => 'Role user tidak valid: ' . ($user->role ?? 'NULL')]);
        }

        // 2. Coba login sebagai Pelanggan via guard 'pelanggan'
        if (Auth::guard('pelanggan')->attempt($credentials)) {
            Log::info('Guard PELANGGAN login success', ['id' => Auth::guard('pelanggan')->id()]);
            
            $request->session()->regenerate();
            return redirect()->route('customer.dashboard');
        }

        // 3. Login GAGAL
        Log::warning('Login FAILED for email: ' . $request->email);
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

 public function register(Request $request)
{
    // ✅ VALIDASI SESUAI NAMA FIELD DI FORM
    $validated = $request->validate([
        'nama_pelanggan' => 'required|string|max:255',  // ✅ Pakai nama_pelanggan
        'email' => 'required|string|email|max:255|unique:pelanggans,email',
        'telepon' => 'required|string',
        'alamat1' => 'required|string',
        'alamat2' => 'nullable|string',
        'alamat3' => 'nullable|string',
        'password' => 'required|string|min:8|confirmed',
        // ✅ JANGAN VALIDASI 'role' untuk registrasi pelanggan
    ]);
    
    try {
        // ✅ BUAT PELANGGAN BARU DENGAN ROLE OTOMATIS
        $pelanggan = \App\Models\Pelanggan::create([
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'],
            'alamat1' => $validated['alamat1'],
            'alamat2' => $validated['alamat2'] ?? null,
            'alamat3' => $validated['alamat3'] ?? null,
            'password' => Hash::make($validated['password']),
            // Role pelanggan biasanya otomatis atau ada di tabel users terpisah
        ]);
        
        return redirect()->route('login')
            ->with('success', '✅ Registrasi berhasil! Silakan login dengan akun Anda.');
            
    } catch (\Exception $e) {
        return back()->withInput()
            ->with('error', '❌ Gagal registrasi: ' . $e->getMessage());
    }
}
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