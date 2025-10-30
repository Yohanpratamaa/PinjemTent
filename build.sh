#!/bin/bash

# Railway Build Script - Handle PHP version conflicts
echo "🚀 Building for Railway deployment..."

# 1. Remove composer.lock to avoid version conflicts
echo "🗑️ Removing composer.lock to avoid conflicts..."
rm -f composer.lock

# 2. Install production dependencies only
echo "📦 Installing production dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# 3. Install Node dependencies and build assets
echo "🏗️ Building frontend assets..."
npm ci --only=production
npm run build

# 4. Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Build complete!"
