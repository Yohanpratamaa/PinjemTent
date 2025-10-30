#!/bin/bash

# Railway Environment Validation Script
echo "=== Validating Railway Environment ==="

# Required environment variables
required_vars=(
    "APP_KEY"
    "APP_URL"
    "DB_CONNECTION"
    "DB_HOST"
    "DB_PORT"
    "DB_DATABASE"
    "DB_USERNAME"
    "DB_PASSWORD"
)

missing_vars=()

echo "Checking required environment variables..."
for var in "${required_vars[@]}"; do
    if [ -z "${!var}" ]; then
        missing_vars+=("$var")
        echo "❌ $var is missing"
    else
        echo "✅ $var is set"
    fi
done

if [ ${#missing_vars[@]} -gt 0 ]; then
    echo -e "\n🚨 MISSING ENVIRONMENT VARIABLES:"
    printf '%s\n' "${missing_vars[@]}"
    echo -e "\nPlease set these variables in Railway dashboard:"
    echo "1. Go to your Railway project"
    echo "2. Click on your service"
    echo "3. Go to Variables tab"
    echo "4. Add the missing variables"
    exit 1
else
    echo -e "\n✅ All required environment variables are set!"
fi

# Validate APP_KEY format
if [[ ! "$APP_KEY" =~ ^base64: ]]; then
    echo "⚠️  APP_KEY should start with 'base64:'"
    echo "Generate a new one with: php artisan key:generate --show"
fi

# Validate database connection
echo -e "\nTesting database connection..."
php artisan tinker --execute="
try {
    \$pdo = DB::connection()->getPdo();
    echo '✅ Database connection successful\n';
    echo 'Database: ' . DB::connection()->getDatabaseName() . '\n';
} catch(Exception \$e) {
    echo '❌ Database connection failed: ' . \$e->getMessage() . '\n';
    exit(1);
}
"

echo -e "\n🚀 Environment validation complete!"
