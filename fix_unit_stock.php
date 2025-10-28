<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Unit;
use App\Models\Peminjaman;

echo "=== FIXING UNIT STOCK AVAILABILITY ===\n\n";

// Check current peminjamans that might be affecting stock
echo "1. Checking active rentals:\n";
$activeRentals = Peminjaman::whereIn('status', ['pending', 'dipinjam', 'disetujui'])->get();
foreach ($activeRentals as $rental) {
    echo "   - Unit {$rental->unit_id}: {$rental->jumlah} units rented (Status: {$rental->status})\n";
}

echo "\n2. Current unit stocks:\n";
$units = Unit::all();
foreach ($units as $unit) {
    echo "   - {$unit->nama_unit}: Stock {$unit->stok}, Available: {$unit->available_stock}\n";
}

echo "\n3. Updating units to have available stock:\n";

// Update units to ensure some stock is available
$unitsToUpdate = [
    1 => ['stok' => 10], // Tenda Dome 4 Orang
    2 => ['stok' => 8],  // Tenda Tunnel 6 Orang
    3 => ['stok' => 12], // Kompor Portable
    4 => ['stok' => 10], // Nesting Set
    5 => ['stok' => 15], // Tas Carrier 60L
    6 => ['stok' => 20], // Sleeping Bag Mummy
];

foreach ($unitsToUpdate as $unitId => $updates) {
    $unit = Unit::find($unitId);
    if ($unit) {
        $oldStock = $unit->stok;
        $unit->update($updates);
        $unit->refresh();
        echo "   - Updated {$unit->nama_unit}: Stock {$oldStock} -> {$unit->stok}, Available: {$unit->available_stock}\n";
    }
}

echo "\n4. Final stock status:\n";
$units = Unit::all();
foreach ($units as $unit) {
    $status = $unit->available_stock > 0 ? "✓ Available" : "✗ No stock";
    echo "   - {$unit->nama_unit}: Stock {$unit->stok}, Available: {$unit->available_stock} ({$status})\n";
}

echo "\n=== STOCK UPDATE COMPLETE ===\n";
