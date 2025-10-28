# 🏕️ PinjemTent - Sistem Peminjaman Peralatan Camping

<div align="center">

![PinjemTent Logo](public/images/logo.png)

**Aplikasi Web Manajemen Penyewaan dan Peminjaman Alat Camping**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-4.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)

[Demo](#) • [Dokumentasi](#dokumentasi) • [Instalasi](#instalasi--konfigurasi) • [Kontribusi](#kontributor)

</div>

---

## 📖 Daftar Isi

-   [Informasi Umum](#-informasi-umum)
-   [Fitur Aplikasi](#-fitur-aplikasi)
-   [Teknologi](#-teknologi)
-   [Struktur Folder](#-struktur-folder)
-   [Instalasi & Konfigurasi](#-instalasi--konfigurasi)
-   [Dokumentasi Database](#-dokumentasi-database)
-   [Panduan Penggunaan](#-panduan-penggunaan)
-   [API Documentation](#-api-documentation)
-   [Testing](#-testing)
-   [Deployment](#-deployment)
-   [Kontributor](#-kontributor)
-   [Lisensi](#-lisensi)

---

## 🌟 Informasi Umum

### Nama Project

**PinjemTent - Sistem Peminjaman Peralatan Camping**

### Deskripsi

PinjemTent adalah aplikasi web berbasis Laravel yang dirancang khusus untuk mengelola sistem penyewaan dan peminjaman peralatan camping seperti tenda, kompor portable, sleeping bag, tas carrier, dan perlengkapan outdoor lainnya. Aplikasi ini menyediakan interface yang user-friendly untuk admin dan pengguna dalam mengelola inventori, transaksi peminjaman, dan pelaporan.

### Tujuan Project

-   🎯 **Mempermudah Administrasi**: Otomatisasi proses pencatatan dan pengelolaan peminjaman
-   📊 **Pelaporan Real-time**: Dashboard dan laporan yang informatif untuk monitoring bisnis
-   👥 **Multi-Role Management**: Sistem yang mendukung admin dan user dengan hak akses berbeda
-   💰 **Manajemen Finansial**: Tracking pembayaran, denda, dan laporan keuangan
-   📱 **Responsif**: Interface yang dapat diakses melalui desktop dan mobile
-   🔄 **Efisiensi Operasional**: Mengurangi kesalahan manual dan meningkatkan produktivitas

### Keunggulan

-   ✅ **Clean Architecture**: Menggunakan pattern Controller → Service → Repository
-   ✅ **Real-time Stock Management**: Tracking stok dan ketersediaan real-time
-   ✅ **Advanced Search & Filter**: Pencarian dan filter yang powerful
-   ✅ **Automated Calculations**: Perhitungan otomatis biaya sewa dan denda
-   ✅ **Responsive Design**: Optimized untuk semua device
-   ✅ **Security First**: Implementasi authentication dan authorization yang robust

---

## 🚀 Fitur Aplikasi

### 👑 Admin Features

-   **Dashboard Analytics**: Overview bisnis dengan grafik dan statistik
-   **Manajemen Unit**:
    -   CRUD peralatan camping (Tenda, Kompor, Sleeping Bag, dll)
    -   Upload gambar produk
    -   Kategorisasi dan filtering
    -   Bulk operations
-   **Manajemen Kategori**: Organisasi produk berdasarkan jenis
-   **Manajemen User**:
    -   CRUD data anggota/customer
    -   Role & permission management
    -   Profile management
-   **Manajemen Peminjaman**:
    -   Approval/reject peminjaman
    -   Tracking status real-time
    -   Perhitungan denda otomatis
    -   History dan reporting
-   **Laporan & Analytics**:
    -   Laporan keuangan
    -   Laporan stok
    -   Export ke Excel/PDF
    -   Dashboard metrics

### 👤 User Features

-   **Registrasi & Login**: Sistem authentication dengan email verification
-   **Browse Catalog**:
    -   Lihat katalog peralatan dengan gambar dan detail
    -   Advanced search dan filter
    -   Availability checker
-   **Booking System**:
    -   Pilih tanggal dan durasi peminjaman
    -   Real-time price calculation
    -   Multiple items booking
-   **Profile Management**:
    -   Update data pribadi
    -   Riwayat peminjaman
    -   Status tracking
-   **Notification System**:
    -   Email notifications
    -   In-app notifications
    -   Reminder sistem

### 🔧 System Features

-   **Authentication & Authorization**: Role-based access control
-   **Email Notifications**: Automated email untuk berbagai event
-   **File Upload**: Secure file upload dengan validation
-   **Responsive Design**: Mobile-first approach
-   **API Ready**: RESTful API endpoints
-   **Audit Trail**: Log semua aktivitas penting
-   **Backup System**: Automated database backup

---

## 🛠 Teknologi

### Backend Framework

-   **Laravel 12.x** - Modern PHP framework dengan ecosystem yang lengkap
-   **PHP 8.2+** - Latest PHP version dengan performance improvements
-   **MySQL 8.0+** - Robust relational database

### Frontend Technologies

-   **Livewire 3.x** - Full-stack framework untuk dynamic interfaces
-   **Livewire Flux** - UI component library
-   **Livewire Volt** - Single-file components
-   **TailwindCSS 4.x** - Utility-first CSS framework
-   **Alpine.js** - Lightweight JavaScript framework

### Authentication & Security

-   **Laravel Fortify** - Authentication backend
-   **Laravel Sanctum** - API token authentication
-   **CSRF Protection** - Built-in security features

### Development Tools

-   **Vite** - Fast build tool dan HMR
-   **Pest PHP** - Modern testing framework
-   **Laravel Pint** - Code styling
-   **Composer** - Dependency management

### Architecture Pattern

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Controller    │───▶│    Service      │───▶│   Repository    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│    Request      │    │   Business      │    │    Database     │
│   Validation    │    │     Logic       │    │   Operations    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

---

## 📁 Struktur Folder

```
PinjemTent/
├── 📁 app/                          # Aplikasi core
│   ├── 📁 Actions/                  # Custom actions & commands
│   │   └── 📁 Fortify/             # Authentication actions
│   ├── 📁 Helpers/                  # Helper functions & utilities
│   │   └── 📄 CurrencyHelper.php   # Formatting mata uang IDR
│   ├── 📁 Http/                     # HTTP layer
│   │   ├── 📁 Controllers/          # Request handling & flow control
│   │   │   └── 📁 Admin/           # Admin-specific controllers
│   │   ├── 📁 Middleware/           # Custom middleware
│   │   ├── 📁 Requests/             # Form request validation
│   │   │   └── 📁 Admin/           # Admin form validations
│   │   ├── 📁 Resources/            # API resource transformers
│   │   └── 📁 Responses/            # Custom response handlers
│   ├── 📁 Livewire/                 # Livewire components
│   │   └── 📁 Actions/             # Livewire action components
│   ├── 📁 Models/                   # Eloquent models (Database entities)
│   │   ├── 📄 User.php             # User model dengan roles
│   │   ├── 📄 Unit.php             # Model untuk peralatan camping
│   │   ├── 📄 Kategori.php         # Model kategorisasi
│   │   └── 📄 Peminjaman.php       # Model transaksi peminjaman
│   ├── 📁 Providers/                # Service providers
│   ├── 📁 Repositories/             # Data access layer
│   │   ├── 📄 UnitRepository.php   # Unit data operations
│   │   ├── 📄 UserRepository.php   # User data operations
│   │   └── 📄 PeminjamanRepository.php  # Peminjaman data operations
│   └── 📁 Services/                 # Business logic layer
│       └── 📁 Admin/               # Admin business services
├── 📁 bootstrap/                    # Framework bootstrap
├── 📁 config/                       # Configuration files
│   ├── 📄 app.php                  # App configuration
│   ├── 📄 database.php             # Database connection
│   ├── 📄 fortify.php              # Authentication config
│   └── 📄 mail.php                 # Email configuration
├── 📁 database/                     # Database layer
│   ├── 📁 factories/                # Model factories untuk testing
│   ├── 📁 migrations/               # Database schema migrations
│   │   ├── 📄 *_create_users_table.php        # Users table
│   │   ├── 📄 *_create_units_table.php        # Units (peralatan) table
│   │   ├── 📄 *_create_kategoris_table.php    # Categories table
│   │   ├── 📄 *_create_unit_kategori_table.php # Many-to-many pivot
│   │   ├── 📄 *_create_peminjamans_table.php  # Peminjaman transactions
│   │   └── 📄 *_add_jumlah_to_peminjamans.php # Quantity tracking
│   └── 📁 seeders/                  # Database seeders
│       ├── 📄 AdminSeeder.php      # Default admin user
│       ├── 📄 KategoriSeeder.php   # Categories data
│       ├── 📄 UnitSeeder.php       # Sample units data
│       └── 📄 TestUsersSeeder.php  # Test users untuk development
├── 📁 public/                       # Public assets
│   ├── 📁 images/                   # Image uploads & static images
│   ├── 📁 js/                       # Compiled JavaScript
│   └── 📁 css/                      # Compiled CSS
├── 📁 resources/                    # Raw assets & views
│   ├── 📁 css/                      # Source CSS files
│   ├── 📁 js/                       # Source JavaScript files
│   └── 📁 views/                    # Blade templates
│       ├── 📁 admin/                # Admin-specific views
│       │   ├── 📁 units/           # Unit management views
│       │   ├── 📁 users/           # User management views
│       │   └── 📁 peminjamans/     # Peminjaman management views
│       ├── 📁 auth/                 # Authentication views
│       └── 📁 components/           # Reusable components
├── 📁 routes/                       # Application routes
│   ├── 📄 web.php                  # Web routes
│   ├── 📄 api.php                  # API routes (jika ada)
│   └── 📄 console.php              # Artisan commands
├── 📁 storage/                      # File storage
│   ├── 📁 app/                      # Application files
│   ├── 📁 framework/                # Framework cache
│   └── 📁 logs/                     # Application logs
├── 📁 tests/                        # Unit & feature tests
│   ├── 📁 Feature/                  # Feature tests
│   └── 📁 Unit/                     # Unit tests
└── 📁 vendor/                       # Composer dependencies
```

### Penjelasan Layer Architecture

#### 🎮 Controllers

Bertanggung jawab untuk:

-   Menerima HTTP requests
-   Validasi input menggunakan Form Requests
-   Memanggil Service layer untuk business logic
-   Mengembalikan response ke user

#### 🏗 Services

Business logic layer yang menangani:

-   Orkestrasi antar repository
-   Validasi business rules
-   Complex operations & calculations
-   Transaction management

#### 💾 Repositories

Data access layer yang mengatur:

-   Interaksi langsung dengan database
-   Query optimization
-   Data caching
-   Database transactions

#### 📋 Models

Eloquent models yang merepresentasikan:

-   Database entities
-   Relationships antar tabel
-   Accessors & mutators
-   Business logic sederhana

---

## ⚙️ Instalasi & Konfigurasi

### Persyaratan Sistem

-   **PHP**: 8.2 atau lebih tinggi
-   **Composer**: Latest version
-   **Node.js**: 18.x atau lebih tinggi
-   **NPM/Yarn**: Latest version
-   **MySQL**: 8.0 atau lebih tinggi
-   **Web Server**: Apache/Nginx

### 1. Clone Repository

```bash
git clone https://github.com/Yohanpratamaa/PinjemTent.git
cd PinjemTent
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration

Edit file `.env` dan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pinjemtent_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Migration & Seeding

```bash
# Buat database (pastikan MySQL running)
mysql -u root -p -e "CREATE DATABASE pinjemtent_db;"

# Run migrations
php artisan migrate

# Seed database dengan data sample
php artisan db:seed
```

### 6. Storage Configuration

```bash
# Create storage link
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 7. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Jalankan Aplikasi

```bash
# Development server
php artisan serve

# Akses aplikasi di: http://localhost:8000
```

### 🔑 Default Login Credentials

#### Admin Account

-   **Email**: admin@pinjemtent.com
-   **Password**: admin123

#### Test User Account

-   **Email**: user@pinjemtent.com
-   **Password**: user123

### Mail Configuration (Opsional)

Untuk fitur email notifications, konfigurasi di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@pinjemtent.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🗄️ Dokumentasi Database

### Entity Relationship Diagram (ERD)

```
┌─────────────┐    ┌─────────────────┐    ┌─────────────┐
│    users    │    │   peminjamans   │    │    units    │
├─────────────┤    ├─────────────────┤    ├─────────────┤
│ id (PK)     │◄──┤ user_id (FK)    │   ┌┤ id (PK)     │
│ name        │    │ unit_id (FK)    │──►│ kode_unit   │
│ email       │    │ kode_peminjaman │   │ nama_unit   │
│ role        │    │ jumlah          │   │ merk        │
│ created_at  │    │ tanggal_pinjam  │   │ kapasitas   │
│ updated_at  │    │ tanggal_kembali │   │ status      │
└─────────────┘    │ status          │   │ stok        │
                   │ harga_total     │   │ harga_sewa  │
                   │ denda_total     │   └─────────────┘
                   │ created_at      │           │
                   │ updated_at      │           │
                   └─────────────────┘           │
                                                 │
┌─────────────────┐                             │
│ unit_kategori   │    ┌─────────────┐          │
├─────────────────┤    │ kategoris   │          │
│ unit_id (FK)    │───►│ id (PK)     │◄─────────┘
│ kategori_id(FK) │◄──┤ nama_kategori│
└─────────────────┘    │ deskripsi    │
                       │ created_at   │
                       │ updated_at   │
                       └─────────────┘
```

### Tabel Database

#### 👥 users

| Field             | Type                 | Description              |
| ----------------- | -------------------- | ------------------------ |
| id                | BIGINT (PK)          | Primary key              |
| name              | VARCHAR(255)         | Nama lengkap user        |
| email             | VARCHAR(255)         | Email unique             |
| email_verified_at | TIMESTAMP            | Tanggal verifikasi email |
| password          | VARCHAR(255)         | Hashed password          |
| role              | ENUM('admin','user') | Role user                |
| remember_token    | VARCHAR(100)         | Remember token           |
| created_at        | TIMESTAMP            | Tanggal dibuat           |
| updated_at        | TIMESTAMP            | Tanggal diupdate         |

#### 🏕️ units

| Field               | Type          | Description                        |
| ------------------- | ------------- | ---------------------------------- |
| id                  | BIGINT (PK)   | Primary key                        |
| kode_unit           | VARCHAR(255)  | Kode unik unit                     |
| nama_unit           | VARCHAR(255)  | Nama peralatan                     |
| merk                | VARCHAR(100)  | Brand/merk                         |
| kapasitas           | VARCHAR(100)  | Kapasitas (4 orang, 2 burner, dll) |
| deskripsi           | TEXT          | Deskripsi lengkap                  |
| status              | ENUM          | tersedia, dipinjam, maintenance    |
| stok                | INT           | Jumlah stok tersedia               |
| harga_sewa_per_hari | DECIMAL(10,2) | Harga sewa per hari                |
| denda_per_hari      | DECIMAL(10,2) | Denda keterlambatan                |
| harga_beli          | DECIMAL(12,2) | Harga pembelian                    |
| created_at          | TIMESTAMP     | Tanggal dibuat                     |
| updated_at          | TIMESTAMP     | Tanggal diupdate                   |

#### 📂 kategoris

| Field         | Type         | Description        |
| ------------- | ------------ | ------------------ |
| id            | BIGINT (PK)  | Primary key        |
| nama_kategori | VARCHAR(255) | Nama kategori      |
| deskripsi     | TEXT         | Deskripsi kategori |
| created_at    | TIMESTAMP    | Tanggal dibuat     |
| updated_at    | TIMESTAMP    | Tanggal diupdate   |

#### 🔄 unit_kategori (Pivot Table)

| Field       | Type        | Description            |
| ----------- | ----------- | ---------------------- |
| id          | BIGINT (PK) | Primary key            |
| unit_id     | BIGINT (FK) | Reference ke units     |
| kategori_id | BIGINT (FK) | Reference ke kategoris |

#### 📋 peminjamans

| Field                   | Type          | Description                                            |
| ----------------------- | ------------- | ------------------------------------------------------ |
| id                      | BIGINT (PK)   | Primary key                                            |
| user_id                 | BIGINT (FK)   | Reference ke users                                     |
| unit_id                 | BIGINT (FK)   | Reference ke units                                     |
| kode_peminjaman         | VARCHAR(255)  | Kode unik peminjaman                                   |
| jumlah                  | INT           | Jumlah unit dipinjam                                   |
| tanggal_pinjam          | DATE          | Tanggal mulai pinjam                                   |
| tanggal_kembali_rencana | DATE          | Tanggal rencana kembali                                |
| tanggal_kembali_aktual  | DATE          | Tanggal aktual kembali                                 |
| status                  | ENUM          | pending, dipinjam, dikembalikan, terlambat, dibatalkan |
| harga_sewa_total        | DECIMAL(12,2) | Total biaya sewa                                       |
| denda_total             | DECIMAL(12,2) | Total denda                                            |
| total_bayar             | DECIMAL(12,2) | Total yang harus dibayar                               |
| catatan_peminjam        | TEXT          | Catatan dari peminjam                                  |
| catatan_admin           | TEXT          | Catatan dari admin                                     |
| created_at              | TIMESTAMP     | Tanggal dibuat                                         |
| updated_at              | TIMESTAMP     | Tanggal diupdate                                       |

### Sample Data

Aplikasi sudah dilengkapi dengan data sample:

-   1 Admin user dan beberapa test user
-   7 Unit peralatan camping
-   5 Kategori (Tenda Camping, Alat Masak, Tas Carrier, Sleeping Bag, Alat Navigasi)
-   Sample transaksi peminjaman dengan berbagai status

---

## 📖 Panduan Penggunaan

### 🔐 Login & Authentication

#### Untuk Admin:

1. Akses `http://localhost:8000/login`
2. Login dengan credentials admin
3. Redirect ke admin dashboard

#### Untuk User:

1. Register account baru di `/register`
2. Verifikasi email (jika diaktifkan)
3. Login dan akses user dashboard

### 👑 Admin Dashboard

#### Manajemen Unit

1. **Tambah Unit Baru**:

    - Klik "Add New Unit"
    - Isi form: kode unit, nama, merk, kapasitas, deskripsi
    - Set harga sewa dan denda
    - Pilih kategori
    - Submit

2. **Edit Unit**:

    - Klik unit dari list
    - Klik "Edit Unit"
    - Update informasi yang diperlukan
    - Save changes

3. **Monitoring Stock**:
    - Dashboard menampilkan real-time stock
    - Available stock = Total stock - Active rentals
    - Warning untuk stock rendah

#### Manajemen Peminjaman

1. **Approval Process**:

    - Review peminjaman pending
    - Check availability
    - Approve/reject dengan catatan

2. **Tracking**:
    - Monitor peminjaman aktif
    - Track overdue rentals
    - Automatic late fee calculation

### 👤 User Interface

#### Browse & Search

1. **Katalog Produk**:

    - Browse semua peralatan tersedia
    - Filter by kategori, harga, availability
    - Search by nama atau kode

2. **Detail Produk**:
    - Lihat gambar dan spesifikasi lengkap
    - Check real-time availability
    - Calculator harga otomatis

#### Booking Process

1. **Pilih Item**:

    - Select peralatan yang diinginkan
    - Set tanggal pinjam dan kembali
    - Specify quantity

2. **Review & Submit**:

    - Review total cost
    - Add notes/requirements
    - Submit booking

3. **Tracking**:
    - Monitor status approval
    - View booking history
    - Notifications

---

## 🔌 API Documentation

### Authentication

Aplikasi menggunakan session-based authentication untuk web dan token-based untuk API.

#### Login API

```http
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

### Units API

#### Get All Units

```http
GET /api/units
```

#### Get Unit Details

```http
GET /api/units/{id}
```

#### Check Availability

```http
GET /api/units/{id}/availability?start_date=2023-12-01&end_date=2023-12-05
```

### Peminjamans API

#### Create Booking

```http
POST /api/peminjamans
Content-Type: application/json

{
    "unit_id": 1,
    "jumlah": 2,
    "tanggal_pinjam": "2023-12-01",
    "tanggal_kembali_rencana": "2023-12-05",
    "catatan_peminjam": "Untuk acara camping keluarga"
}
```

---

## 🧪 Testing

### Menjalankan Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/UnitTest.php

# Run with coverage
php artisan test --coverage
```

### Test Categories

-   **Unit Tests**: Test individual methods/functions
-   **Feature Tests**: Test complete features end-to-end
-   **Browser Tests**: Automated browser testing (jika ada)

### Sample Tests

-   Authentication flow
-   Unit CRUD operations
-   Peminjaman creation & approval
-   Stock calculation accuracy
-   Email notifications

---

## 🚀 Deployment

### Production Setup

#### 1. Server Requirements

-   **OS**: Ubuntu 20.04+ / CentOS 8+
-   **Web Server**: Nginx atau Apache
-   **PHP**: 8.2+ dengan extensions
-   **Database**: MySQL 8.0+
-   **SSL Certificate**: Let's Encrypt/Commercial

#### 2. Environment Configuration

```bash
# Production environment
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=pinjemtent_prod
DB_USERNAME=prod_user
DB_PASSWORD=secure_password

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

#### 3. Optimization Commands

```bash
# Clear dan cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Build production assets
npm run build
```

#### 4. Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/PinjemTent/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Docker Deployment

```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application
COPY . /var/www

# Install dependencies
RUN composer install

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
```

---

## 👥 Kontributor

### 🎯 Tim Pengembang

**Nama Kelompok**: YAP (Yohan Andri Pratama)

#### 🏆 Project Leader & Full-Stack Developer

**Yohan Pratama**

-   📧 **Email**: [yohan.pratama@example.com](mailto:yohan.pratama@example.com)
-   🐙 **GitHub**: [@Yohanpratamaa](https://github.com/Yohanpratamaa)
-   💼 **LinkedIn**: [Yohan Pratama](https://linkedin.com/in/yohanpratama)
-   🎯 **Role**:
    -   Project Architecture & Planning
    -   Backend Development (Laravel)
    -   Frontend Development (Livewire + TailwindCSS)
    -   Database Design & Optimization
    -   DevOps & Deployment
    -   Code Review & Quality Assurance

#### 🏅 Kontribusi Utama

-   ✨ **Backend Architecture**: Implementasi Clean Architecture dengan pattern Controller-Service-Repository
-   🎨 **Frontend Development**: Responsive UI dengan Livewire dan TailwindCSS
-   🗄️ **Database Design**: Perancangan ERD dan optimasi query
-   🔐 **Authentication System**: Multi-role authentication dengan Laravel Fortify
-   📊 **Dashboard & Analytics**: Real-time monitoring dan reporting system
-   🧪 **Testing**: Unit testing dan feature testing dengan Pest PHP
-   📝 **Documentation**: Comprehensive README dan code documentation

### 🤝 Cara Berkontribusi

Kami menyambut kontribusi dari komunitas! Berikut cara untuk berkontribusi:

#### 1. Fork Repository

```bash
# Fork repo di GitHub
# Clone fork ke local
git clone https://github.com/your-username/PinjemTent.git
cd PinjemTent
git remote add upstream https://github.com/Yohanpratamaa/PinjemTent.git
```

#### 2. Buat Feature Branch

```bash
git checkout -b feature/amazing-feature
```

#### 3. Development Guidelines

-   Ikuti PSR-12 coding standards
-   Tulis tests untuk fitur baru
-   Update documentation jika diperlukan
-   Commit dengan pesan yang jelas

#### 4. Submit Pull Request

-   Push branch ke fork repository
-   Buat Pull Request dengan deskripsi lengkap
-   Link ke issue yang terkait (jika ada)

### 📋 Contribution Guidelines

#### Code Quality

-   ✅ PSR-12 compliance
-   ✅ Unit tests coverage > 80%
-   ✅ No breaking changes tanpa major version bump
-   ✅ Documentation update untuk API changes

#### Commit Messages

```
feat: add user notification system
fix: resolve stock calculation bug
docs: update API documentation
test: add peminjaman creation tests
refactor: optimize database queries
```

#### Issue Templates

-   🐛 Bug Report
-   ✨ Feature Request
-   📖 Documentation
-   ❓ Question

---

## 📄 Lisensi

### MIT License

```
MIT License

Copyright (c) 2025 YAP Team - Yohan Pratama

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

### 🔓 Open Source

Proyek ini bersifat open source dan dapat digunakan untuk:

-   ✅ Penggunaan komersial
-   ✅ Modifikasi dan distribusi
-   ✅ Penggunaan pribadi
-   ✅ Patent use

### 📚 Third-Party Licenses

-   **Laravel Framework**: MIT License
-   **Livewire**: MIT License
-   **TailwindCSS**: MIT License
-   **MySQL**: GPL License

---

## 📞 Support & Contact

### 🆘 Bantuan & Dukungan

-   📖 **Documentation**: [GitHub Wiki](https://github.com/Yohanpratamaa/PinjemTent/wiki)
-   🐛 **Bug Reports**: [GitHub Issues](https://github.com/Yohanpratamaa/PinjemTent/issues)
-   💬 **Discussions**: [GitHub Discussions](https://github.com/Yohanpratamaa/PinjemTent/discussions)
-   📧 **Email**: support@pinjemtent.com

### 🌟 Acknowledgments

-   Laravel Team untuk framework yang amazing
-   Livewire Team untuk reactive components
-   TailwindCSS Team untuk utility-first CSS
-   Komunitas open source yang telah berkontribusi

---

<div align="center">

### 🎉 Terima Kasih Telah Menggunakan PinjemTent!

**Made with ❤️ by YAP Team**

[⭐ Star this repo](https://github.com/Yohanpratamaa/PinjemTent) • [🐛 Report Bug](https://github.com/Yohanpratamaa/PinjemTent/issues) • [✨ Request Feature](https://github.com/Yohanpratamaa/PinjemTent/issues)

[![GitHub stars](https://img.shields.io/github/stars/Yohanpratamaa/PinjemTent?style=social)](https://github.com/Yohanpratamaa/PinjemTent/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/Yohanpratamaa/PinjemTent?style=social)](https://github.com/Yohanpratamaa/PinjemTent/network/members)

</div>
