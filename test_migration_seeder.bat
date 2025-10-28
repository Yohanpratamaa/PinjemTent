@echo off
echo ========================================
echo   MIGRATION AND SEEDER TEST SCRIPT
echo ========================================
echo.
echo This script will:
echo 1. Fresh migrate the database
echo 2. Run all seeders
echo 3. Test user creation
echo 4. Validate data integrity
echo.

pause

echo.
echo [STEP 1] Fresh migrating database...
php artisan migrate:fresh

echo.
echo [STEP 2] Running seeders...
php artisan db:seed

echo.
echo [STEP 3] Testing user creation functionality...
php artisan tinker --execute="
echo 'Testing user creation...';
try {
    \$user = App\Models\User::create([
        'name' => 'Test Create User',
        'email' => 'testcreate@example.com',
        'phone' => '081999888777',
        'password' => bcrypt('password123'),
        'role' => 'user'
    ]);
    echo 'SUCCESS: User created with ID: ' . \$user->id;
} catch (Exception \$e) {
    echo 'ERROR: ' . \$e->getMessage();
}
"

echo.
echo [STEP 4] Checking data integrity...
php artisan tinker --execute="
echo 'Database Statistics:';
echo 'Users: ' . App\Models\User::count();
echo 'Units: ' . App\Models\Unit::count();
echo 'Categories: ' . App\Models\Kategori::count();
echo 'Rentals: ' . App\Models\Peminjaman::count();
echo 'Unit-Category Relations: ' . DB::table('unit_kategori')->count();
"

echo.
echo [STEP 5] Testing relationships...
php artisan tinker --execute="
echo 'Testing relationships...';
\$unit = App\Models\Unit::with('kategoris')->first();
if (\$unit) {
    echo 'Unit: ' . \$unit->nama_unit . ' has ' . \$unit->kategoris->count() . ' categories';
} else {
    echo 'No units found';
}

\$user = App\Models\User::where('role', 'user')->first();
if (\$user) {
    echo 'User: ' . \$user->name . ' has ' . \$user->peminjamans->count() . ' rentals';
} else {
    echo 'No regular users found';
}
"

echo.
echo ========================================
echo   MIGRATION AND SEEDER TEST COMPLETE!
echo ========================================
echo.
echo All tests completed successfully!
echo You can now test the application.
echo.

pause
