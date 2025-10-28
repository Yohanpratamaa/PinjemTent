<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Unit;
use App\Models\Cart;

echo "=== DEBUGGING COMPLETE CART SYSTEM ===\n\n";

// Check users
echo "1. CHECKING USERS:\n";
$users = User::all();
foreach ($users as $user) {
    echo "   - ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
}

// Check units
echo "\n2. CHECKING UNITS:\n";
$units = Unit::where('status', 'tersedia')->get();
foreach ($units as $unit) {
    echo "   - ID: {$unit->id}, Code: {$unit->kode_unit}, Name: {$unit->nama_unit}, Stock: {$unit->stok}, Available: {$unit->available_stock}, Price: {$unit->harga_sewa_per_hari}\n";
}

// Check routes
echo "\n3. CHECKING ROUTES:\n";
$routes = collect(\Illuminate\Support\Facades\Route::getRoutes())->filter(function($route) {
    return str_contains($route->getName() ?? '', 'user.cart');
});

foreach ($routes as $route) {
    echo "   - {$route->methods[0]} {$route->uri} => {$route->getName()}\n";
}

// Test cart creation manually
echo "\n4. TESTING CART CREATION:\n";
$testUser = User::where('role', 'user')->first();
$testUnit = Unit::where('status', 'tersedia')->first();

if ($testUser && $testUnit) {
    echo "   Using User: {$testUser->name} (ID: {$testUser->id})\n";
    echo "   Using Unit: {$testUnit->nama_unit} (ID: {$testUnit->id})\n";

    // Clear existing cart
    Cart::where('user_id', $testUser->id)->delete();

    try {
        $cartData = [
            'user_id' => $testUser->id,
            'unit_id' => $testUnit->id,
            'quantity' => 1,
            'tanggal_mulai' => now()->addDay()->format('Y-m-d'),
            'tanggal_selesai' => now()->addDays(3)->format('Y-m-d'),
            'notes' => 'Manual test',
            'harga_per_hari' => $testUnit->harga_sewa_per_hari
        ];

        $cart = Cart::create($cartData);
        echo "   ✓ Cart created successfully! ID: {$cart->id}\n";
        echo "   ✓ Total price: {$cart->formatted_total_harga}\n";

        // Test count
        $count = Cart::forUser($testUser->id)->count();
        echo "   ✓ Cart count for user: {$count}\n";

    } catch (Exception $e) {
        echo "   ✗ Failed to create cart: {$e->getMessage()}\n";
    }
} else {
    echo "   ✗ Missing test user or unit\n";
}

// Check current cart items
echo "\n5. CURRENT CART ITEMS:\n";
$allCarts = Cart::with(['user', 'unit'])->get();
foreach ($allCarts as $cart) {
    echo "   - ID: {$cart->id}, User: {$cart->user->name}, Unit: {$cart->unit->nama_unit}, Qty: {$cart->quantity}, Total: {$cart->formatted_total_harga}\n";
}

echo "\n=== DEBUGGING COMPLETE ===\n";
