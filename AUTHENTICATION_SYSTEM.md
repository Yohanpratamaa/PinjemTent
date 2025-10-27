# Sistem Autentikasi PinjemTent

## 📋 Overview

Sistem autentikasi yang dikembangkan menggunakan **Clean Architecture** dengan **Laravel Fortify** sebagai foundation. Sistem ini mendukung dua role utama: **Admin** dan **User**.

## 🏗️ Arsitektur

### 1. Models

-   `User.php` - Model utama dengan role-based methods:
    -   `isAdmin()` - Check apakah user adalah admin
    -   `isUser()` - Check apakah user adalah pengguna biasa

### 2. Controllers (Clean Architecture)

```
app/Http/Controllers/
├── Auth/
│   ├── LoginController.php     # Menangani login
│   └── RegisterController.php  # Menangani registrasi user
├── Admin/
│   └── DashboardController.php # Dashboard admin
└── User/
    └── DashboardController.php # Dashboard user
```

### 3. Middleware

-   `IsAdmin` - Middleware untuk proteksi route admin
-   `IsUser` - Middleware untuk proteksi route user

### 4. Custom Responses

```
app/Http/Responses/
├── LoginResponse.php    # Custom redirect setelah login
└── RegisterResponse.php # Custom redirect setelah register
```

## 🔐 Ketentuan Autentikasi

### Role: Admin

-   ❌ **Tidak bisa register** melalui web
-   ✅ **Login** menggunakan akun yang sudah dibuat via Seeder
-   🏠 **Redirect** ke `/admin/dashboard` setelah login
-   🛡️ **Middleware**: `isAdmin`

### Role: User

-   ✅ **Bisa register dan login** melalui web
-   🎯 **Role default** otomatis `user` setelah register
-   🏠 **Redirect** ke `/user/dashboard` setelah login/register
-   🛡️ **Middleware**: `isUser`

## 🗄️ Database

### Migration

```sql
-- Kolom role ditambahkan ke tabel users
ALTER TABLE users ADD COLUMN role VARCHAR(255) DEFAULT 'user' AFTER email;
```

### Seeder

**AdminSeeder** membuat akun admin default:

-   Email: `admin@pinjemtent.com`
-   Password: `password`
-   Role: `admin`

## 🛤️ Routes

### Authentication Routes

```php
GET  /login      # Form login
POST /login      # Proses login
GET  /register   # Form register (hanya untuk user)
POST /register   # Proses register (hanya untuk user)
POST /logout     # Logout
```

### Protected Routes

```php
# Admin Routes (middleware: auth, isAdmin)
GET /admin/dashboard

# User Routes (middleware: auth, isUser)
GET /user/dashboard

# Legacy route (redirects based on role)
GET /dashboard   # Auto redirect berdasarkan role
```

## 🎨 Views

### Structure

```
resources/views/
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── admin/
│   └── dashboard.blade.php
└── user/
    └── dashboard.blade.php
```

## 🧪 Testing & Demo

### 1. Testing Admin Login

```
URL: http://localhost:8000/login
Email: admin@pinjemtent.com
Password: password
Expected: Redirect ke /admin/dashboard
```

### 2. Testing User Registration

```
URL: http://localhost:8000/register
Isi form pendaftaran baru
Expected: Auto login dan redirect ke /user/dashboard
```

### 3. Testing User Login

```
URL: http://localhost:8000/login
Gunakan akun user yang sudah didaftarkan
Expected: Redirect ke /user/dashboard
```

### 4. Testing Middleware Protection

```
# Test akses tanpa login
URL: http://localhost:8000/admin/dashboard
Expected: 403 Unauthorized

# Test akses user ke admin area
Login sebagai user, lalu akses /admin/dashboard
Expected: 403 Unauthorized
```

## 📁 File Structure (Clean Architecture)

```
app/
├── Actions/Fortify/
│   └── CreateNewUser.php          # Handle user creation
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   └── RegisterController.php
│   │   ├── Admin/
│   │   │   └── DashboardController.php
│   │   └── User/
│   │       └── DashboardController.php
│   ├── Middleware/
│   │   ├── IsAdmin.php
│   │   └── IsUser.php
│   └── Responses/
│       ├── LoginResponse.php
│       └── RegisterResponse.php
├── Models/
│   └── User.php
└── Providers/
    ├── AppServiceProvider.php
    └── FortifyServiceProvider.php
```

## 🚀 Commands untuk Setup

```bash
# 1. Jalankan migration
php artisan migrate

# 2. Jalankan seeder untuk admin
php artisan db:seed --class=AdminSeeder

# 3. Jalankan server
php artisan serve

# 4. Akses aplikasi
http://localhost:8000
```

## 🔧 Konfigurasi Penting

### 1. Middleware Registration (bootstrap/app.php)

```php
$middleware->alias([
    'isAdmin' => \App\Http\Middleware\IsAdmin::class,
    'isUser' => \App\Http\Middleware\IsUser::class,
]);
```

### 2. Custom Response Binding (AppServiceProvider.php)

```php
$this->app->singleton(LoginResponseContract::class, LoginResponse::class);
$this->app->singleton(RegisterResponseContract::class, RegisterResponse::class);
```

### 3. Fortify Views Configuration (FortifyServiceProvider.php)

```php
Fortify::loginView(fn () => view('livewire.auth.login'));
Fortify::registerView(fn () => view('livewire.auth.register'));
```

## ✅ Features

-   ✅ Role-based authentication (Admin/User)
-   ✅ Clean Architecture pattern
-   ✅ Custom redirects based on role
-   ✅ Middleware protection
-   ✅ Seeded admin accounts
-   ✅ User registration with auto role assignment
-   ✅ Responsive UI dengan Flux components
-   ✅ Session management
-   ✅ Password hashing
-   ✅ Form validation

## 🛡️ Security Features

-   ✅ CSRF Protection
-   ✅ Password hashing (bcrypt)
-   ✅ Session regeneration after login
-   ✅ Role-based access control
-   ✅ Middleware protection
-   ✅ Input validation
-   ✅ Rate limiting (via Fortify)

## 🎯 Next Steps

1. **User Management**: CRUD untuk admin mengelola user
2. **Profile Management**: User dapat update profile
3. **Password Reset**: Implementasi forgot password
4. **Two-Factor Authentication**: Keamanan tambahan
5. **Audit Logs**: Tracking aktivitas user
6. **API Authentication**: Sanctum untuk mobile/SPA
