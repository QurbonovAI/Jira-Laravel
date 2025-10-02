<?php

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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Muvaffaqiyatli kirish!');
        }

        return back()->withErrors([
            'email' => 'Noto\'g\'ri email yoki parol',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Faqat adminlar yangi foydalanuvchi ro\'yxatdan o\'tkazishi mumkin');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return back()->withErrors(['error' => 'Faqat adminlar yangi foydalanuvchi ro\'yxatdan o\'tkazishi mumkin']);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'is_admin' => 'boolean',
        ]);

        try {
            User::create([
                'name' => $validated['full_name'],
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_admin' => $validated['is_admin'] ?? false,
                'is_active' => true,
            ]);

            return redirect()->route('dashboard')->with('success', 'Foydalanuvchi muvaffaqiyatli ro\'yxatdan o\'tdi!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Ro\'yxatdan o\'tishda xato: ' . $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Tizimdan muvaffaqiyatli chiqildi!');
    }
}
