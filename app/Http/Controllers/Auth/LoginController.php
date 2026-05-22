<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Coba login sebagai pelanggan
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'nama_pelanggan' => 'required|string|max:100',
        'email' => 'required|email|unique:pelanggans,email',
        'telepon' => 'required|string|max:15',
        'password' => 'required|min:8|confirmed',
        'role' => 'required|in:customer,vendor', // VALIDASI BARU
    ]);

    Pelanggan::create([
        'nama_pelanggan' => $validated['nama_pelanggan'],
        'email' => $validated['email'],
        'telepon' => $validated['telepon'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role'], // SIMPAN ROLE KE DATABASE
    ]);

    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
