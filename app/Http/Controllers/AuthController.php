<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'login' => 'required|string|unique:users,login|min:3|max:50',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
        ]);

        session(['user_id' => $user->id, 'user_login' => $user->login]);
        return redirect()->route('profile.index')->with('success', 'Регистрация прошла успешно!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('login', $credentials['login'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            session(['user_id' => $user->id, 'user_login' => $user->login]);
            return redirect()->route('news.index')->with('success', 'Вы успешно вошли в систему!');
        }

        return back()->withErrors([
            'login' => 'Неверный логин или пароль.',
        ]);
    }

    public function logout()
    {
        session()->forget(['user_id', 'user_login']);
        return redirect()->route('news.index')->with('success', 'Вы вышли из системы.');
    }
}
