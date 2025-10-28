<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== MANUAL UNIT UPDATE WITH PHOTO ===\n\n";

// Get a unit to update
$unit = \App\Models\Unit::first();

if (!$unit) {
    echo "No units found in database\n";
    exit;
}

echo "1. Current unit details:\n";
echo "   ID: {$unit->id}\n";
echo "   Code: {$unit->kode_unit}\n";
echo "   Name: {$unit->nama_unit}\n";
echo "   Current foto: " . ($unit->foto ?: 'NULL') . "\n";

echo "\n2. Available images to assign:\n";
$unitsPath = public_path('images/units');
$files = scandir($unitsPath);
$imageFiles = [];

foreach ($files as $file) {
    if ($file !== '.' && $file !== '..' && !is_dir($unitsPath . '/' . $file)) {
        if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
            $imageFiles[] = $file;
            echo "   - {$file}\n";
        }
    }
}

if (empty($imageFiles)) {
    echo "   No image files found\n";
    exit;
}

echo "\n3. Updating unit with first available image:\n";
$selectedImage = $imageFiles[0];
$unit->update(['foto' => $selectedImage]);
$unit->refresh();

echo "   Unit updated with: {$selectedImage}\n";
echo "   Unit foto field: {$unit->foto}\n";
echo "   Foto URL: {$unit->foto_url}\n";
echo "   Has foto: " . ($unit->has_foto ? 'YES' : 'NO') . "\n";

echo "\n4. Verification:\n";
$filePath = public_path('images/units/' . $unit->foto);
echo "   File exists: " . (file_exists($filePath) ? 'YES' : 'NO') . "\n";
echo "   File size: " . (file_exists($filePath) ? filesize($filePath) . ' bytes' : 'N/A') . "\n";

echo "\n5. Test asset URL:\n";
$assetUrl = asset('images/units/' . $unit->foto);
echo "   Asset URL: {$assetUrl}\n";

echo "\n=== UPDATE COMPLETE ===\n";
