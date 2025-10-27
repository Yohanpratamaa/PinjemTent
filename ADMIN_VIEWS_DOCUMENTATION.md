# Admin Views Documentation

Dokumentasi lengkap untuk file-file view admin yang mendukung sistem Clean Architecture untuk aplikasi PinjemTent.

## 📁 Struktur File View

```
resources/views/
├── admin/
│   ├── dashboard.blade.php           # Dashboard utama admin
│   ├── units/                        # Manajemen Unit
│   │   ├── index.blade.php          # Daftar semua unit
│   │   ├── create.blade.php         # Form tambah unit baru
│   │   ├── edit.blade.php           # Form edit unit
│   │   └── show.blade.php           # Detail unit
│   ├── kategoris/                    # Manajemen Kategori
│   │   ├── index.blade.php          # Daftar semua kategori
│   │   ├── create.blade.php         # Form tambah kategori baru
│   │   └── edit.blade.php           # Form edit kategori
│   ├── users/                        # Manajemen User
│   │   ├── index.blade.php          # Daftar semua user
│   │   └── create.blade.php         # Form tambah user baru
│   └── peminjamans/                  # Manajemen Peminjaman
│       └── index.blade.php          # Daftar semua peminjaman
├── components/
│   ├── admin/                        # Komponen khusus admin
│   │   ├── stats-card.blade.php     # Komponen kartu statistik
│   │   ├── search-form.blade.php    # Komponen form pencarian
│   │   └── page-header.blade.php    # Komponen header halaman
│   └── layouts/
│       └── admin.blade.php          # Layout khusus admin
```

## 🎯 Fitur Utama

### 1. Dashboard Admin

-   **File**: `admin/dashboard.blade.php`
-   **Fitur**:
    -   Welcome section dengan informasi admin
    -   Cards statistik untuk overview sistem
    -   Quick actions untuk akses cepat ke fitur utama
    -   Layout responsive dengan Flux UI components

### 2. Unit Management

-   **Files**: `admin/units/*.blade.php`
-   **Fitur**:
    -   ✅ **Index**: Tabel daftar unit dengan search dan filter
    -   ✅ **Create**: Form tambah unit dengan validasi
    -   ✅ **Edit**: Form edit unit dengan data existing
    -   ✅ **Show**: Detail unit dengan riwayat peminjaman
    -   🔧 **Search & Filter**:
        -   Search by kode_unit atau nama_unit
        -   Filter by status (tersedia, disewa, maintenance)
        -   Filter by kategori
    -   📊 **Statistics**: Cards untuk Available, Rented, Maintenance, Total Units

### 3. Category Management

-   **Files**: `admin/kategoris/*.blade.php`
-   **Fitur**:
    -   ✅ **Index**: Grid layout untuk menampilkan kategori
    -   ✅ **Create**: Form tambah kategori dengan assign units
    -   ✅ **Edit**: Form edit kategori dengan statistik
    -   🔧 **Search & Sort**:
        -   Search by nama atau deskripsi
        -   Sort by name, units count, created date
    -   📊 **Statistics**: Total Categories, Total Units, Average Units/Category, Empty Categories

### 4. User Management

-   **Files**: `admin/users/*.blade.php`
-   **Fitur**:
    -   ✅ **Index**: Tabel users dengan informasi lengkap
    -   ✅ **Create**: Form tambah user dengan role assignment
    -   🔧 **Search & Filter**:
        -   Search by name, email, phone
        -   Filter by role (admin, user)
        -   Filter by status (active, inactive)
    -   📊 **Statistics**: Total Users, Admins, Regular Users, Active Rentals

### 5. Rental Management

-   **Files**: `admin/peminjamans/*.blade.php`
-   **Fitur**:
    -   ✅ **Index**: Tabel peminjaman dengan informasi lengkap
    -   🔧 **Search & Filter**:
        -   Search by user name, unit code, rental ID
        -   Filter by status (active, returned, overdue, cancelled)
        -   Date range filter
    -   📊 **Statistics**: Total Rentals, Active, Returned, Overdue, Monthly Revenue
    -   🎯 **Actions**: View details, Mark as returned, Edit rental

## 🧩 Komponen Reusable

### 1. Stats Card Component

```php
<x-admin.stats-card
    title="Total Units"
    value="150"
    icon="squares-2x2"
    color="blue"
    subtitle="5 new this month"
    trend="['type' => 'up', 'value' => '+12%']"
    href="/admin/units"
/>
```

