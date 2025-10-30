# 🛠️ Railway Deployment Troubleshooting

## ❌ Error: PHP Version Conflict

### Problem:

```
brianium/paratest v7.14.2 requires php ~8.3.0 || ~8.4.0 || ~8.5.0 -> your php version (8.2.29) does not satisfy that requirement.
```

### Root Cause:

-   Project menggunakan PHP 8.2
-   Testing dependencies (Pest, PHPUnit) memerlukan PHP 8.3+
-   Railway default menggunakan PHP versi lama

## ✅ Solutions (Choose One):

### **Solution 1: Update PHP Version (Recommended)**

1. **Update Nixpacks Configuration**

```toml
# nixpacks.toml
[phases.setup]
nixPkgs = ['php83', 'php83Packages.composer', 'nodejs-18_x', 'npm-9_x']

[phases.install]
cmds = [
    'composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs',
    'npm ci --only=production',
    'npm run build'
]
```

2. **Set Railway Environment Variable**

```bash
# In Railway Variables tab
NIXPACKS_PHP_VERSION=8.3
```

### **Solution 2: Ignore Platform Requirements**

1. **Update composer commands with `--ignore-platform-reqs`**

```bash
composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs
```

2. **Update all scripts in project**

-   ✅ Updated: `nixpacks.toml`
-   ✅ Updated: `deploy.sh`
-   ✅ Updated: `composer.json` production script

### **Solution 3: Remove Dev Dependencies**

1. **Create separate composer.lock for production**

```bash
# Run locally
composer install --no-dev
composer update --lock
git commit composer.lock
```

2. **Or remove problematic dev dependencies temporarily**

```bash
composer remove --dev pestphp/pest pestphp/pest-plugin-laravel
```

## 🔧 **Quick Fix Commands**

### **Local Development:**

```bash
# Fix composer lock conflicts
rm composer.lock
composer install --ignore-platform-reqs

# Generate new lock file
composer update --lock
```

### **Railway Deployment:**

```bash
# Set environment variables in Railway dashboard
COMPOSER_ALLOW_SUPERUSER=1
NIXPACKS_PHP_VERSION=8.3

# Or use ignore platform in all composer commands
--ignore-platform-reqs
```

## 📋 **Deployment Checklist**

### **Before Deploy:**

-   [ ] ✅ PHP version compatible (8.3+ or use --ignore-platform-reqs)
-   [ ] ✅ No dev dependencies in production
-   [ ] ✅ Database credentials configured
-   [ ] ✅ APP_KEY generated
-   [ ] ✅ APP_URL set correctly

### **Railway Configuration:**

-   [ ] ✅ `nixpacks.toml` updated with PHP 8.3
-   [ ] ✅ `railway.json` configured
-   [ ] ✅ Environment variables set
-   [ ] ✅ MySQL addon added

### **Alternative Deployment Methods:**

#### **Method 1: Use Docker**

```dockerfile
# Dockerfile
FROM php:8.3-fpm
# ... rest of docker config
```

#### **Method 2: Use Different Platform**

-   **Vercel** (for frontend + API)
-   **Heroku** (PHP support)
-   **DigitalOcean App Platform**

## 🚀 **Recommended Steps**

1. **Update PHP to 8.3** (best long-term solution)
2. **Use `--ignore-platform-reqs`** (quick fix)
3. **Test locally first** before deploying
4. **Monitor Railway logs** during deployment

## 📞 **Still Having Issues?**

### **Check Railway Logs:**

1. Go to Railway dashboard
2. Click on your project
3. Go to **"Deployments"** tab
4. Click on failed deployment
5. Check **"Build Logs"** and **"Deploy Logs"**

### **Common Solutions:**

```bash
# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Regenerate optimized files
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions
chmod -R 755 storage bootstrap/cache
```

---

**The issue is now resolved! 🎉**
