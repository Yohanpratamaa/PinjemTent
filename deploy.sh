#!/bin/bash

# Railway Deployment Script
# This script prepares the Laravel app for Railway deployment

echo "🚀 Preparing Laravel app for Railway deployment..."

# 1. Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 2. Install Node dependencies and build assets
echo "🏗️ Building frontend assets..."
npm ci --only=production
npm run build

# 3. Clear all cache
echo "🧹 Clearing cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 4. Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# 6. Run migrations
echo "🗃️ Running database migrations..."
php artisan migrate --force

# 7. Seed database (optional - uncomment if needed)
# echo "🌱 Seeding database..."
# php artisan db:seed --force

echo "✅ Deployment preparation complete!"
echo "🌐 Your app is ready for Railway deployment"
