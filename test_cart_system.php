<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CART SYSTEM TEST ===\n\n";

// Get a test user (role = user)
$user = \App\Models\User::where('role', 'user')->first();

if (!$user) {
    echo "No user found with role 'user'. Creating test user...\n";
    $user = \App\Models\User::create([
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => bcrypt('password'),
        'role' => 'user',
        'phone' => '08123456789'
    ]);
    echo "Test user created: {$user->name} ({$user->email})\n";
}

echo "Using user: {$user->name} ({$user->email})\n\n";

// Get some units to add to cart
$units = \App\Models\Unit::where('status', 'tersedia')->where('stok', '>', 0)->limit(2)->get();

if ($units->count() == 0) {
    echo "No available units found. Please add some units first.\n";
    exit;
}

echo "Available units to test:\n";
foreach ($units as $unit) {
    echo "  - ID: {$unit->id}, Code: {$unit->kode_unit}, Name: {$unit->nama_unit}, Stock: {$unit->stok}\n";
}

echo "\n1. Testing Cart Creation:\n";

// Clear existing cart items for this user
\App\Models\Cart::where('user_id', $user->id)->delete();

// Add first unit to cart
$cartItem1 = \App\Models\Cart::create([
    'user_id' => $user->id,
    'unit_id' => $units->first()->id,
    'quantity' => 2,
    'tanggal_mulai' => now()->addDay(),
    'tanggal_selesai' => now()->addDays(3),
    'notes' => 'Test rental for camping',
    'harga_per_hari' => $units->first()->harga_sewa_per_hari
]);

echo "   Created cart item 1: {$cartItem1->unit->nama_unit}, Qty: {$cartItem1->quantity}, Duration: {$cartItem1->duration} days\n";
echo "   Total price: {$cartItem1->formatted_total_harga}\n";

if ($units->count() > 1) {
    // Add second unit to cart
    $cartItem2 = \App\Models\Cart::create([
        'user_id' => $user->id,
        'unit_id' => $units->last()->id,
        'quantity' => 1,
        'tanggal_mulai' => now()->addDays(2),
        'tanggal_selesai' => now()->addDays(5),
        'notes' => 'Weekend trip',
        'harga_per_hari' => $units->last()->harga_sewa_per_hari
    ]);

    echo "   Created cart item 2: {$cartItem2->unit->nama_unit}, Qty: {$cartItem2->quantity}, Duration: {$cartItem2->duration} days\n";
    echo "   Total price: {$cartItem2->formatted_total_harga}\n";
}

echo "\n2. Testing Cart Retrieval:\n";

$cartItems = \App\Models\Cart::forUser($user->id)->with('unit')->get();
$grandTotal = $cartItems->sum('total_harga');

echo "   Cart items for user {$user->name}:\n";
foreach ($cartItems as $item) {
    echo "     - {$item->unit->nama_unit}: {$item->quantity}x, {$item->duration} days, {$item->formatted_total_harga}\n";
    echo "       Dates: {$item->tanggal_mulai} to {$item->tanggal_selesai}\n";
    if ($item->notes) {
        echo "       Notes: {$item->notes}\n";
    }
}

echo "   Grand Total: Rp " . number_format($grandTotal, 0, ',', '.') . "\n";

echo "\n3. Testing Date Availability Check:\n";

foreach ($cartItems as $item) {
    $isAvailable = $item->isDateAvailable();
    echo "   {$item->unit->nama_unit} availability: " . ($isAvailable ? 'Available' : 'Not Available') . "\n";
}

echo "\n4. Testing Cart Relationships:\n";

// Test user->carts relationship
$userCarts = $user->carts()->with('unit')->get();
echo "   User has {$userCarts->count()} items in cart\n";

// Test unit->carts relationship
$unit = $units->first();
$unitCarts = $unit->carts()->with('user')->get();
echo "   Unit '{$unit->nama_unit}' is in {$unitCarts->count()} cart(s)\n";

echo "\n5. Testing Cart Model Calculations:\n";

$testItem = $cartItems->first();
echo "   Item: {$testItem->unit->nama_unit}\n";
echo "   Duration calculation: {$testItem->duration} days\n";
echo "   Total calculation: {$testItem->quantity} × {$testItem->duration} × {$testItem->harga_per_hari} = {$testItem->total_harga}\n";
echo "   Formatted total: {$testItem->formatted_total_harga}\n";

echo "\n=== CART SYSTEM TEST COMPLETE ===\n";
