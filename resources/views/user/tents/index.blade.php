<x-layouts.app :title="__('Sewa Tenda')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            @if($selectedKategori)
                                {{ $selectedKategori->nama_kategori }} 🏕️
                            @else
                                Kamu Mungkin Suka Produk Ini 🥰
                            @endif
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            @if($selectedKategori)
                                Menampilkan produk dalam kategori {{ $selectedKategori->nama_kategori }}
                            @else
                                Pilih tenda terbaik untuk petualangan Anda
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Breadcrumb/Category Navigation -->
        @if($selectedKategori || request('search'))
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-sm">
                    <a href="{{ route('user.tents.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        All Products
                    </a>
                    @if($selectedKategori)
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-green-600 dark:text-green-400 font-medium">{{ $selectedKategori->nama_kategori }}</span>
                    @endif
                    @if(request('search'))
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-blue-600 dark:text-blue-400 font-medium">Search: "{{ request('search') }}"</span>
                    @endif
                </div>

                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $tents->total() }} produk ditemukan
                </div>
            </div>
        </div>
        @endif

        <!-- Filter and Search Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            <form method="GET" action="{{ route('user.tents.index') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cari Tenda
                    </label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama atau kode tenda..."
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                    >
                </div>

                <!-- Category Filter -->
                <div class="md:w-64">
                    <label for="kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Kategori
                    </label>
                    <select
                        id="kategori"
                        name="kategori"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="flex items-end">
                    <button
                        type="submit"
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200"
                    >
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Tents Grid -->
        <div class="grid auto-rows-min gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($tents as $tent)
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 hover:shadow-lg transition-shadow duration-300">
                    <!-- Product Image -->
                    <div class="aspect-square overflow-hidden">
                        @if($tent->foto && file_exists(public_path('images/units/' . $tent->foto)))
                            <img
                                src="{{ asset('images/units/' . $tent->foto) }}"
                                alt="{{ $tent->nama_unit }}"
                                class="h-full w-full object-cover hover:scale-105 transition-transform duration-300"
                            >
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <!-- Brand and Title -->
                        <div class="mb-2">
                            @if($tent->merk)
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                    {{ $tent->merk }}
                                </p>
                            @endif
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-2">
                                {{ $tent->nama_unit }}
                            </h3>
                        </div>

                        <!-- Categories -->
                        @if($tent->kategoris->count() > 0)
                            <div class="mb-3">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($tent->kategoris->take(2) as $kategori)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $kategori->nama_kategori }}
                                        </span>
                                    @endforeach
                                    @if($tent->kategoris->count() > 2)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                            +{{ $tent->kategoris->count() - 2 }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Capacity and Stock -->
                        <div class="mb-3 space-y-1">
                            @if($tent->kapasitas)
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Kapasitas: {{ $tent->kapasitas }}
                                </div>
                            @endif
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Stok: {{ $tent->available_stock }} tersedia
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <div class="flex items-baseline gap-2">
                                <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                    {{ $tent->getFormattedHargaSewaPerHari() }}
                                </span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    / hari
                                </span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="flex gap-2">
                            <!-- Add to Cart Button -->
                            @if($tent->available_stock > 0)
                                <button
                                    onclick="openCartModal({{ $tent->id }}, '{{ $tent->nama_unit }}', {{ $tent->harga_sewa_per_hari }}, {{ $tent->available_stock }})"
                                    class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200"
                                    title="Tambah ke Keranjang"
                                >
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293A1 1 0 005 16h12M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"/>
                                    </svg>
                                    Keranjang
                                </button>
                            @else
                                <button
                                    disabled
                                    class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gray-400 text-white font-medium rounded-lg cursor-not-allowed"
                                >
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Stok Habis
                                </button>
                            @endif

                            <!-- View Detail Button -->
                            <a
                                href="{{ route('user.tents.show', $tent) }}"
                                class="inline-flex items-center justify-center px-3 py-2 border border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-medium rounded-lg transition-colors duration-200"
                                title="Lihat Detail"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Stock Status Badge -->
                    @if($tent->available_stock == 0)
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                Stok Habis
                            </span>
                        </div>
                    @elseif($tent->available_stock <= 2)
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                Stok Terbatas
                            </span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <svg class="h-24 w-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            @if($selectedKategori)
                                Tidak ada tenda dalam kategori {{ $selectedKategori->nama_kategori }}
                            @elseif(request('search'))
                                Tidak ditemukan hasil untuk "{{ request('search') }}"
                            @else
                                Tidak ada tenda tersedia
                            @endif
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">
                            @if($selectedKategori)
                                Coba pilih kategori lain atau lihat semua produk.
                            @elseif(request('search'))
                                Coba ubah kata kunci pencarian atau lihat semua produk.
                            @else
                                Saat ini tidak ada tenda yang tersedia untuk disewa.
                            @endif
                        </p>

                        @if($selectedKategori || request('search'))
                            <a href="{{ route('user.tents.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v2H8V5z"></path>
                                </svg>
                                Lihat Semua Produk
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($tents->hasPages())
            <div class="mt-6">
                {{ $tents->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <!-- Add to Cart Modal -->
    <div id="cartModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 animate-fade-in">
        <!-- Backdrop with Blur Effect -->
        <div class="absolute inset-0 backdrop-blur-sm bg-gradient-to-br from-blue-50/70 via-white/40 to-green-50/70 dark:from-gray-900/70 dark:via-gray-800/40 dark:to-gray-900/70"></div>

        <!-- Modal Container -->
        <div class="relative w-full max-w-lg transform transition-all duration-300 ease-out scale-95 opacity-0" id="modalContainer">
            <!-- Background with Gradient and Glass Effect -->
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 dark:border-gray-700/30 overflow-hidden">
                <!-- Header with Gradient Background -->
                <div class="bg-gradient-to-r from-green-500 to-blue-500 p-6 text-white relative overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 w-20 h-20 bg-white/10 rounded-full"></div>
                    <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 bg-white/5 rounded-full"></div>

                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293A1 1 0 005 16h12M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Tambah ke Keranjang</h3>
                                <p class="text-white/80 text-sm">Pilih tanggal dan jumlah sewa</p>
                            </div>
                        </div>
                        <button
                            onclick="closeCartModal()"
                            class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-200 hover:scale-110"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Product Info Card -->
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 p-4 rounded-xl border border-green-200/50 dark:border-green-700/30">
                        <div class="flex items-start space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                🏕️
                            </div>
                            <div class="flex-1">
                                <h4 id="modalProductName" class="font-bold text-gray-900 dark:text-white text-lg"></h4>
                                <div class="flex items-center space-x-2 mt-1">
                                    <p id="modalProductPrice" class="text-green-600 dark:text-green-400 font-semibold"></p>
                                    <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                                    <p id="modalProductStock" class="text-gray-500 dark:text-gray-400 text-sm"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="p-6">
                    <form id="addToCartForm" onsubmit="addToCart(event)" class="space-y-5">
                        <input type="hidden" id="modalUnitId" name="unit_id">

                        <!-- Quantity -->
                        <div class="space-y-2">
                            <label for="quantity" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                Jumlah
                            </label>
                            <div class="relative">
                                <input
                                    type="number"
                                    id="quantity"
                                    name="quantity"
                                    min="1"
                                    value="1"
                                    required
                                    class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 text-center font-semibold text-lg"
                                >
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Start Date -->
                            <div class="space-y-2">
                                <label for="tanggal_mulai" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Tanggal Mulai
                                </label>
                                <input
                                    type="date"
                                    id="tanggal_mulai"
                                    name="tanggal_mulai"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                >
                            </div>

                            <!-- End Date -->
                            <div class="space-y-2">
                                <label for="tanggal_selesai" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Tanggal Selesai
                                </label>
                                <input
                                    type="date"
                                    id="tanggal_selesai"
                                    name="tanggal_selesai"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    required
                                    class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                >
                            </div>
                        </div>

                        <!-- Duration Display -->
                        <div id="durationDisplay" class="hidden bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-xl p-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Durasi Sewa:</span>
                                <span id="durationText" class="font-bold text-blue-600 dark:text-blue-400"></span>
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-sm text-blue-600 dark:text-blue-300">Estimasi Total:</span>
                                <span id="estimatedTotal" class="font-bold text-green-600 dark:text-green-400"></span>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="space-y-2">
                            <label for="notes" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Catatan (Opsional)
                            </label>
                            <textarea
                                id="notes"
                                name="notes"
                                rows="3"
                                placeholder="Contoh: Mohon disiapkan yang masih baru, untuk acara camping keluarga..."
                                class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 resize-none"
                            ></textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-2">
                            <button
                                type="button"
                                onclick="closeCartModal()"
                                class="flex-1 px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-semibold rounded-xl transition-all duration-200 hover:scale-105 hover:shadow-md"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                id="addToCartBtn"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white font-bold rounded-xl transition-all duration-200 hover:scale-105 hover:shadow-lg flex items-center justify-center space-x-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293A1 1 0 005 16h12M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"/>
                                </svg>
                                <span>Tambah ke Keranjang</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Success/Error Toast -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden transform transition-all duration-300">
        <div id="toastContent" class="px-6 py-4 rounded-xl shadow-2xl text-white font-semibold flex items-center space-x-3 min-w-[300px]">
            <!-- Icon will be added dynamically -->
        </div>
    </div>

    @push('scripts')
    <style>
        /* Custom animations for modal */
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .modal-show {
            opacity: 1 !important;
            transform: scale(1) !important;
        }

        .modal-hide {
            opacity: 0 !important;
            transform: scale(0.95) !important;
        }

        /* Enhance form inputs */
        input:focus, textarea:focus {
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }

        /* Loading button animation */
        .btn-loading {
            position: relative;
            overflow: hidden;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }
    </style>

    <script>
        let currentUnit = null;

        function openCartModal(unitId, unitName, unitPrice, availableStock) {
            console.log('Opening cart modal for unit:', unitId);

            currentUnit = {
                id: unitId,
                name: unitName,
                price: unitPrice,
                stock: availableStock
            };

            document.getElementById('modalUnitId').value = unitId;
            document.getElementById('modalProductName').textContent = unitName;
            document.getElementById('modalProductPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(unitPrice) + ' / hari';
            document.getElementById('modalProductStock').textContent = 'Stok tersedia: ' + availableStock + ' unit';
            document.getElementById('quantity').max = availableStock;

            // Reset form
            document.getElementById('addToCartForm').reset();
            document.getElementById('modalUnitId').value = unitId;
            document.getElementById('quantity').value = 1;

            // Set default dates
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);

            document.getElementById('tanggal_mulai').value = today.toISOString().split('T')[0];
            document.getElementById('tanggal_selesai').value = tomorrow.toISOString().split('T')[0];

            // Show modal with animation
            const modal = document.getElementById('cartModal');
            const container = document.getElementById('modalContainer');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Trigger animation
            setTimeout(() => {
                container.classList.add('modal-show');
            }, 10);

            // Calculate initial duration
            calculateDuration();
        }

        function closeCartModal() {
            const modal = document.getElementById('cartModal');
            const container = document.getElementById('modalContainer');

            // Hide with animation
            container.classList.remove('modal-show');
            container.classList.add('modal-hide');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                container.classList.remove('modal-hide');

                // Hide duration display
                document.getElementById('durationDisplay').classList.add('hidden');
            }, 300);
        }

        function calculateDuration() {
            const startDate = document.getElementById('tanggal_mulai').value;
            const endDate = document.getElementById('tanggal_selesai').value;
            const quantity = parseInt(document.getElementById('quantity').value) || 1;

            if (startDate && endDate && currentUnit) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 to include both start and end dates

                if (diffDays > 0) {
                    const totalCost = quantity * diffDays * currentUnit.price;

                    document.getElementById('durationText').textContent = `${diffDays} hari`;
                    document.getElementById('estimatedTotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalCost);
                    document.getElementById('durationDisplay').classList.remove('hidden');
                } else {
                    document.getElementById('durationDisplay').classList.add('hidden');
                }
            }
        }

        function addToCart(event) {
            event.preventDefault();
            console.log('Adding to cart...');

            const form = event.target;
            const formData = new FormData(form);
            const submitBtn = document.getElementById('addToCartBtn');

            // Debug: Log form data
            console.log('Form data:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.classList.add('btn-loading');
            submitBtn.innerHTML = `
                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Menambahkan...</span>
            `;

            fetch('{{ route('user.cart.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    showToast(data.message, 'success');
                    closeCartModal();
                    updateCartCount();
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-loading');
                submitBtn.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293A1 1 0 005 16h12M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"/>
                    </svg>
                    <span>Tambah ke Keranjang</span>
                `;
            });
        }

        function showToast(message, type) {
            const toast = document.getElementById('toast');
            const toastContent = document.getElementById('toastContent');

            let icon = '';
            let className = '';

            if (type === 'success') {
                icon = `
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                `;
                className = 'px-6 py-4 rounded-xl shadow-2xl text-white font-semibold bg-gradient-to-r from-green-500 to-emerald-500 border border-green-300 flex items-center space-x-3 min-w-[300px]';
            } else {
                icon = `
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                `;
                className = 'px-6 py-4 rounded-xl shadow-2xl text-white font-semibold bg-gradient-to-r from-red-500 to-pink-500 border border-red-300 flex items-center space-x-3 min-w-[300px]';
            }

            toastContent.className = className;
            toastContent.innerHTML = `${icon}<span>${message}</span>`;

            toast.classList.remove('hidden');

            // Add animation
            toast.style.transform = 'translateX(100%)';
            toast.style.opacity = '0';

            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
                toast.style.opacity = '1';
                toast.style.transition = 'all 0.3s ease-out';
            }, 10);

            setTimeout(() => {
                toast.style.transform = 'translateX(100%)';
                toast.style.opacity = '0';
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 300);
            }, 5000);
        }

        function updateCartCount() {
            console.log('Updating cart count...');
            fetch('{{ route('user.cart.count') }}')
                .then(response => response.json())
                .then(data => {
                    console.log('Cart count:', data.count);
                    // Update cart badge if exists
                    const cartBadge = document.getElementById('cartBadge');
                    if (cartBadge) {
                        cartBadge.textContent = data.count;
                        cartBadge.style.display = data.count > 0 ? 'flex' : 'none';
                    }

                    // Also update global cart count function for sidebar
                    if (typeof window.updateCartCount === 'function') {
                        window.updateCartCount();
                    }
                })
                .catch(error => console.error('Error updating cart count:', error));
        }

        // Event listeners for form changes
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, updating cart count...');
            updateCartCount();

            // Add event listeners for date and quantity changes
            const quantityInput = document.getElementById('quantity');
            const startDateInput = document.getElementById('tanggal_mulai');
            const endDateInput = document.getElementById('tanggal_selesai');

            if (quantityInput) {
                quantityInput.addEventListener('input', calculateDuration);
            }

            if (startDateInput) {
                startDateInput.addEventListener('change', function() {
                    const startDate = new Date(this.value);
                    const minEndDate = new Date(startDate);
                    minEndDate.setDate(minEndDate.getDate() + 1);

                    endDateInput.min = minEndDate.toISOString().split('T')[0];

                    // If end date is before new minimum, update it
                    if (new Date(endDateInput.value) <= startDate) {
                        endDateInput.value = minEndDate.toISOString().split('T')[0];
                    }

                    calculateDuration();
                });
            }

            if (endDateInput) {
                endDateInput.addEventListener('change', calculateDuration);
            }
        });

        // Close modal when clicking outside
        document.getElementById('cartModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCartModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('cartModal');
                if (!modal.classList.contains('hidden')) {
                    closeCartModal();
                }
            }
        });
    </script>
    @endpush
</x-layouts.app>
