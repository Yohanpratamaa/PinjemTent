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
                    @if($tent->foto && file_exists(public_path('images/units/' . $tent->foto)))
                        <img
                            src="{{ asset('images/units/' . $tent->foto) }}"
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

                <!-- Cart Action -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    @if($tent->available_stock > 0)
                        <div class="space-y-3">
                            <!-- Add to Cart Button -->
                            <button
                                onclick="addToCartDirectly({{ $tent->id }}, '{{ addslashes($tent->nama_unit) }}', {{ $tent->harga_sewa_per_hari }}, {{ $tent->available_stock }})"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5h10.1M9 19h.01M20 19h.01"></path>
                                </svg>
                                Masukkan ke Keranjang
                            </button>

                            <!-- View Cart Button -->
                            <a
                                href="{{ route('user.cart.index') }}"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Lihat Keranjang
                            </a>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-3">
                            Tambahkan ke keranjang untuk melanjutkan proses penyewaan
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
            console.log('Product detail loaded, updating cart count...');
            updateCartCount();
        });
    </script>
    @endpush
</x-layouts.app>
