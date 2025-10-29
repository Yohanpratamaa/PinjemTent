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

### 🎯 Keunggulan Aplikasi

-   ✅ **Clean Architecture**: Pattern Controller → Service → Repository untuk maintainability
-   ✅ **Real-time Stock Management**: Tracking stok dan ketersediaan real-time dengan validasi
-   ✅ **Advanced Search & Filter**: Pencarian powerful dengan multiple filter options
-   ✅ **Automated Calculations**: Perhitungan otomatis biaya sewa, durasi, dan denda keterlambatan
-   ✅ **Shopping Cart System**: Keranjang belanja lengkap dengan validation dan checkout
-   ✅ **Responsive Design**: Optimized untuk desktop, tablet, dan mobile devices
-   ✅ **Security First**: Multi-layer security dengan authentication dan authorization
-   ✅ **User-Friendly Interface**: UI/UX yang intuitif dengan feedback real-time
-   ✅ **Notification System**: Sistem notifikasi untuk admin dan user
-   ✅ **Data Integrity**: Comprehensive validation dan error handling
-   ✅ **Scalable Architecture**: Modular design untuk future development

---

## 🚀 Fitur Aplikasi

### 👑 Admin Features

#### 📊 Dashboard & Analytics

-   **Dashboard Analytics**: Overview bisnis dengan statistik real-time
-   **Summary Cards**: Total unit, stok tersedia, dan barang disewa
-   **Monthly Rentals Chart**: Grafik penyewaan per bulan (12 bulan terakhir)
-   **Category Rentals Chart**: Grafik kategori paling banyak disewa
-   **Quick Actions Panel**: Akses cepat ke fitur administrasi

#### 🏕️ Manajemen Unit (Inventory)

-   **CRUD Operations**: Create, Read, Update, Delete unit peralatan camping
-   **Upload Foto Produk**: Fitur upload dan preview gambar unit
-   **Kategorisasi Multiple**: Satu unit bisa masuk ke beberapa kategori
-   **Advanced Search & Filter**: Pencarian by nama, kode, status, dan kategori
-   **Stock Management**: Tracking stok tersedia, dipinjam, dan maintenance
-   **Pricing Control**: Set harga sewa per hari dan denda keterlambatan
-   **Unit Status**: Tersedia, dipinjam, maintenance
-   **Bulk Operations**: Edit multiple units sekaligus

#### 📂 Manajemen Kategori

-   **CRUD Kategori**: Tambah, edit, hapus kategori peralatan
-   **Kategori dengan Deskripsi**: Setiap kategori memiliki deskripsi lengkap
-   **Many-to-Many Relationship**: Unit bisa masuk multiple kategori

#### 👥 Manajemen User

-   **CRUD Users**: Tambah, edit, view, hapus user
-   **Role Management**: Admin dan User dengan akses berbeda
-   **User Statistics**: Total users, admin count, user count
-   **User Search**: Pencarian by nama, email, role
-   **User Profile Details**: Informasi lengkap user termasuk history peminjaman
-   **Security**: Password hashing dan validation

#### 📋 Manajemen Peminjaman

-   **Approval System**: Approve/reject peminjaman dari user
-   **Real-time Status Tracking**: Pending, disetujui, dipinjam, dikembalikan, terlambat, dibatalkan
-   **Rental Approval Flow**: Sistem persetujuan berlapis dengan notification
-   **Return Request Management**: Kelola permintaan pengembalian dari user
-   **Advanced Filtering**: Filter by status, tanggal, user, unit
-   **Late Fee Calculation**: Perhitungan denda otomatis untuk keterlambatan
-   **Detailed Rental Info**: View lengkap semua detail peminjaman
-   **Financial Tracking**: Track total biaya, denda, dan pembayaran

#### 🔔 Notification System (Admin)

-   **Real-time Notifications**: Notifikasi langsung untuk aktivitas penting
-   **Rental Request Alerts**: Notifikasi saat ada permintaan penyewaan baru
-   **Return Request Alerts**: Notifikasi saat user minta pengembalian
-   **Notification Management**: Mark as read, mark all as read
-   **Action Buttons**: Quick approve/reject dari notification

### 👤 User Features

#### 🔐 Authentication & Profile

-   **User Registration**: Pendaftaran akun baru dengan validasi
-   **Login System**: Login dengan email dan password
-   **Profile Management**: Update nama, email, dan informasi pribadi
-   **Role-based Redirect**: Auto redirect ke dashboard sesuai role

#### 🏕️ Browse & Search Catalog

