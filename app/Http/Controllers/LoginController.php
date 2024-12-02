<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Метод отображения страницы входа
    public function login(): \Illuminate\Contracts\View\View
    {
        return view('login');
    }

    // Метод для аутентификации пользователя
    public function authenticate(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            return redirect()->route($user->role === 'admin' ? 'admin.panel' : 'user.page')
                ->with('success', 'Вы успешно вошли!');
        }

        return back()->withErrors(['email' => 'Неверные данные для входа.'])->onlyInput('email');
    }

    // Метод выхода из системы
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Вы успешно вышли из системы.');
    }
}
