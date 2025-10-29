<x-layouts.app :title="__('User Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Hero Welcome Section -->
        <div class="relative overflow-hidden bg-gradient-to-r from-green-500 via-teal-500 to-blue-500 rounded-2xl p-8 text-white">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">
                        Selamat Datang, {{ auth()->user()->name }}! 🏕️
                    </h1>
                    <p class="text-lg opacity-90 mb-4">
                        Siap untuk petualangan berikutnya? Temukan gear terbaik untuk perjalanan Anda.
                    </p>
                    <a
                        href="{{ route('user.tents.index') }}"
                        class="inline-flex items-center gap-2 bg-white text-green-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Jelajahi Produk
                    </a>
                </div>
                <div class="hidden lg:block">
                    <div class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-32 translate-x-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-24 -translate-x-24"></div>
        </div>

        <!-- Quick Access Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('user.tents.index') }}" class="group relative overflow-hidden bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Sewa Tenda</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Gear lengkap</p>
                </div>
            </a>

            <a href="{{ route('profile.edit') }}" class="group relative overflow-hidden bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Profil Saya</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Kelola akun</p>
                </div>
            </a>

            <button class="group relative overflow-hidden bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Riwayat</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Aktivitas</p>
                </div>
            </button>

            <button class="group relative overflow-hidden bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Bantuan</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Support</p>
                </div>
            </button>
        </div>

        <!-- Featured Tents Section -->
        @if($featuredTents && $featuredTents->count() > 0)
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Produk Populer 🔥</h2>
                            <p class="text-gray-600 dark:text-gray-400">Gear favorit para petualang</p>
                        </div>
                        <a
                            href="{{ route('user.tents.index') }}"
                            class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 font-medium transition-colors"
                        >
                            Lihat Semua
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($featuredTents as $tent)
                            <div class="group relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                                <!-- Product Image -->
                                <div class="aspect-square overflow-hidden relative">
                                    @if($tent->foto && file_exists(public_path('images/units/' . $tent->foto)))
                                        <img
                                            src="{{ asset('images/units/' . $tent->foto) }}"
                                            alt="{{ $tent->nama_unit }}"
                                            class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        >
                                    @else
                                        <div class="h-full w-full bg-gradient-to-br from-green-100 to-green-200 dark:from-green-800 dark:to-green-900 flex items-center justify-center">
                                            <svg class="h-16 w-16 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Overlay on hover -->
                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>

                                <!-- Product Info -->
                                <div class="p-4">
                                    @if($tent->merk)
                                        <p class="text-xs font-medium text-green-600 dark:text-green-400 uppercase tracking-wide mb-1">
                                            {{ $tent->merk }}
                                        </p>
                                    @endif
                                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-2 mb-2">
                                        {{ $tent->nama_unit }}
                                    </h3>

                                    <!-- Price -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div>
                                            <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                                {{ $tent->getFormattedHargaSewaPerHari() }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">/hari</span>
                                        </div>
                                        @if($tent->available_stock <= 3)
                                            <span class="text-xs bg-orange-100 text-orange-600 px-2 py-1 rounded-full">
                                                {{ $tent->available_stock }} tersisa
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex gap-2">
                                        @if($tent->available_stock > 0)
                                            <button
                                                onclick="addToCartDirectly({{ $tent->id }}, '{{ addslashes($tent->nama_unit) }}', {{ $tent->harga_sewa_per_hari }}, {{ $tent->available_stock }})"
                                                class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-200"
                                            >
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293A1 1 0 005 16h12M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"/>
                                                </svg>
                                                Keranjang
                                            </button>
                                        @else
                                            <button
                                                disabled
                                                class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm bg-gray-300 text-gray-500 font-medium rounded-lg cursor-not-allowed"
                                            >
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Stok Habis
                                            </button>
                                        @endif

                                        <a
                                            href="{{ route('user.tents.show', $tent) }}"
                                            class="inline-flex items-center justify-center px-3 py-2 text-sm border border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-medium rounded-lg transition-all duration-200"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                                <!-- Popular Badge -->
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500 text-white">
                                        🔥 Populer
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Promo Section -->
        <div class="bg-gradient-to-r from-orange-400 via-red-400 to-pink-400 rounded-2xl overflow-hidden">
            <div class="p-8 text-white relative">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-2xl">🎉</span>
                                <h2 class="text-2xl font-bold">Promo Spesial</h2>
                            </div>
                            <p class="text-lg opacity-90 mb-4">
                                Diskon hingga 30% untuk sewa gear camping selama weekend!
                            </p>
                            <div class="flex flex-wrap gap-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Free delivery dalam kota</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Gear premium quality</span>
                                </div>
                            </div>
                        </div>
                        <div class="hidden lg:block">
                            <a
                                href="{{ route('user.tents.index') }}"
                                class="inline-flex items-center gap-2 bg-white text-red-500 font-semibold px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors"
                            >
                                Ambil Promo
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Mobile CTA -->
                    <div class="lg:hidden mt-4">
                        <a
                            href="{{ route('user.tents.index') }}"
                            class="inline-flex items-center gap-2 bg-white text-red-500 font-semibold px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors"
                        >
                            Ambil Promo
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
            </div>
        </div>

        <!-- Solo Traveler Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>🎒</span>
                            Buat yang Suka Solo
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400">Gear ringan dan praktis untuk solo trip</p>
                    </div>
                    <a
                        href="{{ route('user.tents.index', ['kategori' => '']) }}"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors"
                    >
                        Jelajahi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Solo Essentials -->
                    <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 p-6 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Tas Carrier</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Mulai Rp 30.000/hari</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Tas carrier 40-60L yang perfect untuk solo hiking dan backpacking.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">Ringan</span>
                            <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">Ergonomis</span>
                        </div>
                    </div>

                    <!-- Sleeping Gear -->
                    <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 border border-purple-200 dark:border-purple-800 p-6 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-800 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Sleeping Bag</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Mulai Rp 40.000/hari</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Sleeping bag berkualitas tinggi untuk kenyamanan tidur di alam bebas.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded">Hangat</span>
                            <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded">Kompak</span>
                        </div>
                    </div>

                    <!-- Navigation Tools -->
                    <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-green-50 to-teal-50 dark:from-green-900/20 dark:to-teal-900/20 border border-green-200 dark:border-green-800 p-6 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Alat Navigasi</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Mulai Rp 15.000/hari</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Kompas digital dan GPS untuk memandu perjalanan solo Anda.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded">Akurat</span>
                            <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded">Digital</span>
                        </div>
                    </div>
                </div>

                <!-- Solo Tips -->
                <div class="mt-6 bg-gray-50 dark:bg-gray-800/50 rounded-xl p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">💡 Tips Solo Traveling</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-start gap-2">
                            <span class="text-green-500 mt-0.5">✓</span>
                            <span>Pilih gear yang lightweight tapi durable</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-green-500 mt-0.5">✓</span>
                            <span>Bawa alat navigasi cadangan</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-green-500 mt-0.5">✓</span>
                            <span>Informasikan rute ke keluarga/teman</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-green-500 mt-0.5">✓</span>
                            <span>Siapkan first aid kit lengkap</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Sewa</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Penghematan</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp 0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-800 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Poin Loyalitas</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Footer -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Butuh Bantuan?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white">FAQ</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pertanyaan umum</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white">Live Chat</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Chat dengan admin</p>
                    </div>
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
    <script>
        // Function to add item directly to cart without modal
        function addToCartDirectly(unitId, unitName, unitPrice, availableStock) {
            console.log('Adding to cart directly for unit:', unitId);

            // Create data object for cart addition
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);

            const requestData = {
                unit_id: unitId,
                quantity: 1, // Default quantity
                tanggal_mulai: today.toISOString().split('T')[0],
                tanggal_selesai: tomorrow.toISOString().split('T')[0],
                notes: '' // Empty notes
            };

            console.log('Request data:', requestData);

            // Show loading notification
            showToast('Menambahkan ke keranjang...', 'loading');

            fetch('{{ route('user.cart.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                // Hide loading toast
                hideToast();

                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Server returned non-JSON response');
                }

                return response.json().then(data => {
                    if (!response.ok) {
                        throw new Error(data.message || 'Terjadi kesalahan pada server');
                    }
                    return data;
                });
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    showToastWithAction(data.message, 'success', 'Lihat Keranjang', '{{ route('user.cart.index') }}');
                    updateCartCount();
                } else {
                    showToast(data.message || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideToast(); // Hide loading toast on error
                showToast(error.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                `;
                className = 'px-6 py-4 rounded-xl shadow-2xl text-white font-semibold bg-gradient-to-r from-green-500 to-emerald-500 border border-green-300 flex items-center space-x-3 min-w-[300px]';
            } else if (type === 'loading') {
                icon = `
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                `;
                className = 'px-6 py-4 rounded-xl shadow-2xl text-white font-semibold bg-gradient-to-r from-blue-500 to-cyan-500 border border-blue-300 flex items-center space-x-3 min-w-[300px]';
            } else {
                icon = `
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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

        function showToastWithAction(message, type, actionText, actionUrl) {
            const toast = document.getElementById('toast');
            const toastContent = document.getElementById('toastContent');

            let icon = '';
            let className = '';

            if (type === 'success') {
                icon = `
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                `;
                className = 'px-6 py-4 rounded-xl shadow-2xl text-white font-semibold bg-gradient-to-r from-green-500 to-emerald-500 border border-green-300 flex items-center justify-between space-x-3 min-w-[350px]';
            }

            toastContent.className = className;
            toastContent.innerHTML = `
                <div class="flex items-center space-x-3">
                    ${icon}
                    <span>${message}</span>
                </div>
                <a href="${actionUrl}" class="ml-4 px-3 py-1 bg-white/20 hover:bg-white/30 rounded-lg text-sm font-medium transition-colors duration-200">
                    ${actionText}
                </a>
            `;

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
            }, 7000); // Extended time for action toast
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            if (!toast.classList.contains('hidden')) {
                toast.style.transform = 'translateX(100%)';
                toast.style.opacity = '0';
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 300);
            }
        }

        function updateCartCount() {
            console.log('Updating cart count...');
            fetch('{{ route('user.cart.count') }}')
                .then(response => response.json())
                .then(data => {
                    // Update cart count in sidebar if exists
                    if (window.updateCartCount && typeof window.updateCartCount === 'function') {
                        window.updateCartCount();
                    }
                })
                .catch(error => console.error('Error updating cart count:', error));
        }

        // Event listeners for page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Dashboard loaded, updating cart count...');
            updateCartCount();
        });
    </script>
    @endpush
</x-layouts.app>
