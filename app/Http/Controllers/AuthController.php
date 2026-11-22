<?php

// ==========================================================
// NIM  : 252410102008
// NAMA : Caesya
// MISI : Episode 2 - Security Hardening (Auth, CSRF, XSS)
// ==========================================================

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->intended(route('projects.index'))
                ->with('success', 'Berhasil masuk ke Garuda-Hub!');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'role'     => ['required', 'in:client,freelancer'],
        ]);

        $user = User::create([
            'name'     => strip_tags($validated['name']),
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']), // Password Hashing kuat
            'role'     => $validated['role'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('projects.index')
            ->with('success', 'Akun berhasil dibuat!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar (Logout).');
    }
}