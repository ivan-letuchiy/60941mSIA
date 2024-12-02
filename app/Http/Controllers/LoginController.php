<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Метод отображения страницы входа
    public function login(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('login');
    }

    // Метод для аутентификации пользователя
    public function authenticate(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Проверка роли пользователя
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.panel');
            }

            return redirect()->route('user.page');
        }

        return back()->withErrors([
            'email' => 'Неверные данные для входа.',
        ])->onlyInput('email');
    }

    // Метод выхода из системы
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
