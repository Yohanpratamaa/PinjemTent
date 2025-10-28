<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== UPLOAD PROCESS TEST ===\n\n";

// Simulasi data upload unit dengan foto
$testData = [
    'kode_unit' => 'TEST-001',
    'nama_unit' => 'Test Unit with Photo',
    'merk' => 'Test Brand',
    'kapasitas' => '4 orang',
    'deskripsi' => 'Test unit for photo upload',
    'status' => 'tersedia',
    'stok' => 2,
    'harga_sewa_per_hari' => 75000.00,
    'denda_per_hari' => 15000.00,
    'harga_beli' => 1500000.00,
];

echo "1. Creating test unit without photo:\n";
$unit = \App\Models\Unit::create($testData);
echo "   Unit created: ID {$unit->id}, Code: {$unit->kode_unit}\n";
echo "   Foto field: " . ($unit->foto ?: 'NULL') . "\n";

echo "\n2. Simulating photo upload process:\n";
// Simulate file upload by copying existing file
$sourceFile = public_path('images/units/1761629701_MSK-001.jpg');
$targetFile = public_path('images/units/test_upload_' . time() . '.jpg');

if (file_exists($sourceFile)) {
    copy($sourceFile, $targetFile);
    $fileName = basename($targetFile);
    echo "   Photo copied: {$fileName}\n";

    // Update unit with photo
    $unit->update(['foto' => $fileName]);
    $unit->refresh();

    echo "   Unit updated with foto: {$unit->foto}\n";
    echo "   Foto URL accessor: {$unit->foto_url}\n";
    echo "   Has foto accessor: " . ($unit->has_foto ? 'YES' : 'NO') . "\n";

    // Test file existence
    $filePath = public_path('images/units/' . $unit->foto);
    echo "   File exists on disk: " . (file_exists($filePath) ? 'YES' : 'NO') . "\n";

} else {
    echo "   Source file not found: {$sourceFile}\n";
}

echo "\n3. Testing validation rules:\n";

// Test StoreUnitRequest validation
$validation = [
    'foto' => [
        'nullable',
        'image',
        'mimes:jpeg,png,jpg,gif',
        'max:2048'
    ]
];

echo "   Validation rules for foto field:\n";
foreach ($validation['foto'] as $rule) {
    echo "     - {$rule}\n";
}

echo "\n4. Checking form enctype in views:\n";
$createView = file_get_contents(resource_path('views/admin/units/create.blade.php'));
$editView = file_get_contents(resource_path('views/admin/units/edit.blade.php'));

$hasCreateEnctype = strpos($createView, 'multipart/form-data') !== false;
$hasEditEnctype = strpos($editView, 'multipart/form-data') !== false;

echo "   Create form has enctype: " . ($hasCreateEnctype ? 'YES' : 'NO') . "\n";
echo "   Edit form has enctype: " . ($hasEditEnctype ? 'YES' : 'NO') . "\n";

echo "\n5. Test current units with photos:\n";
$unitsWithPhotos = \App\Models\Unit::whereNotNull('foto')->get(['id', 'kode_unit', 'nama_unit', 'foto']);

if ($unitsWithPhotos->count() > 0) {
    foreach ($unitsWithPhotos as $u) {
        echo "   - ID: {$u->id} | Code: {$u->kode_unit} | Photo: {$u->foto}\n";
        echo "     URL: {$u->foto_url}\n";
        echo "     Has foto: " . ($u->has_foto ? 'YES' : 'NO') . "\n";
    }
} else {
    echo "   No units with photos found\n";
}

echo "\n6. Clean up test unit:\n";
$unit->delete();
if (isset($targetFile) && file_exists($targetFile)) {
    unlink($targetFile);
    echo "   Test files cleaned up\n";
}

echo "\n=== END TEST ===\n";
