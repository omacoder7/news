<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\News;

class ProfileController extends Controller
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->route('auth.login.form');
        }
        
        return view('profile.index');
    }

    public function showChangePassword()
    {
        if (!session('user_id')) {
            return redirect()->route('auth.login.form');
        }
        
        return view('profile.change-password');
    }

    public function changePassword(Request $request)
    {
        if (!session('user_id')) {
            return redirect()->route('auth.login.form');
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::find(session('user_id'));
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')->with('success', 'Пароль успешно изменен!');
    }

    public function showAddNews()
    {
        if (!session('user_id')) {
            return redirect()->route('auth.login.form');
        }
        
        return view('profile.add-news');
    }

    public function addNews(Request $request)
    {
        if (!session('user_id')) {
            return redirect()->route('auth.login.form');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'author' => session('user_login'),
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads'), $photoName);
            $data['photo'] = 'uploads/' . $photoName;
        }

        News::create($data);

        return redirect()->route('profile.index')->with('success', 'Новость успешно добавлена!');
    }
}