-   **Tent Catalog**: Browse semua peralatan camping tersedia
-   **Advanced Search**: Pencarian by nama unit dengan live search
-   **Category Filter**: Filter produk berdasarkan kategori
-   **Real-time Availability**: Check stok tersedia real-time
-   **Featured Products**: Tampilan produk unggulan di dashboard
-   **Product Images**: Galeri foto untuk setiap unit
-   **Detailed Specifications**: Info lengkap merk, kapasitas, deskripsi

#### 🛒 Shopping Cart System

-   **Add to Cart**: Tambah produk ke keranjang dengan quantity dan tanggal
-   **Cart Management**: Edit quantity, tanggal, dan notes dalam keranjang
-   **Real-time Price Calculator**: Hitung otomatis total biaya berdasarkan durasi
-   **Cart Validation**: Validasi stok dan tanggal sebelum checkout
-   **Remove Items**: Hapus item individual atau kosongkan keranjang
-   **Order Summary**: Ringkasan pesanan dengan breakdown harga
-   **Checkout Process**: Convert keranjang menjadi rental request

#### 📅 Booking & Rental System

-   **Date Selection**: Pilih tanggal mulai dan selesai penyewaan
-   **Quantity Management**: Tentukan jumlah unit yang ingin disewa
-   **Duration Calculator**: Hitung otomatis durasi dan total biaya
-   **Rental Notes**: Tambah catatan khusus untuk admin
-   **Instant Booking**: Add to cart langsung atau form booking detail
-   **Availability Check**: Validasi stok tersedia untuk tanggal yang dipilih
-   **Multiple Item Booking**: Sewa beberapa item sekaligus dalam satu transaksi

#### 📊 Rental History & Tracking

-   **Complete Rental History**: Riwayat lengkap semua penyewaan
-   **Status Tracking**: Monitor status real-time (pending, disetujui, dipinjam, dll)
-   **Advanced Filter**: Filter by status, tanggal, dan keyword
-   **Rental Statistics**: Total rentals, pending, completed, cancelled
-   **Detailed View**: Info lengkap setiap transaksi termasuk timeline
-   **Cancel Rental**: Batalkan penyewaan yang belum disetujui
-   **Return Request**: Request pengembalian untuk rental aktif
-   **Invoice Generation**: Generate dan download invoice PDF
-   **Quick Actions**: Sewa lagi, lihat unit, kontak support

#### 🔔 Notification & Communication

-   **Return Request System**: Request pengembalian dengan pesan ke admin
-   **Status Updates**: Notifikasi perubahan status peminjaman
-   **Approval Notifications**: Info real-time approval/rejection
-   **Late Fee Alerts**: Notifikasi denda keterlambatan
-   **Communication Tools**: Sistem pesan dengan admin

### 🔧 System Features

#### 🔐 Authentication & Security

-   **Laravel Fortify**: Robust authentication system
-   **Role-based Access Control**: Admin dan User dengan hak akses berbeda
-   **Session Management**: Secure session handling
-   **Password Hashing**: Bcrypt password encryption
-   **CSRF Protection**: Built-in security protection
-   **Form Request Validation**: Server-side validation untuk semua input

#### 📱 User Experience

-   **Responsive Design**: Mobile-first approach dengan TailwindCSS
-   **Dark/Light Mode**: Toggle tema sesuai preferensi user
-   **Real-time Feedback**: Toast notifications dan alerts
-   **Interactive Components**: Livewire reactive components
-   **Progressive Enhancement**: Alpine.js untuk interaktivitas
-   **Accessible UI**: ARIA labels dan keyboard navigation

#### 💾 Database & Performance

-   **Optimized Queries**: Efficient database operations dengan indexing
-   **Relationship Management**: Eloquent ORM relationships
-   **Migration System**: Version control untuk database schema
-   **Seeding**: Data sample untuk development dan testing
-   **Soft Deletes**: Safe data removal (jika diimplementasikan)
-   **Query Optimization**: Eager loading dan query caching

#### 🔄 Business Logic

-   **Stock Management**: Real-time inventory tracking
-   **Automated Calculations**: Price, duration, dan late fee calculation
-   **Status Workflow**: Comprehensive rental status management
-   **Data Validation**: Multi-layer validation (client & server)
-   **Error Handling**: Graceful error management dengan logging
-   **Transaction Safety**: Database transactions untuk data integrity

#### 📊 Reporting & Analytics

