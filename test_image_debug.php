<?php

// Test script untuk debug image path issues
echo "=== IMAGE PATH DEBUG ===\n\n";

// Check file system paths
$publicPath = __DIR__ . '/public';
$unitsPath = $publicPath . '/images/units';

echo "1. Directory Checks:\n";
echo "   Public path: {$publicPath}\n";
echo "   Public exists: " . (is_dir($publicPath) ? 'YES' : 'NO') . "\n";
echo "   Units path: {$unitsPath}\n";
echo "   Units exists: " . (is_dir($unitsPath) ? 'YES' : 'NO') . "\n\n";

// List files in units directory
echo "2. Files in units directory:\n";
if (is_dir($unitsPath)) {
    $files = scandir($unitsPath);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $filePath = $unitsPath . '/' . $file;
            $size = filesize($filePath);
            echo "   - {$file} ({$size} bytes)\n";
        }
    }
} else {
    echo "   Directory not found!\n";
}

echo "\n3. Test specific images:\n";
$testImages = ['1761629701_MSK-001.jpg', '1761655554_MSK-001.png', '1761655586_CAR-001.png'];

foreach ($testImages as $image) {
    $fullPath = $unitsPath . '/' . $image;
    echo "   - {$image}:\n";
    echo "     File exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
    echo "     Is readable: " . (is_readable($fullPath) ? 'YES' : 'NO') . "\n";
    echo "     Full path: {$fullPath}\n";

    if (file_exists($fullPath)) {
        echo "     File size: " . filesize($fullPath) . " bytes\n";
        echo "     MIME type: " . mime_content_type($fullPath) . "\n";
    }
    echo "\n";
}

echo "4. Test Laravel path functions:\n";

// Simulasi Laravel path functions
function public_path($path = '') {
    return __DIR__ . '/public' . ($path ? '/' . ltrim($path, '/') : '');
}

function asset($path) {
    return 'http://localhost:8000/' . ltrim($path, '/');
}

foreach ($testImages as $image) {
    $laravelPath = public_path('images/units/' . $image);
    $assetUrl = asset('images/units/' . $image);

    echo "   - {$image}:\n";
    echo "     Laravel public_path: {$laravelPath}\n";
    echo "     Laravel exists: " . (file_exists($laravelPath) ? 'YES' : 'NO') . "\n";
    echo "     Asset URL: {$assetUrl}\n\n";
}

echo "5. Permission check:\n";
$perms = fileperms($unitsPath);
echo "   Units directory permissions: " . decoct($perms & 0777) . "\n";

if (is_dir($unitsPath)) {
    $files = scandir($unitsPath);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && !is_dir($unitsPath . '/' . $file)) {
            $filePath = $unitsPath . '/' . $file;
            $perms = fileperms($filePath);
            echo "   {$file} permissions: " . decoct($perms & 0777) . "\n";
        }
    }
}

echo "\n=== END DEBUG ===\n";
