# 🚀 Deploy Laravel PinjemTent ke Railway

## 📋 Prerequisites

1. **Akun Railway** - Daftar di [railway.app](https://railway.app)
2. **GitHub Repository** - Project harus ada di GitHub
3. **Database MySQL** - Railway menyediakan MySQL addon
4. **Domain (Opsional)** - Untuk custom domain

---

## 🛠️ Step 1: Persiapan Project

### 1.1 Buat Railway Configuration Files

Buat file `railway.json` di root project:

```json
{
    "$schema": "https://railway.app/railway.schema.json",
    "build": {
        "builder": "nixpacks"
    },
    "deploy": {
        "startCommand": "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT",
        "healthcheckPath": "/",
        "healthcheckTimeout": 300
    }
}
```

### 1.2 Buat Nixpacks Configuration

Buat file `nixpacks.toml`:

```toml
[phases.setup]
nixPkgs = ['php81', 'php81Packages.composer', 'nodejs-18_x', 'npm-9_x']

[phases.install]
cmds = [
    'composer install --no-dev --optimize-autoloader',
    'npm ci',
    'npm run build'
]

[phases.build]
cmds = [
    'php artisan config:cache',
    'php artisan route:cache',
    'php artisan view:cache'
]

[start]
cmd = 'php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT'
```

### 1.3 Update Composer.json

Pastikan ada post-install script:

```json
{
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": ["@php artisan key:generate --ansi"]
    }
}
```

---

## 🚀 Step 2: Deploy ke Railway

### 2.1 Login ke Railway

1. Buka [railway.app](https://railway.app)
2. Login dengan GitHub account
3. Authorize Railway untuk akses repository

### 2.2 Create New Project

1. Click **"New Project"**
2. Pilih **"Deploy from GitHub repo"**
3. Pilih repository **PinjemTent**
4. Railway akan otomatis detect sebagai Laravel project

### 2.3 Add MySQL Database

1. Di project dashboard, click **"+ New"**
2. Pilih **"Database"** → **"Add MySQL"**
3. Railway akan provision MySQL database
4. Copy database credentials

---

## ⚙️ Step 3: Environment Configuration

### 3.1 Set Environment Variables

Di Railway dashboard → **Variables** tab, tambahkan:

```bash
# App Configuration
APP_NAME="PinjemTent"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (dari MySQL addon)
DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=6543
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=YOUR_DB_PASSWORD

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Mail Configuration (opsional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="PinjemTent"

# File Storage
FILESYSTEM_DISK=public

# Security
BCRYPT_ROUNDS=12
```

### 3.2 Generate APP_KEY

Jika belum punya APP_KEY, generate dengan:

```bash
php artisan key:generate --show
```

---

## 📦 Step 4: Database Migration

### 4.1 Automatic Migration

Railway akan otomatis run migration saat deploy dengan command:

```bash
php artisan migrate --force
```

### 4.2 Seed Database (Opsional)

Jika ingin seed data, tambahkan ke start command di `railway.json`:

```json
{
    "deploy": {
        "startCommand": "php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT"
    }
}
```

---

## 🔧 Step 5: File Storage Configuration

### 5.1 Update Filesystem Config

Edit `config/filesystems.php`:

```php
'default' => env('FILESYSTEM_DISK', 'public'),

'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
        'throw' => false,
    ],
],
```

### 5.2 Storage Link

Tambahkan ke build command di `nixpacks.toml`:

```toml
[phases.build]
cmds = [
    'php artisan storage:link',
    'php artisan config:cache',
    'php artisan route:cache',
    'php artisan view:cache'
]
```

---

## 🌐 Step 6: Domain Configuration

### 6.1 Custom Domain (Opsional)

1. Di Railway dashboard → **Settings** tab
2. Scroll ke **Domains** section
3. Click **"Generate Domain"** atau **"Custom Domain"**
4. Update `APP_URL` environment variable

### 6.2 Update CORS & Session

Edit `config/cors.php`:

```php
'allowed_origins' => [
    env('APP_URL'),
    'https://your-custom-domain.com'
],
```

---

## 🔒 Step 7: Security Configuration

### 7.1 Update Trusted Proxies

Edit `app/Http/Middleware/TrustProxies.php`:

```php
protected $proxies = '*';

protected $headers =
    Request::HEADER_X_FORWARDED_FOR |
    Request::HEADER_X_FORWARDED_HOST |
    Request::HEADER_X_FORWARDED_PORT |
    Request::HEADER_X_FORWARDED_PROTO |
    Request::HEADER_X_FORWARDED_AWS_ELB;
```

### 7.2 Force HTTPS

Edit `app/Providers/AppServiceProvider.php`:

```php
public function boot()
{
    if (env('APP_ENV') === 'production') {
        URL::forceScheme('https');
    }
}
```

---

## 📝 Step 8: Deployment Files

### 8.1 Create `.railwayignore`

```
node_modules/
.git/
.env
.env.local
.env.production
tests/
storage/logs/
storage/framework/cache/
storage/framework/sessions/
storage/framework/views/
```

### 8.2 Update `.gitignore`

Pastikan file penting tidak di-ignore:

```
# Keep these for Railway
!storage/app/public/.gitkeep
!storage/framework/cache/.gitkeep
!storage/framework/sessions/.gitkeep
!storage/framework/views/.gitkeep
!storage/logs/.gitkeep
```

---

## 🚀 Step 9: Deploy Process

### 9.1 Push to GitHub

```bash
git add .
git commit -m "Add Railway deployment configuration"
git push origin main
```

### 9.2 Auto Deploy

Railway akan otomatis detect perubahan dan deploy:

1. Build process akan berjalan (~5-10 menit)
2. Database migration akan dijalankan
3. Application akan tersedia di generated URL

### 9.3 Monitor Deployment

1. Check **Deployments** tab untuk status
2. Check **Logs** tab untuk debugging
3. Check **Metrics** untuk performance

---

## 🐛 Troubleshooting

### Common Issues:

#### 1. Build Failed

```bash
# Check build logs di Railway dashboard
# Pastikan semua dependencies ada di composer.json
```

#### 2. Database Connection Error

```bash
# Verify database credentials di Variables tab
# Check DB_HOST, DB_PORT, DB_PASSWORD
```

#### 3. Storage Permission Error

```bash
# Pastikan storage link sudah dibuat
php artisan storage:link
```

#### 4. Route Cache Error

```bash
# Clear cache dengan command
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

---

## 🔍 Post-Deployment Checklist

-   [ ] Application accessible via Railway URL
-   [ ] Database connected successfully
-   [ ] File uploads working
-   [ ] Authentication working
-   [ ] Admin/User dashboards accessible
-   [ ] Email notifications working (if configured)
-   [ ] SSL certificate active
-   [ ] Custom domain configured (if applicable)

---

## 📊 Monitoring & Maintenance

### 1. Logs Monitoring

```bash
# Check application logs di Railway dashboard
# Monitor error rates dan performance
```

### 2. Database Backups

```bash
# Railway automatic backup available
# Consider external backup strategy untuk production
```

### 3. Performance Optimization

```bash
# Enable opcache untuk production
# Configure queue workers jika diperlukan
# Setup Redis untuk session/cache (optional)
```

---

## 💰 Pricing Considerations

### Railway Free Tier:

-   $5 credit per month
-   Good untuk development/testing
-   Limited resources

### Railway Pro:

-   $20/month per user
-   Unlimited projects
-   Better performance
-   Production ready

---

## 🔗 Useful Links

-   [Railway Documentation](https://docs.railway.app/)
-   [Laravel Deployment Guide](https://laravel.com/docs/10.x/deployment)
-   [Railway Laravel Template](https://railway.app/template/laravel)

---

**Happy Deploying! 🚀**
