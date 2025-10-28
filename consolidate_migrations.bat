@echo off
echo ========================================
echo   MIGRATION CONSOLIDATION SCRIPT
echo ========================================
echo.
echo This script will:
echo 1. Rollback existing migrations
echo 2. Delete old migration files
echo 3. Run new consolidated migrations
echo.

pause

echo.
echo [STEP 1] Rolling back existing migrations...
php artisan migrate:rollback --step=20

echo.
echo [STEP 2] Deleting old migration files...
del "database\migrations\0001_01_01_000000_create_users_table.php" 2>nul
del "database\migrations\0001_01_01_000001_create_cache_table.php" 2>nul
del "database\migrations\0001_01_01_000002_create_jobs_table.php" 2>nul
del "database\migrations\2025_09_02_075243_add_two_factor_columns_to_users_table.php" 2>nul
del "database\migrations\2025_10_27_070952_add_role_to_users_table.php" 2>nul
del "database\migrations\2025_10_27_095845_create_units_table.php" 2>nul
del "database\migrations\2025_10_27_095855_create_kategoris_table.php" 2>nul
del "database\migrations\2025_10_27_095903_create_peminjamen_table.php" 2>nul
del "database\migrations\2025_10_27_095911_create_unit_kategori_table.php" 2>nul
del "database\migrations\2025_10_27_122538_add_additional_fields_to_units_table.php" 2>nul
del "database\migrations\2025_10_27_232544_add_phone_to_users_table.php" 2>nul

echo Old migration files deleted successfully!

echo.
echo [STEP 3] Running new consolidated migrations...
php artisan migrate

echo.
echo [STEP 4] Checking migration status...
php artisan migrate:status

echo.
echo ========================================
echo   MIGRATION CONSOLIDATION COMPLETE!
echo ========================================
echo.
echo New migrations created:
echo - 2025_10_28_000001_create_users_table.php
echo - 2025_10_28_000002_create_units_table.php
echo - 2025_10_28_000003_create_kategoris_table.php
echo - 2025_10_28_000004_create_unit_kategori_table.php
echo - 2025_10_28_000005_create_peminjamans_table.php
echo - 2025_10_28_000006_create_system_tables.php
echo.

pause
