# Testing Admin Access

## Akun Admin yang Tersedia

-   **Email**: admin@pinjemtent.com
-   **Password**: password
-   **Role**: admin

-   **Email**: superadmin@pinjemtent.com
-   **Password**: superpassword
-   **Role**: admin

## URL Admin yang Bisa Diakses

### Dashboard

-   `/admin/dashboard` - Halaman utama admin

### Manajemen Unit

-   `/admin/units` - Daftar semua unit
-   `/admin/units/create` - Form tambah unit baru
-   `/admin/units/{id}` - Detail unit
-   `/admin/units/{id}/edit` - Form edit unit

### Manajemen Kategori

-   `/admin/kategoris` - Daftar semua kategori
-   `/admin/kategoris/create` - Form tambah kategori baru
-   `/admin/kategoris/{id}` - Detail kategori
-   `/admin/kategoris/{id}/edit` - Form edit kategori

### Manajemen User

-   `/admin/users` - Daftar semua user
-   `/admin/users/create` - Form tambah user baru
-   `/admin/users/{id}` - Detail user
-   `/admin/users/{id}/edit` - Form edit user

### Manajemen Peminjaman

-   `/admin/peminjamans` - Daftar semua peminjaman
-   `/admin/peminjamans/create` - Form tambah peminjaman baru
-   `/admin/peminjamans/{id}` - Detail peminjaman
-   `/admin/peminjamans/{id}/edit` - Form edit peminjaman

## Data Dummy yang Sudah Dibuat

### Kategori

1. Tenda Camping
2. Alat Masak
3. Tas Carrier
4. Sleeping Bag
5. Alat Navigasi

### Unit

1. TND-001 - Tenda Dome 4 Orang (5 stok)
2. TND-002 - Tenda Tunnel 6 Orang (3 stok)
3. MSK-001 - Kompor Portable (8 stok)
4. MSK-002 - Nesting Set (6 stok)
5. CAR-001 - Tas Carrier 60L (10 stok)
6. SLP-001 - Sleeping Bag Mummy (12 stok)
7. NAV-001 - Kompas Digital (4 stok) - Status: Maintenance

### User

-   1 Admin user (admin@pinjemtent.com)
-   1 Super Admin user (superadmin@pinjemtent.com)
-   6 Test users (test@example.com + 5 factory users)

## Cara Testing

1. Jalankan `php artisan serve`
2. Buka browser ke `http://localhost:8000`
3. Login menggunakan akun admin di atas
4. Setelah login, akan diarahkan ke `/admin/dashboard`
5. Test semua fitur admin yang tersedia

## Status Setup

✅ Views admin sudah dibuat
✅ Controllers admin sudah dibuat  
✅ Routes admin sudah didefinisikan
✅ Service Provider sudah dikonfigurasi
✅ Middleware admin sudah ada
✅ Database sudah diisi dengan data dummy
✅ Sistem siap untuk testing
