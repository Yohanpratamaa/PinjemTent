#!/bin/bash

# Debug Deployment Script
echo "=== Laravel Deployment Debug ==="

# Check environment
echo "1. Environment Check:"
echo "APP_ENV: $APP_ENV"
echo "APP_DEBUG: $APP_DEBUG"
echo "APP_KEY set: $(if [ -n "$APP_KEY" ]; then echo 'YES'; else echo 'NO - MISSING!'; fi)"
echo "APP_URL: $APP_URL"

# Check database connection
echo -e "\n2. Database Check:"
echo "DB_CONNECTION: $DB_CONNECTION"
echo "DB_HOST: $DB_HOST"
echo "DB_PORT: $DB_PORT"
echo "DB_DATABASE: $DB_DATABASE"
echo "DB_USERNAME set: $(if [ -n "$DB_USERNAME" ]; then echo 'YES'; else echo 'NO'; fi)"
echo "DB_PASSWORD set: $(if [ -n "$DB_PASSWORD" ]; then echo 'YES'; else echo 'NO'; fi)"

# Test database connection
echo -e "\n3. Testing Database Connection:"
php artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Database connection: SUCCESS'; } catch(Exception \$e) { echo 'Database connection: FAILED - ' . \$e->getMessage(); }"

# Check directories and permissions
echo -e "\n4. Directory and Permission Check:"
echo "Storage writable: $(if [ -w storage ]; then echo 'YES'; else echo 'NO'; fi)"
echo "Bootstrap cache writable: $(if [ -w bootstrap/cache ]; then echo 'YES'; else echo 'NO'; fi)"

# Check key files
echo -e "\n5. Key Files Check:"
echo "Vendor autoload exists: $(if [ -f vendor/autoload.php ]; then echo 'YES'; else echo 'NO'; fi)"
echo "Public index.php exists: $(if [ -f public/index.php ]; then echo 'YES'; else echo 'NO'; fi)"

# Clear all caches
echo -e "\n6. Clearing Caches:"
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Test basic Laravel functionality
echo -e "\n7. Testing Laravel Boot:"
php artisan --version

# Test route accessibility
echo -e "\n8. Testing Route Response:"
curl -s -o /dev/null -w "%{http_code}" http://localhost:$PORT/ || echo "Failed to test route"

echo -e "\n=== Debug Complete ==="
