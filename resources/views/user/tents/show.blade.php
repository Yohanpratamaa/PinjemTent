<x-layouts.app :title="$tent->nama_unit">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Back Button -->
        <div class="flex items-center gap-4">
            <a
                href="{{ route('user.tents.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Tenda
            </a>
        </div>

        <!-- Main Content -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Image Section -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <div class="aspect-square overflow-hidden">
                    @if($tent->foto)
                        <img
                            src="{{ asset('storage/' . $tent->foto) }}"
                            alt="{{ $tent->nama_unit }}"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="h-full w-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                            <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Stock Status Badge -->
                @if($tent->available_stock == 0)
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Stok Habis
                        </span>
                    </div>
                @elseif($tent->available_stock <= 2)
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            Stok Terbatas
                        </span>
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="space-y-6">
                <!-- Header -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    @if($tent->merk)
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                            {{ $tent->merk }}
                        </p>
                    @endif
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $tent->nama_unit }}
                    </h1>

                    <!-- Categories -->
                    @if($tent->kategoris->count() > 0)
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach($tent->kategoris as $kategori)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $kategori->nama_kategori }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Price -->
                    <div class="mb-6">
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-bold text-green-600 dark:text-green-400">
                                {{ $tent->getFormattedHargaSewaPerHari() }}
                            </span>
                            <span class="text-lg text-gray-500 dark:text-gray-400">
                                / hari
                            </span>
                        </div>
                        @if($tent->denda_per_hari)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Denda keterlambatan: {{ $tent->getFormattedDendaPerHari() }} / hari
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Specifications -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Spesifikasi
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Kode Unit</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $tent->kode_unit }}</span>
                        </div>
                        @if($tent->kapasitas)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-400">Kapasitas</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $tent->kapasitas }}</span>
                            </div>
                        @endif
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Status</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                {{ $tent->status === 'tersedia' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ ucfirst($tent->status) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-gray-600 dark:text-gray-400">Stok Tersedia</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $tent->available_stock }} unit</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($tent->deskripsi)
                    <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Deskripsi
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ $tent->deskripsi }}
                        </p>
                    </div>
                @endif

                <!-- Rental Action -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    @if($tent->available_stock > 0)
                        <button
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200"
                            onclick="alert('Fitur peminjaman akan segera hadir!')"
                        >
                            Sewa Sekarang
                        </button>
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-2">
                            Proses peminjaman mudah dan aman
                        </p>
                    @else
                        <button
                            disabled
                            class="w-full bg-gray-400 cursor-not-allowed text-white font-semibold py-3 px-6 rounded-lg"
                        >
                            Stok Tidak Tersedia
                        </button>
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-2">
                            Tenda ini sedang tidak tersedia untuk disewa
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Similar Products -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                Produk Serupa
            </h3>
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <p>Fitur produk serupa akan segera hadir</p>
            </div>
        </div>
    </div>
</x-layouts.app>
