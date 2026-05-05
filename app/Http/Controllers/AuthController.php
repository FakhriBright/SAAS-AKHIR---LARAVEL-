<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // ✅ REGENERATE SESSION - PENTING untuk keamanan!
            $request->session()->regenerate();

            // ✅ CLEAR SESSION LAMA untuk mencegah konflik
            $request->session()->put('login_id', Auth::id());
            $request->session()->put('login_level', Auth::user()->level);

            $user = Auth::user();

            // Redirect berdasarkan Role
            if ($user->level === 'admin') {
                return redirect()->intended('/dashboard');
            } elseif ($user->level === 'owner') {
                return redirect()->intended('/dashboard');
            } elseif ($user->level === 'kurir') {
                return redirect()->intended('/pengirimans');
            } elseif ($user->level === 'customer') {
                return redirect()->intended('/customer/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Tampilkan Form Register (PUBLIC - untuk Pelanggan)
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Register (PUBLIC - Auto jadi Pelanggan)
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email|unique:pelanggans,email',
            'password' => 'required|string|min:6|confirmed',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat User Account (level = customer)
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'level' => 'customer',
            ]);

            // 2. Auto Create Data Pelanggan
            Pelanggan::create([
                'nama_pelanggan' => $validated['name'],
                'email' => $validated['email'],
                'telepon' => $validated['telepon'],
                'alamat1' => $validated['alamat'],
                'password' => Hash::make($validated['password']),
            ]);

            DB::commit();

            // Auto login setelah register
            Auth::login($user);

            // Regenerate session
            $request->session()->regenerate();

            return redirect()->route('customer.dashboard')
                ->with('success', 'Registrasi berhasil! Selamat datang.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        // ✅ Invalidate semua session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('login_id');
        $request->session()->forget('login_level');

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