-   **Dashboard Metrics**: Real-time business statistics
-   **Chart Visualizations**: Chart.js untuk data visualization
-   **Export Functionality**: PDF invoice generation
-   **Audit Trail**: Log aktivitas penting (via Laravel logs)
-   **Performance Monitoring**: Query performance tracking

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
│ id (PK)     │◄── ┤ user_id (FK)    │   ┌┤ id (PK)     │
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
└─────────────────┘    │ deskripsi   │
                       │ created_at  │
                       │ updated_at  │
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
| foto                | VARCHAR(255)  | Path file foto unit                |
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
| rental_status           | ENUM          | pending, approved, rejected (approval workflow)        |
| rental_approved_at      | TIMESTAMP     | Tanggal approval                                       |
| rental_approved_by      | BIGINT (FK)   | Admin yang approve                                     |
| rental_rejection_reason | TEXT          | Alasan rejection (jika ditolak)                        |
| return_status           | ENUM          | not_requested, requested, approved, rejected           |
| return_requested_at     | TIMESTAMP     | Tanggal request return                                 |
| return_message          | TEXT          | Pesan return dari user                                 |
| approved_return_at      | TIMESTAMP     | Tanggal approval return                                |
| approved_by             | BIGINT (FK)   | Admin yang approve return                              |
| harga_sewa_total        | DECIMAL(12,2) | Total biaya sewa                                       |
| denda                   | DECIMAL(10,2) | Denda per hari                                         |
| hari_terlambat          | INT           | Jumlah hari terlambat                                  |
| keterangan_denda        | TEXT          | Keterangan denda                                       |
| denda_total             | DECIMAL(12,2) | Total denda                                            |
| total_bayar             | DECIMAL(12,2) | Total yang harus dibayar                               |
| catatan_peminjam        | TEXT          | Catatan dari peminjam                                  |
| catatan_admin           | TEXT          | Catatan dari admin                                     |
| created_at              | TIMESTAMP     | Tanggal dibuat                                         |
| updated_at              | TIMESTAMP     | Tanggal diupdate                                       |

#### 🛒 carts

| Field           | Type          | Description                     |
| --------------- | ------------- | ------------------------------- |
| id              | BIGINT (PK)   | Primary key                     |
| user_id         | BIGINT (FK)   | Reference ke users              |
| unit_id         | BIGINT (FK)   | Reference ke units              |
| quantity        | INT           | Jumlah unit dalam cart          |
| tanggal_mulai   | DATE          | Tanggal mulai sewa              |
| tanggal_selesai | DATE          | Tanggal selesai sewa            |
| notes           | TEXT          | Catatan tambahan                |
| harga_per_hari  | DECIMAL(10,2) | Harga per hari saat add to cart |
| total_harga     | DECIMAL(10,2) | Total harga calculated          |
| created_at      | TIMESTAMP     | Tanggal dibuat                  |
| updated_at      | TIMESTAMP     | Tanggal diupdate                |

#### 🔔 notifications

| Field                 | Type         | Description                           |
| --------------------- | ------------ | ------------------------------------- |
| id                    | BIGINT (PK)  | Primary key                           |
| type                  | VARCHAR(255) | Tipe notifikasi (rental_request, etc) |
| user_id               | BIGINT (FK)  | User yang trigger notification        |
| peminjaman_id         | BIGINT (FK)  | Reference ke peminjamans              |
| title                 | VARCHAR(255) | Judul notification                    |
| message               | TEXT         | Isi message                           |
| data                  | JSON         | Additional data (serialized)          |
| read_at               | TIMESTAMP    | Tanggal dibaca                        |
| is_admin_notification | BOOLEAN      | Apakah untuk admin atau user          |
| created_at            | TIMESTAMP    | Tanggal dibuat                        |
| updated_at            | TIMESTAMP    | Tanggal diupdate                      |

### Sample Data

Aplikasi sudah dilengkapi dengan data sample melalui seeder:

#### 🔑 Default Accounts

-   **Admin**: admin@pinjemtent.com / admin123
-   **Test User**: user@pinjemtent.com / user123

#### 🏕️ Sample Units (7 items)

-   **Tenda Camping**: Great Outdoor, Consina, Rei, dan Eiger
-   **Sleeping Bag**: Carrier dan sleeping equipment
-   **Tas Carrier**: Berbagai ukuran dan brand

#### 📂 Kategori (5 categories)

-   Tenda Camping
-   Alat Masak
-   Tas Carrier
-   Sleeping Bag
-   Alat Navigasi

#### 🔄 System Tables

-   Cache tables untuk performance
-   Job tables untuk queue system
-   Session management tables
-   Failed jobs tracking

