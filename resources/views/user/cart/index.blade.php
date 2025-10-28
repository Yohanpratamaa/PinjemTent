<x-layouts.app :title="__('Keranjang Belanja')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293A1 1 0 005 16h12M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Keranjang Belanja 🛒
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $cartItems->count() }} item dalam keranjang Anda
                        </p>
                    </div>
                </div>

                @if($cartItems->count() > 0)
                    <button
                        onclick="clearCart()"
                        class="px-4 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 font-medium rounded-lg transition-colors duration-200"
                    >
                        Kosongkan Keranjang
                    </button>
                @endif
            </div>
        </div>

        @if($cartItems->count() > 0)
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div id="cartItem_{{ $item->id }}" class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                            <div class="flex gap-4">
                                <!-- Product Image -->
                                <div class="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden">
                                    @if($item->unit->foto && file_exists(public_path('images/units/' . $item->unit->foto)))
                                        <img
                                            src="{{ asset('images/units/' . $item->unit->foto) }}"
                                            alt="{{ $item->unit->nama_unit }}"
                                            class="w-full h-full object-cover"
                                        >
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $item->unit->nama_unit }}
                                            </h3>
                                            @if($item->unit->merk)
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $item->unit->merk }}
                                                </p>
                                            @endif

                                            <!-- Categories -->
                                            @if($item->unit->kategoris->count() > 0)
                                                <div class="mt-2 flex flex-wrap gap-1">
                                                    @foreach($item->unit->kategoris->take(2) as $kategori)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                            {{ $kategori->nama_kategori }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Remove Button -->
                                        <button
                                            onclick="removeFromCart({{ $item->id }})"
                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 p-1"
                                            title="Hapus dari keranjang"
                                        >
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Quantity and Dates -->
                                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <!-- Quantity -->
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Jumlah
                                            </label>
                                            <input
                                                type="number"
                                                min="1"
                                                max="{{ $item->unit->available_stock + $item->quantity }}"
                                                value="{{ $item->quantity }}"
                                                onchange="updateCartItem({{ $item->id }}, 'quantity', this.value)"
                                                class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                            >
                                        </div>

                                        <!-- Start Date -->
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Tanggal Mulai
                                            </label>
                                            <input
                                                type="date"
                                                min="{{ date('Y-m-d') }}"
                                                value="{{ $item->tanggal_mulai->format('Y-m-d') }}"
                                                onchange="updateCartItem({{ $item->id }}, 'tanggal_mulai', this.value)"
                                                class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                            >
                                        </div>

                                        <!-- End Date -->
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Tanggal Selesai
                                            </label>
                                            <input
                                                type="date"
                                                min="{{ $item->tanggal_mulai->addDay()->format('Y-m-d') }}"
                                                value="{{ $item->tanggal_selesai->format('Y-m-d') }}"
                                                onchange="updateCartItem({{ $item->id }}, 'tanggal_selesai', this.value)"
                                                class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                            >
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    @if($item->notes)
                                        <div class="mt-3">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <span class="font-medium">Catatan:</span> {{ $item->notes }}
                                            </p>
                                        </div>
                                    @endif

                                    <!-- Pricing Info -->
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $item->formatted_harga_per_hari }} × {{ $item->quantity }} × {{ $item->duration }} hari
                                        </div>
                                        <div class="text-lg font-bold text-green-600 dark:text-green-400">
                                            {{ $item->formatted_total_harga }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-4">
                        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                Ringkasan Pesanan
                            </h2>

                            <!-- Items Summary -->
                            <div class="space-y-3 mb-6">
                                @foreach($cartItems as $item)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">
                                            {{ $item->unit->nama_unit }} ({{ $item->quantity }}x, {{ $item->duration }} hari)
                                        </span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ $item->formatted_total_harga }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Total -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Total
                                    </span>
                                    <span id="grandTotal" class="text-xl font-bold text-green-600 dark:text-green-400">
                                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <form action="{{ route('user.cart.checkout') }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors duration-200"
                                >
                                    Checkout Sekarang
                                </button>
                            </form>

                            <!-- Continue Shopping -->
                            <a
                                href="{{ route('user.tents.index') }}"
                                class="mt-3 w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-lg transition-colors duration-200"
                            >
                                Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-12">
                <svg class="h-32 w-32 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293A1 1 0 005 16h12M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    Keranjang Kosong
                </h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    Belum ada item dalam keranjang Anda. Yuk mulai berbelanja!
                </p>
                <a
                    href="{{ route('user.tents.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors duration-200"
                >
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>

    <!-- Success/Error Toast -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div id="toastContent" class="px-4 py-3 rounded-lg shadow-lg text-white font-medium">
        </div>
    </div>

    @push('scripts')
    <script>
        function updateCartItem(cartId, field, value) {
            // Gather all current form data for this cart item
            const cartItem = document.getElementById(`cartItem_${cartId}`);
            const formData = new FormData();

            if (field === 'quantity') {
                formData.append('quantity', value);
                formData.append('tanggal_mulai', cartItem.querySelector('input[type="date"]:nth-of-type(1)').value);
                formData.append('tanggal_selesai', cartItem.querySelector('input[type="date"]:nth-of-type(2)').value);
            } else if (field === 'tanggal_mulai') {
                formData.append('quantity', cartItem.querySelector('input[type="number"]').value);
                formData.append('tanggal_mulai', value);
                formData.append('tanggal_selesai', cartItem.querySelector('input[type="date"]:nth-of-type(2)').value);

                // Update minimum end date
                const endDateInput = cartItem.querySelector('input[type="date"]:nth-of-type(2)');
                const startDate = new Date(value);
                const minEndDate = new Date(startDate);
                minEndDate.setDate(minEndDate.getDate() + 1);
                endDateInput.min = minEndDate.toISOString().split('T')[0];

                if (new Date(endDateInput.value) <= startDate) {
                    endDateInput.value = minEndDate.toISOString().split('T')[0];
                    formData.set('tanggal_selesai', endDateInput.value);
                }
            } else if (field === 'tanggal_selesai') {
                formData.append('quantity', cartItem.querySelector('input[type="number"]').value);
                formData.append('tanggal_mulai', cartItem.querySelector('input[type="date"]:nth-of-type(1)').value);
                formData.append('tanggal_selesai', value);
            }

            fetch(`{{ route('user.cart.index') }}/${cartId}`, {
                method: 'PUT',
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
                    // Refresh page to update totals
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(data.message, 'error');
                    // Revert the input value on error
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            });
        }

        function removeFromCart(cartId) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                return;
            }

            fetch(`{{ route('user.cart.index') }}/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
            });
        }

        function clearCart() {
            if (!confirm('Apakah Anda yakin ingin mengosongkan seluruh keranjang?')) {
                return;
            }

            fetch('{{ route('user.cart.clear') }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
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
    </script>
    @endpush
</x-layouts.app>
