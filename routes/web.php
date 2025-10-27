<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    // Jika user sudah login, redirect berdasarkan role
    if (Auth::check()) {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user && $user->role === 'user') {
            return redirect()->route('user.dashboard');
        }
    }

    // Jika belum login, redirect ke login
    return redirect()->route('login');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Admin Routes
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// User Routes
Route::middleware(['auth', 'isUser'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

// Legacy dashboard route (redirect based on role)
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user && $user->role === 'user') {
        return redirect()->route('user.dashboard');
    }

    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