#### 📊 Sample Transactions

-   Demo rental transactions dengan berbagai status
-   Sample notifications untuk testing
-   Cart items untuk demo shopping experience

---

## 📖 Panduan Penggunaan

### 🔐 Login & Authentication

#### Untuk Admin:

1. Akses `http://localhost:8000/login`
2. Login dengan credentials admin (admin@pinjemtent.com / admin123)
3. Auto redirect ke admin dashboard

#### Untuk User:

1. Register account baru di `/register` atau login existing account
2. Login dengan email dan password
3. Auto redirect ke user dashboard

### 👑 Admin Dashboard

#### 📊 Dashboard Overview

-   **Summary Cards**: View total unit, stok tersedia, dan barang disewa
-   **Monthly Chart**: Grafik penyewaan 12 bulan terakhir
-   **Category Chart**: Kategori paling banyak disewa
-   **Quick Actions**: Akses cepat ke manajemen user dan system logs

#### 🏕️ Manajemen Unit

1. **Tambah Unit Baru**:

    - Navigate ke "Units" → "Add New Unit"
    - Isi form: kode unit (unique), nama, merk, kapasitas
    - Upload foto unit (optional)
    - Set harga sewa per hari dan denda keterlambatan
    - Pilih kategori (multiple selection)
    - Set stok dan status (tersedia/maintenance)

2. **Edit Unit**:

    - Klik unit dari list atau search
    - Klik "Edit" button
    - Update informasi, foto, atau kategori
    - Save changes

3. **Stock Monitoring**:
    - Dashboard menampilkan real-time stock
    - Available stock = Total stock - Active rentals
    - Color-coded status indicators

#### 📋 Manajemen Peminjaman

1. **Approval Process**:

    - View semua rental requests di "Rentals"
    - Filter by status: pending, approved, rejected
    - Click "View Details" untuk info lengkap
    - Approve/reject dengan catatan admin

2. **Tracking & Monitoring**:

    - Monitor peminjaman aktif real-time
    - View rental history dan statistics
    - Automatic late fee calculation untuk overdue rentals
    - Status tracking: pending → approved → dipinjam → dikembalikan

3. **Return Management**:
    - Process return requests dari users
    - Approve/reject return requests
    - Update actual return date
    - Calculate final fees including late charges

#### 👥 User Management

1. **View Users**: List semua user dengan search dan filter
2. **Add User**: Create user baru dengan role assignment
3. **Edit User**: Update profile, role, atau status
4. **User Details**: View rental history dan statistics per user

#### 🔔 Notification Center

-   Real-time notifications untuk rental requests
-   Return request alerts
-   Quick action buttons (approve/reject)
-   Mark as read/unread functionality

### 👤 User Interface

#### 🏠 User Dashboard

-   **Welcome Section**: Personal greeting dan user info
-   **Featured Tents**: Produk unggulan yang tersedia
-   **Solo Gear**: Kategori khusus untuk traveler solo
-   **Quick Navigation**: Access ke sewa produk dan riwayat

#### 🏕️ Browse & Search Tents

1. **Catalog Browsing**:

    - View semua tents tersedia dengan foto
    - Grid layout dengan product cards
    - Real-time availability status
    - Price information per day

2. **Search & Filter**:

    - Live search by nama unit
    - Filter by kategori (dropdown)
    - Availability filter
    - Sort by price, name, atau popularity

3. **Product Details**:
    - Full product information (nama, merk, kapasitas)
    - High-quality product images
    - Pricing breakdown (sewa + denda)
    - Real-time stock availability
    - Related categories

#### 🛒 Shopping Cart Experience

1. **Add to Cart**:

    - Pilih quantity (within stock limits)
    - Set tanggal mulai dan selesai
    - Add optional notes
    - Real-time price calculation

2. **Cart Management**:

    - View semua items dalam cart
    - Edit quantity, dates, atau notes
    - Remove individual items
    - Clear entire cart
    - Order summary dengan total

3. **Checkout Process**:
    - Review order summary
    - Validate all items dan dates
    - Convert cart items ke rental requests
    - Submit untuk admin approval

#### 📅 Rental Process

1. **Direct Booking**:

    - Dari product detail page
    - Quick add to cart dengan default dates
    - Atau detail booking form

2. **Form Booking**:
    - Comprehensive rental form
    - Date picker dengan validation
    - Quantity selection (stock-limited)
    - Notes untuk admin
    - Terms & conditions

#### 📊 Rental History & Management

