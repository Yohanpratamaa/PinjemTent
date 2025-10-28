<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Unit;
use App\Models\Cart;

echo "=== DEBUGGING CART FUNCTIONALITY ===\n\n";

// Get a test user
$user = User::where('role', 'user')->first();
if (!$user) {
    echo "No user found. Please run migrations and seeders first.\n";
    exit;
}

echo "Test user: {$user->name} (ID: {$user->id})\n";

// Get an available unit
$unit = Unit::where('status', 'tersedia')->where('stok', '>', 0)->first();
if (!$unit) {
    echo "No available units found. Please add some units first.\n";
    exit;
}

echo "Test unit: {$unit->nama_unit} (ID: {$unit->id})\n";
echo "Unit price: Rp " . number_format($unit->harga_sewa_per_hari, 0, ',', '.') . " per day\n";
echo "Available stock: {$unit->available_stock}\n\n";

// Clear existing cart items
Cart::where('user_id', $user->id)->delete();
echo "Cleared existing cart items.\n\n";

// Test data for cart
$testData = [
    'user_id' => $user->id,
    'unit_id' => $unit->id,
    'quantity' => 1,
    'tanggal_mulai' => now()->addDay()->format('Y-m-d'),
    'tanggal_selesai' => now()->addDays(3)->format('Y-m-d'),
    'notes' => 'Test rental from debug script',
    'harga_per_hari' => $unit->harga_sewa_per_hari
];

echo "Test data to be inserted:\n";
foreach ($testData as $key => $value) {
    echo "  {$key}: {$value}\n";
}

echo "\n";

// Try to create cart item directly
try {
    $cartItem = Cart::create($testData);
    echo "SUCCESS: Cart item created successfully!\n";
    echo "Cart ID: {$cartItem->id}\n";
    echo "Duration: {$cartItem->duration} days\n";
    echo "Total price: {$cartItem->formatted_total_harga}\n";

    // Test relationships
    echo "\nTesting relationships:\n";
    echo "User: {$cartItem->user->name}\n";
    echo "Unit: {$cartItem->unit->nama_unit}\n";

    // Test accessors
    echo "\nTesting accessors:\n";
    echo "Formatted price per day: {$cartItem->formatted_harga_per_hari}\n";
    echo "Formatted total price: {$cartItem->formatted_total_harga}\n";

} catch (Exception $e) {
    echo "ERROR: Failed to create cart item\n";
    echo "Error message: {$e->getMessage()}\n";
    echo "Error trace:\n{$e->getTraceAsString()}\n";
}

echo "\n=== TESTING COMPLETE ===\n";
