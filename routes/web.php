<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register.form');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/change-password', [ProfileController::class, 'showChangePassword'])->name('profile.change-password.form');
Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
Route::get('/profile/add-news', [ProfileController::class, 'showAddNews'])->name('profile.add-news.form');
Route::post('/profile/add-news', [ProfileController::class, 'addNews'])->name('profile.add-news');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    Route::get('/news', [AdminController::class, 'news'])->name('news');
    Route::get('/news/create', [AdminController::class, 'createNews'])->name('news.create');
    Route::post('/news', [AdminController::class, 'storeNews'])->name('news.store');
    Route::get('/news/{id}/edit', [AdminController::class, 'editNews'])->name('news.edit');
    Route::put('/news/{id}', [AdminController::class, 'updateNews'])->name('news.update');
    Route::delete('/news/{id}', [AdminController::class, 'deleteNews'])->name('news.delete');
});

Route::get('/', function () {
    return redirect()->route('news.index');
});