### 2. Search Form Component

```php
<x-admin.search-form
    action="{{ route('admin.units.index') }}"
    searchPlaceholder="Search units..."
    :filters="[
        ['name' => 'status', 'placeholder' => 'Filter by status', 'options' => $statusOptions],
        ['name' => 'category', 'placeholder' => 'Filter by category', 'options' => $categoryOptions]
    ]"
    showExport="true"
/>
```

### 3. Page Header Component

```php
<x-admin.page-header
    title="Unit Management"
    subtitle="Manage tent units and their categories"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['label' => 'Units']
    ]"
>
    <x-slot name="actions">
        <flux:button variant="primary" href="{{ route('admin.units.create') }}">
            Add New Unit
        </flux:button>
    </x-slot>
</x-admin.page-header>
```

## 🎨 Layout Admin

### Fitur Layout Admin:

-   **Sidebar Navigation**: Menu terorganisir berdasarkan fungsi
    -   Dashboard
    -   Inventory Management (Units, Categories)
    -   Rental Management (Rentals, Overdue, Reports)
    -   User Management (Users, Roles & Permissions)
    -   System (Settings, Audit Logs)
-   **Responsive Design**: Mobile-friendly dengan collapsible sidebar
-   **Dark Mode Support**: Menggunakan Flux UI dark mode
-   **User Profile**: Dropdown dengan role indicator (Admin)
-   **Navigation Highlighting**: Active route highlighting

### Menu Structure:

```
📊 Dashboard
├── Dashboard

📦 Inventory Management
├── Units
├── Categories

📋 Rental Management
├── Rentals
├── Overdue
├── Reports

👥 User Management
├── Users
├── Roles & Permissions

⚙️ System
├── Settings
├── Audit Logs
```

## 🔗 Integrasi dengan Backend

### Controller Dependencies:

Views ini dirancang untuk bekerja dengan:

-   **UnitController**: Menggunakan UnitService untuk business logic
-   **KategoriController**: Menggunakan KategoriService untuk CRUD operations
-   **UserController**: Menggunakan UserService untuk user management
-   **PeminjamanController**: Menggunakan PeminjamanService untuk rental logic

### Data yang Dibutuhkan:

-   **$units**: Collection dengan relationships (kategoris, peminjamans)
-   **$kategoris**: Collection dengan units count
-   **$users**: Collection dengan rental statistics
-   **$peminjamans**: Collection dengan user dan unit data
-   **$stats**: Array dengan statistik untuk dashboard cards

### Route Integration:

```php
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('units', UnitController::class);
    Route::resource('kategoris', KategoriController::class);
    Route::resource('users', UserController::class);
    Route::resource('peminjamans', PeminjamanController::class);
    Route::put('/peminjamans/{peminjaman}/return', [PeminjamanController::class, 'return'])->name('peminjamans.return');
});
```

## 🎯 Best Practices yang Diterapkan

1. **Konsistensi UI**: Menggunakan Flux UI components secara konsisten
2. **Responsive Design**: Grid system yang adaptif untuk semua screen size
3. **User Experience**:
    - Loading states
    - Empty states dengan call-to-action
    - Confirmation dialogs untuk destructive actions
    - Breadcrumb navigation
4. **Accessibility**: Proper labeling dan keyboard navigation
5. **Performance**:
    - Pagination untuk data besar
    - Efficient querying dengan relationships
    - Image optimization ready
6. **Security**:
    - CSRF protection
    - Role-based access control
    - Input validation feedback

## 🚀 Langkah Selanjutnya

1. **Implementasi Controller**: Buat controllers yang sesuai dengan view requirements
2. **Route Definition**: Define routes dengan middleware yang tepat
3. **Data Seeding**: Populate database dengan sample data untuk testing
4. **Testing**: Unit tests untuk semua CRUD operations
5. **Optimization**: Performance tuning untuk query efficiency

## 📝 Catatan Pengembangan

-   Semua view menggunakan layout admin yang konsisten
-   Form validation errors sudah dihandle dengan Flux error components
-   Search dan filter functionality ready untuk implementation
-   Export functionality hooks sudah tersedia
-   Statistics calculation hooks sudah tersedia untuk real-time data

File-file view ini siap untuk diintegrasikan dengan backend Clean Architecture yang telah dibuat sebelumnya.
