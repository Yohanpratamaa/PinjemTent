<x-layouts.app :title="'Sewa ' . $tent->nama_unit">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Back Button -->
        <div class="flex items-center gap-4">
            <a
                href="{{ route('user.tents.show', $tent) }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Detail
            </a>
        </div>

        <!-- Header -->
        <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Sewa {{ $tent->nama_unit }}
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Isi form di bawah untuk menyewa tenda ini
                    </p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Product Summary -->
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Ringkasan Produk
                </h3>

                <div class="flex gap-4 mb-4">
                    <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                        @if($tent->foto)
                            <img
                                src="{{ asset('storage/' . $tent->foto) }}"
                                alt="{{ $tent->nama_unit }}"
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
                    <div class="flex-1">
                        @if($tent->merk)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ $tent->merk }}</p>
                        @endif
                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $tent->nama_unit }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Kode: {{ $tent->kode_unit }}</p>
                    </div>
                </div>

                <div class="space-y-3 border-t border-gray-100 dark:border-gray-700 pt-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Harga Sewa</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $tent->getFormattedHargaSewaPerHari() }}/hari</span>
                    </div>
                    @if($tent->denda_per_hari)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Denda Keterlambatan</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $tent->getFormattedDendaPerHari() }}/hari</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Stok Tersedia</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $tent->available_stock }} unit</span>
                    </div>
                </div>
            </div>

            <!-- Rental Form -->
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Form Peminjaman
                </h3>

                <form method="POST" action="{{ route('user.tents.store-rental', $tent) }}" class="space-y-4">
                    @csrf

                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Mulai Sewa <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            id="tanggal_mulai"
                            name="tanggal_mulai"
                            value="{{ old('tanggal_mulai') }}"
                            min="{{ date('Y-m-d') }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                        >
                        @error('tanggal_mulai')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Selesai Sewa <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            id="tanggal_selesai"
                            name="tanggal_selesai"
                            value="{{ old('tanggal_selesai') }}"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                        >
                        @error('tanggal_selesai')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jumlah Unit <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="jumlah"
                            name="jumlah"
                            value="{{ old('jumlah', 1) }}"
                            min="1"
                            max="{{ $tent->available_stock }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                        >
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Maksimal {{ $tent->available_stock }} unit tersedia
                        </p>
                        @error('jumlah')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea
                            id="catatan"
                            name="catatan"
                            rows="3"
                            placeholder="Masukkan catatan atau permintaan khusus..."
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                        >{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estimasi Biaya -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Estimasi Biaya</h4>
                        <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex justify-between">
                                <span>Durasi sewa:</span>
                                <span id="duration">- hari</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Jumlah unit:</span>
                                <span id="quantity">1 unit</span>
                            </div>
                            <div class="flex justify-between font-medium text-gray-900 dark:text-white border-t border-gray-200 dark:border-gray-600 pt-2">
                                <span>Total Estimasi:</span>
                                <span id="total">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button
                            type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200"
                        >
                            Kirim Permintaan Sewa
                        </button>
                        <p class="text-xs text-gray-500 dark:text-gray-400 text-center mt-2">
                            Dengan mengirim form ini, Anda menyetujui syarat dan ketentuan kami
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for cost calculation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('tanggal_mulai');
            const endDateInput = document.getElementById('tanggal_selesai');
            const quantityInput = document.getElementById('jumlah');
            const pricePerDay = {{ $tent->harga_sewa_per_hari }};

            function calculateCost() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);
                const quantity = parseInt(quantityInput.value) || 1;

                if (startDate && endDate && endDate > startDate) {
                    const timeDiff = endDate.getTime() - startDate.getTime();
                    const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                    document.getElementById('duration').textContent = daysDiff + ' hari';
                    document.getElementById('quantity').textContent = quantity + ' unit';

                    const total = daysDiff * quantity * pricePerDay;
                    document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
                } else {
                    document.getElementById('duration').textContent = '- hari';
                    document.getElementById('quantity').textContent = quantity + ' unit';
                    document.getElementById('total').textContent = 'Rp 0';
                }
            }

            startDateInput.addEventListener('change', calculateCost);
            endDateInput.addEventListener('change', calculateCost);
            quantityInput.addEventListener('input', calculateCost);

            // Update minimum end date when start date changes
            startDateInput.addEventListener('change', function() {
                if (this.value) {
                    const startDate = new Date(this.value);
                    const nextDay = new Date(startDate);
                    nextDay.setDate(startDate.getDate() + 1);
                    endDateInput.min = nextDay.toISOString().split('T')[0];
                }
            });

            // Initial calculation
            calculateCost();
        });
    </script>
</x-layouts.app>