1. **History Overview**:

    - Complete rental history dengan statistics
    - Filter by status, date range, atau keyword
    - Pagination untuk large datasets
    - Export functionality (future feature)

2. **Rental Tracking**:

    - Real-time status updates
    - Timeline view untuk setiap rental
    - Late fee calculations (automatic)
    - Action buttons (cancel, return request)

3. **Rental Details**:

    - Comprehensive rental information
    - Unit details dengan foto
    - Financial breakdown
    - Admin notes dan communications
    - Invoice download (PDF)

4. **User Actions**:
    - Cancel pending rentals
    - Request early return
    - Contact admin via notes
    - Rate rental experience (future feature)

#### 🔔 Notifications & Communication

-   Real-time status updates
-   Return request confirmations
-   Late fee notifications
-   Admin approval/rejection alerts

### 💡 Tips Penggunaan

#### Untuk Admin:

-   Regular monitoring dashboard untuk business insights
-   Quick approval/rejection via notification center
-   Use advanced filters untuk efficient rental management
-   Monitor stock levels untuk inventory planning

#### Untuk User:

-   Browse featured items di dashboard untuk deals terbaik
-   Use cart system untuk multiple item bookings
-   Check availability dates sebelum add to cart
-   Monitor rental status via history page
-   Submit return requests sebelum due date untuk avoid late fees

---

## 🔌 API Documentation

### Authentication

Aplikasi menggunakan session-based authentication untuk web interface. API endpoints tersedia untuk integrasi external.

#### Routes Overview

**Admin Routes** (`/admin/*` - requires admin role):

```php
/admin/dashboard          # Admin dashboard
/admin/units             # Unit management (CRUD)
/admin/kategoris         # Category management
/admin/users             # User management
/admin/peminjamans       # Rental management
/admin/notifications     # Notification management
```

**User Routes** (`/user/*` - requires user role):

```php
/user/dashboard          # User dashboard
/user/tents             # Browse tents catalog
/user/cart              # Shopping cart management
/user/rental-history    # Rental history & tracking
```

### Cart API Endpoints

#### Add to Cart

```http
POST /user/cart/add
Content-Type: application/json
X-CSRF-TOKEN: {token}

{
    "unit_id": 1,
    "quantity": 2,
    "tanggal_mulai": "2025-11-01",
    "tanggal_selesai": "2025-11-05",
    "notes": "Untuk camping keluarga"
}

Response:
{
    "success": true,
    "message": "Item berhasil ditambahkan ke keranjang!",
    "cart_count": 3,
    "cart_item": {...}
}
```

#### Update Cart Item

```http
PUT /user/cart/{cartId}
Content-Type: application/json

{
    "quantity": 3,
    "tanggal_mulai": "2025-11-02",
    "tanggal_selesai": "2025-11-06",
    "notes": "Updated notes"
}
```

#### Remove from Cart

```http
DELETE /user/cart/{cartId}

Response:
{
    "success": true,
    "message": "Item berhasil dihapus dari keranjang!",
    "cart_count": 2
}
```

#### Get Cart Count

```http
GET /user/cart/count

Response:
{
    "count": 3
}
```

### Rental Management API

#### Checkout Cart

```http
POST /user/cart/checkout

Response: Redirect to rental history with success message
```

#### Cancel Rental

```http
PATCH /user/rental-history/{rentalId}/cancel

Response: Redirect with status update
```

#### Request Return

```http
POST /user/rental-history/{rentalId}/request-return
Content-Type: application/json

{
    "return_message": "Barang sudah tidak digunakan"
}
```

### Admin API Endpoints

#### Approve/Reject Rental

```http
POST /admin/notifications/{notificationId}/approve-rental
POST /admin/notifications/{notificationId}/reject-rental

{
    "rejection_reason": "Stock tidak tersedia" // untuk reject
}
```

#### Notification Management

```http
PUT /admin/notifications/{notificationId}/read
POST /admin/notifications/mark-all-read
```

### Response Format

Semua API responses menggunakan format JSON standard:

**Success Response:**

```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {...}
}
```

**Error Response:**

```json
{
    "success": false,
    "message": "Error description",
    "errors": {...} // validation errors if any
}
```

### Error Handling

-   `400` - Bad Request (validation errors)
-   `401` - Unauthorized (authentication required)
-   `403` - Forbidden (insufficient permissions)
-   `404` - Not Found (resource not found)
-   `422` - Unprocessable Entity (validation failed)
-   `500` - Internal Server Error

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

**Nama Kelompok**: YAP (Yohan Artha Pratama)

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
