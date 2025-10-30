# 🚀 PinjemTent Development Cheat Sheet

## ⚡ Quick Commands

### **Setup Project (First Time)**

```bash
# Windows
setup.bat

# Manual
composer install && npm install && npm run build
php artisan key:generate
php artisan migrate:fresh --seed
```

### **Daily Development**

```bash
# Start development server
php artisan serve

# Fresh database
php artisan migrate:fresh --seed

# Clear all cache
php artisan config:clear && php artisan route:clear && php artisan view:clear

# Build assets
npm run build
```

### **Composer Commands**

```bash
# Install dependencies (now works without extra flags!)
composer install

# Install with optimizations
composer install --optimize-autoloader

# Production install
composer install --no-dev --optimize-autoloader

# Update dependencies
composer update

# Add new package
composer require package/name
```

### **NPM Scripts**

```bash
npm run setup          # Full project setup
npm run composer-dev    # Install dev dependencies
npm run composer-prod   # Install production dependencies
npm run fresh          # Fresh install + migration
npm run build          # Build assets
npm run dev            # Development server (Vite)
```

### **Laravel Artisan**

```bash
php artisan serve               # Start server
php artisan migrate            # Run migrations
php artisan migrate:fresh      # Fresh migrations
php artisan migrate:fresh --seed  # Fresh + seed
php artisan key:generate       # Generate APP_KEY
php artisan config:cache       # Cache config
php artisan route:cache        # Cache routes
php artisan view:cache         # Cache views
php artisan storage:link       # Create storage symlink
```

### **Git Workflow**

```bash
git add .
git commit -m "Your message"
git push origin Development

# Deploy to Railway (auto-deploy on push)
git push origin main
```

## 🐛 **Troubleshooting**

### **Still Getting PHP Version Error?**

```bash
# Add --ignore-platform-reqs
composer install --ignore-platform-reqs

# Or clear composer cache
composer clear-cache
rm composer.lock
composer install
```

### **Database Issues?**

```bash
# Reset database
php artisan migrate:fresh --seed

# Check connection
php artisan tinker
DB::connection()->getPdo();
```

### **Asset Issues?**

```bash
# Rebuild assets
npm run build

# Clear view cache
php artisan view:clear
```

### **Permission Issues? (Linux/Mac)**

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 🚀 **Deployment**

### **Railway Deployment**

1. Push to GitHub: `git push origin main`
2. Railway auto-deploys
3. Check logs in Railway dashboard

### **Manual Deployment Prep**

```bash
composer install --no-dev --optimize-autoloader
npm ci --only=production
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📞 **Default Accounts**

-   **Admin**: admin@example.com / password
-   **User**: user@example.com / password

## 🎯 **Project URLs**

-   **Local**: http://localhost:8000
-   **Railway**: https://your-app.railway.app

---

**Happy Coding! 🎉**
