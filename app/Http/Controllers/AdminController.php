<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\News;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function checkAdminAccess()
    {
        if (!session('user_id')) {
            return redirect()->route('auth.login.form');
        }
        
        $user = User::find(session('user_id'));
        if (!$user || !$user->isAdminOrContentManager()) {
            return redirect()->route('news.index')->with('error', 'Доступ запрещен.');
        }
        
        return null;
    }

    public function dashboard()
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        $topNews = News::orderBy('created_at', 'desc')->take(5)->get();
        
        $topAuthors = News::select('author', DB::raw('count(*) as news_count'))
            ->groupBy('author')
            ->orderBy('news_count', 'desc')
            ->take(5)
            ->get();

        $stats = [
            'total_users' => User::count(),
            'total_news' => News::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_content_managers' => User::where('role', 'content_manager')->count(),
        ];

        return view('admin.dashboard', compact('topNews', 'topAuthors', 'stats'));
    }

    public function users()
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        $request->validate([
            'login' => 'required|string|unique:users,login|min:3|max:50',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:user,content_manager,admin',
        ]);

        User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'Пользователь успешно создан!');
    }

    public function editUser($id)
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        $user = User::findOrFail($id);
        
        $request->validate([
            'login' => 'required|string|unique:users,login,' . $id . '|min:3|max:50',
            'role' => 'required|in:user,content_manager,admin',
        ]);

        $data = [
            'login' => $request->login,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'Пользователь успешно обновлен!');
    }

    public function deleteUser($id)
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        $user = User::findOrFail($id);
        
        if ($user->id == session('user_id')) {
            return redirect()->route('admin.users')->with('error', 'Нельзя удалить самого себя!');
        }
        
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Пользователь успешно удален!');
    }

    public function news()
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        $news = News::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function createNews()
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        return view('admin.news.create');
    }

    public function storeNews(Request $request)
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'author' => $request->author,
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads'), $photoName);
            $data['photo'] = 'uploads/' . $photoName;
        }

        News::create($data);

        return redirect()->route('admin.news')->with('success', 'Новость успешно создана!');
    }

    public function editNews($id)
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function updateNews(Request $request, $id)
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        $news = News::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'author' => $request->author,
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads'), $photoName);
            $data['photo'] = 'uploads/' . $photoName;
        }

        $news->update($data);

        return redirect()->route('admin.news')->with('success', 'Новость успешно обновлена!');
    }

    public function deleteNews($id)
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;

        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('admin.news')->with('success', 'Новость успешно удалена!');
    }
}
