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

    // Notification Management
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('index');
        Route::get('/{notification}', [\App\Http\Controllers\Admin\NotificationController::class, 'show'])->name('show');
        Route::post('/{notification}/approve', [\App\Http\Controllers\Admin\NotificationController::class, 'approve'])->name('approve');
        Route::post('/{notification}/reject', [\App\Http\Controllers\Admin\NotificationController::class, 'reject'])->name('reject');
        Route::post('/{notification}/approve-rental', [\App\Http\Controllers\Admin\NotificationController::class, 'approveRental'])->name('approve-rental');
        Route::post('/{notification}/reject-rental', [\App\Http\Controllers\Admin\NotificationController::class, 'rejectRental'])->name('reject-rental');
        Route::put('/{notification}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    });
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
        Route::post('/{rental}/request-return', [\App\Http\Controllers\User\RentalHistoryController::class, 'requestReturn'])->name('request-return');
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

// Debug route for notifications
Route::get('/debug-notifications', function () {
    $notifications = \App\Models\Notification::with(['user', 'peminjaman.unit'])
        ->where('is_admin_notification', true)
        ->where('type', 'rental_request')
        ->limit(5)
        ->get();

    $debug_data = [];
    foreach ($notifications as $notification) {
        $debug_data[] = [
            'id' => $notification->id,
            'type' => $notification->type,
            'peminjaman_id' => $notification->peminjaman_id,
            'tanggal_pinjam' => $notification->peminjaman?->tanggal_pinjam,
            'tanggal_kembali_rencana' => $notification->peminjaman?->tanggal_kembali_rencana,
            'rental_status' => $notification->peminjaman?->rental_status,
            'harga_sewa_total' => $notification->peminjaman?->harga_sewa_total,
            'unit_name' => $notification->peminjaman?->unit?->nama_unit,
            'user_name' => $notification->user?->name,
            'created_at' => $notification->created_at,
        ];
    }

    return response()->json($debug_data);
})->middleware(['auth', 'isAdmin']);

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

// Debug route - remove after testing
Route::get('/debug-auth', function () {
    if (!Auth::check()) {
        return response()->json(['status' => 'not_logged_in']);
    }

    $user = Auth::user();
    return response()->json([
        'status' => 'logged_in',
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role,
        'is_admin' => $user->role === 'admin',
    ]);
})->middleware('web');

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
