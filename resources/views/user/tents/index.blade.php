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
                            Kamu Mungkin Suka Produk Ini 🥰
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Pilih tenda terbaik untuk petualangan Anda
                        </p>
                    </div>
                </div>
            </div>
        </div>

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
                        <div class="space-y-2">
                            <a
                                href="{{ route('user.tents.show', $tent) }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-medium rounded-lg transition-colors duration-200"
                            >
                                Lihat Detail
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
                            Tidak ada tenda tersedia
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            Saat ini tidak ada tenda yang tersedia untuk disewa.
                        </p>
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
</x-layouts.app>
