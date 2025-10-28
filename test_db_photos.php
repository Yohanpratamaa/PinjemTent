<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DATABASE PHOTO CHECK ===\n\n";

// Get units with photos
$units = \App\Models\Unit::whereNotNull('foto')->get(['id', 'kode_unit', 'nama_unit', 'foto']);

echo "Units with photos in database:\n";
foreach ($units as $unit) {
    echo "  - ID: {$unit->id} | Code: {$unit->kode_unit} | Name: {$unit->nama_unit} | Photo: {$unit->foto}\n";

    // Check if file exists
    $filePath = public_path('images/units/' . $unit->foto);
    $exists = file_exists($filePath);
    echo "    File exists: " . ($exists ? 'YES' : 'NO') . "\n";

    // Test accessor
    echo "    Foto URL (accessor): {$unit->foto_url}\n";
    echo "    Has foto (accessor): " . ($unit->has_foto ? 'YES' : 'NO') . "\n\n";
}

echo "\nAll units:\n";
$allUnits = \App\Models\Unit::get(['id', 'kode_unit', 'nama_unit', 'foto']);
foreach ($allUnits as $unit) {
    echo "  - ID: {$unit->id} | Code: {$unit->kode_unit} | Photo: " . ($unit->foto ?: 'NULL') . "\n";
}

echo "\n=== END CHECK ===\n";
