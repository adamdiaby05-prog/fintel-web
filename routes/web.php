<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
	return redirect()->route('login');
});

// Routes utilisateurs
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware('auth')->name('dashboard');

// Routes admin
Route::get('/admin/register', [AdminController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register.post');

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');

Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware('auth:admin')->prefix('admin')->group(function () {
	Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
	Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
	Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
	Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('admin.user.show');
});
