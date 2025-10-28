<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\TentController as UserTentController;
use App\Http\Controllers\User\RentalHistoryController;
use App\Http\Controllers\User\CartController;
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
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Unit Management
    Route::resource('units', \App\Http\Controllers\Admin\UnitController::class);

    // Category Management
    Route::resource('kategoris', \App\Http\Controllers\Admin\KategoriController::class);

    // User Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Rental Management
    Route::resource('peminjamans', \App\Http\Controllers\Admin\PeminjamanController::class);
    Route::put('peminjamans/{peminjaman}/return', [\App\Http\Controllers\Admin\PeminjamanController::class, 'returnRental'])->name('peminjamans.return');
});

// User Routes
Route::middleware(['auth', 'isUser'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // Tent rental routes
    Route::get('/tents', [UserTentController::class, 'index'])->name('user.tents.index');
    Route::get('/tents/{tent}', [UserTentController::class, 'show'])->name('user.tents.show');
    Route::get('/tents/{tent}/rent', [UserTentController::class, 'rent'])->name('user.tents.rent');
    Route::post('/tents/{tent}/rent', [UserTentController::class, 'storeRental'])->name('user.tents.store-rental');

    // Rental history routes
    Route::prefix('rental-history')->name('user.rental-history.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\RentalHistoryController::class, 'index'])->name('index');
        Route::get('/{rental}', [\App\Http\Controllers\User\RentalHistoryController::class, 'show'])->name('show');
        Route::patch('/{rental}/cancel', [\App\Http\Controllers\User\RentalHistoryController::class, 'cancel'])->name('cancel');
    });

    // Cart routes
    Route::prefix('cart')->name('user.cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'store'])->name('store');
        Route::put('/{cart}', [CartController::class, 'update'])->name('update');
        Route::delete('/{cart}', [CartController::class, 'destroy'])->name('destroy');
        Route::delete('/', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'count'])->name('count');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });
});

// Test route for debugging
Route::get('/test-cart', function () {
    return view('test-cart');
})->middleware('auth');

Route::get('/manual-cart-test', function () {
    return view('manual-cart-test');
})->middleware('auth');

Route::get('/simple-cart-test', function () {
    return view('simple-cart-test');
})->middleware('auth');

Route::get('/test-cart-update', function () {
    return view('test_cart_update');
})->middleware('auth');

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
