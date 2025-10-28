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
    <div id="cartModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md mx-4 bg-white dark:bg-neutral-800 rounded-xl shadow-xl">
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Tambah ke Keranjang
                    </h3>
                    <button
                        onclick="closeCartModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                    >
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Product Info -->
                <div class="mb-4 p-3 bg-gray-50 dark:bg-neutral-700 rounded-lg">
                    <h4 id="modalProductName" class="font-medium text-gray-900 dark:text-white"></h4>
                    <p id="modalProductPrice" class="text-sm text-green-600 dark:text-green-400"></p>
                    <p id="modalProductStock" class="text-xs text-gray-500 dark:text-gray-400"></p>
                </div>

                <!-- Form -->
                <form id="addToCartForm" onsubmit="addToCart(event)">
                    <input type="hidden" id="modalUnitId" name="unit_id">

                    <!-- Quantity -->
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Jumlah
                        </label>
                        <input
                            type="number"
                            id="quantity"
                            name="quantity"
                            min="1"
                            value="1"
                            required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                        >
                    </div>

                    <!-- Start Date -->
                    <div class="mb-4">
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tanggal Mulai
                        </label>
                        <input
                            type="date"
                            id="tanggal_mulai"
                            name="tanggal_mulai"
                            min="{{ date('Y-m-d') }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                        >
                    </div>

                    <!-- End Date -->
                    <div class="mb-4">
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tanggal Selesai
                        </label>
                        <input
                            type="date"
                            id="tanggal_selesai"
                            name="tanggal_selesai"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                        >
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Catatan (Opsional)
                        </label>
                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            placeholder="Catatan tambahan untuk penyewaan..."
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                        ></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button
                            type="button"
                            onclick="closeCartModal()"
                            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-lg transition-colors duration-200"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            id="addToCartBtn"
                            class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200"
                        >
                            Tambah ke Keranjang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success/Error Toast -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div id="toastContent" class="px-4 py-3 rounded-lg shadow-lg text-white font-medium">
        </div>
    </div>

    @push('scripts')
    <script>
        let currentUnit = null;

        function openCartModal(unitId, unitName, unitPrice, availableStock) {
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

            document.getElementById('cartModal').classList.remove('hidden');
            document.getElementById('cartModal').classList.add('flex');
        }

        function closeCartModal() {
            document.getElementById('cartModal').classList.add('hidden');
            document.getElementById('cartModal').classList.remove('flex');
        }

        function addToCart(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const submitBtn = document.getElementById('addToCartBtn');

            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.textContent = 'Menambahkan...';

            fetch('{{ route('user.cart.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
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
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = 'Tambah ke Keranjang';
            });
        }

        function showToast(message, type) {
            const toast = document.getElementById('toast');
            const toastContent = document.getElementById('toastContent');

            toastContent.textContent = message;

            if (type === 'success') {
                toastContent.className = 'px-4 py-3 rounded-lg shadow-lg text-white font-medium bg-green-600';
            } else {
                toastContent.className = 'px-4 py-3 rounded-lg shadow-lg text-white font-medium bg-red-600';
            }

            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 5000);
        }

        function updateCartCount() {
            fetch('{{ route('user.cart.count') }}')
                .then(response => response.json())
                .then(data => {
                    // Update cart badge if exists
                    const cartBadge = document.getElementById('cartBadge');
                    if (cartBadge) {
                        cartBadge.textContent = data.count;
                        cartBadge.style.display = data.count > 0 ? 'block' : 'none';
                    }
                })
                .catch(error => console.error('Error updating cart count:', error));
        }

        // Close modal when clicking outside
        document.getElementById('cartModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCartModal();
            }
        });

        // Update end date minimum when start date changes
        document.getElementById('tanggal_mulai').addEventListener('change', function() {
            const startDate = new Date(this.value);
            const minEndDate = new Date(startDate);
            minEndDate.setDate(minEndDate.getDate() + 1);

            document.getElementById('tanggal_selesai').min = minEndDate.toISOString().split('T')[0];

            // If end date is before new minimum, update it
            const endDateInput = document.getElementById('tanggal_selesai');
            if (new Date(endDateInput.value) <= startDate) {
                endDateInput.value = minEndDate.toISOString().split('T')[0];
            }
        });

        // Load cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });
    </script>
    @endpush
</x-layouts.app>
