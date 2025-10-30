# 🛠️ PHP Version Compatibility Fix

## ❌ Problem

```bash
Error: brianium/paratest v7.14.2 requires php ~8.3.0 || ~8.4.0 || ~8.5.0 -> your php version (8.2.29) does not satisfy that requirement.
```

## ⚠️ **PENTING: Selalu Gunakan Flag `--ignore-platform-reqs`**

### **❌ JANGAN Gunakan:**

```bash
composer install --optimize-autoloader --no-scripts --no-interaction
```

### **✅ HARUS Gunakan:**

```bash
composer install --optimize-autoloader --no-scripts --no-interaction --ignore-platform-reqs
```

**Flag `--ignore-platform-reqs` WAJIB untuk project ini!**

## ✅ Solutions

### **Quick Fix (Windows)**

```cmd
# Run the setup script
setup.bat
```

### **Manual Fix**

```bash
# Use ignore platform requirements
composer install --optimize-autoloader --ignore-platform-reqs

# Or use NPM script
npm run composer-dev
```

### **For Development**

```bash
# Install all dependencies
npm run setup

# Fresh installation with database
npm run fresh

# Production build
npm run composer-prod
```

### **For Railway Deployment**

✅ Already configured in:

-   `nixpacks.toml` (uses PHP 8.3)
-   `deploy.sh` (includes --ignore-platform-reqs)
-   `composer.json` (production script)

## 🔧 Available Commands

### **NPM Scripts:**

-   `npm run setup` - Full project setup
-   `npm run composer-dev` - Install dev dependencies
-   `npm run composer-prod` - Install production dependencies
-   `npm run fresh` - Fresh install with migrations

### **Composer Commands:**

```bash
# Development (WAJIB pakai --ignore-platform-reqs)
composer install --ignore-platform-reqs

# Dengan optimizations
composer install --optimize-autoloader --ignore-platform-reqs

# No scripts + optimized (seperti yang Anda coba)
composer install --optimize-autoloader --no-scripts --no-interaction --ignore-platform-reqs

# Production
composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Clean start
rm composer.lock && composer install --ignore-platform-reqs
```

### **Windows Batch Files:**

-   `setup.bat` - Complete Windows setup
-   `deploy.sh` - Production deployment preparation

## 🎯 Why This Happens

1. **Testing packages** (Pest, PHPUnit) require PHP 8.3+
2. **Local development** uses PHP 8.2
3. **composer.lock** locks to specific versions
4. **Railway deployment** uses PHP 8.3 (fixed in nixpacks.toml)

## 🚀 Production Ready

✅ Railway deployment automatically uses PHP 8.3  
✅ All deployment configs updated  
✅ Local development works with --ignore-platform-reqs

**No more version conflicts!** 🎉
