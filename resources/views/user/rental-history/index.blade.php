<x-layouts.app>
    <x-slot name="title">{{ __('Riwayat Penyewaan') }}</x-slot>

    <div class="p-6 lg:p-8 bg-white dark:bg-zinc-800 min-h-screen">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Riwayat Penyewaan</h1>
                    <p class="text-zinc-600 dark:text-zinc-400 mt-1">Kelola dan pantau semua riwayat penyewaan Anda</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Penyewaan</p>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $stats['total_rentals'] }}</p>
                        </div>
                        <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-lg p-4 border border-emerald-200 dark:border-emerald-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Sedang Dipinjam</p>
                            <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">{{ $stats['active_rentals'] }}</p>
                        </div>
                        <div class="p-2 bg-emerald-100 dark:bg-emerald-800 rounded-lg">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Total Pengeluaran</p>
                            <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">
                                {{ number_format($stats['total_spent'], 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-2 bg-purple-100 dark:bg-purple-800 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-4 border border-amber-200 dark:border-amber-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-amber-600 dark:text-amber-400">Kategori Favorit</p>
                            <p class="text-lg font-bold text-amber-900 dark:text-amber-100">{{ $stats['most_rented_category'] }}</p>
                        </div>
                        <div class="p-2 bg-amber-100 dark:bg-amber-800 rounded-lg">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
            <form method="GET" action="{{ route('user.rental-history.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <flux:field>
                            <flux:label>Status</flux:label>
                            <flux:select name="status" placeholder="Semua Status">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ $filters['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="disetujui" {{ $filters['status'] === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="dipinjam" {{ $filters['status'] === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="terlambat" {{ $filters['status'] === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="dikembalikan" {{ $filters['status'] === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                <option value="dibatalkan" {{ $filters['status'] === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </flux:select>
                        </flux:field>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <flux:field>
                            <flux:label>Tanggal Mulai</flux:label>
                            <flux:input type="date" name="start_date" value="{{ $filters['start_date'] }}" />
                        </flux:field>
                    </div>

                    <!-- End Date -->
                    <div>
                        <flux:field>
                            <flux:label>Tanggal Akhir</flux:label>
                            <flux:input type="date" name="end_date" value="{{ $filters['end_date'] }}" />
                        </flux:field>
                    </div>

                    <!-- Search -->
                    <div>
                        <flux:field>
                            <flux:label>Cari Unit</flux:label>
                            <flux:input type="text" name="search" placeholder="Nama unit atau merek..." value="{{ $filters['search'] }}" />
                        </flux:field>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2">
                    <flux:button type="submit" size="sm">
                        Filter
                    </flux:button>
                    <flux:button
                        type="button"
                        variant="outline"
                        size="sm"
                        onclick="window.location.href='{{ route('user.rental-history.index') }}'"
                    >
                        Reset
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Rental History Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            @if($rentals->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Unit
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Periode Sewa
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Jumlah
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Total Harga
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($rentals as $rental)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded-lg object-cover mr-3"
                                                 src="{{ $rental->unit->foto_url }}"
                                                 alt="{{ $rental->unit->nama_unit }}">
                                            <div>
                                                <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                                    {{ $rental->unit->nama_unit }}
                                                </div>
                                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                                    {{ $rental->unit->merek }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                            {{ \Carbon\Carbon::parse($rental->tanggal_pinjam)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                            s/d {{ \Carbon\Carbon::parse($rental->tanggal_kembali_rencana)->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                            {{ $rental->jumlah }} unit
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                            Rp {{ number_format($rental->harga_sewa_total, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                                'disetujui' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
                                                'dipinjam' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400',
                                                'terlambat' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                                                'dikembalikan' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
                                                'dibatalkan' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'
                                            ];

                                            // Determine if rental is late
                                            $isLate = $rental->is_terlambat;
                                            $displayStatus = $isLate ? 'terlambat' : $rental->status;
                                            $displayText = $isLate ? 'Terlambat' : ucfirst($rental->status);
                                        @endphp
                                        <div>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$displayStatus] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $displayText }}
                                            </span>

                                            <!-- Return status indicator -->
                                            @if($rental->status === 'dipinjam' && $rental->return_status === 'requested')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400 ml-1">
                                                    Pengembalian Diajukan
                                                </span>
                                            @endif

                                            @if($isLate)
                                                @php
                                                    $lateDays = now()->diffInDays($rental->tanggal_kembali_rencana);
                                                    $lateFee = $rental->calculateDendaTotal();
                                                @endphp
                                                <div class="text-xs text-red-600 dark:text-red-400 mt-1">
                                                    {{ $lateDays }} hari | Denda: Rp {{ number_format($lateFee, 0, ',', '.') }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <flux:button
                                                :href="route('user.rental-history.show', $rental->id)"
                                                variant="outline"
                                                size="sm"
                                                wire:navigate
                                            >
                                                Detail
                                            </flux:button>

                                            @if(in_array($rental->status, ['pending', 'disetujui']))
                                                <form id="cancelRentalForm_{{ $rental->id }}" action="{{ route('user.rental-history.cancel', $rental->id) }}"
                                                      method="POST"
                                                      class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <flux:button type="button" variant="danger" size="sm" onclick="confirmCancelRental({{ $rental->id }})">
                                                        Batal
                                                    </flux:button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $rentals->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-100">Belum ada riwayat penyewaan</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        @if(array_filter($filters))
                            Tidak ada penyewaan yang sesuai dengan filter yang dipilih.
                        @else
                            Mulai sewa peralatan camping untuk melihat riwayat di sini.
                        @endif
                    </p>
                    <div class="mt-6">
                        @if(array_filter($filters))
                            <flux:button
                                variant="outline"
                                onclick="window.location.href='{{ route('user.rental-history.index') }}'"
                            >
                                Reset Filter
                            </flux:button>
                        @else
                            <flux:button :href="route('user.tents.index')" wire:navigate>
                                Mulai Sewa
                            </flux:button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmCancelRental(rentalId) {
            Swal.fire({
                title: 'Batalkan Penyewaan?',
                text: 'Apakah Anda yakin ingin membatalkan penyewaan ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak',
                reverseButtons: true,
                customClass: {
                    popup: 'border-0 shadow-2xl',
                    title: 'text-lg font-semibold text-gray-900',
                    content: 'text-gray-600',
                    confirmButton: 'font-medium px-4 py-2 rounded-lg',
                    cancelButton: 'font-medium px-4 py-2 rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Membatalkan...',
                        text: 'Sedang memproses pembatalan penyewaan',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'border-0 shadow-2xl',
                            title: 'text-lg font-semibold text-gray-900',
                            content: 'text-gray-600'
                        }
                    });

                    // Submit the specific form
                    document.getElementById('cancelRentalForm_' + rentalId).submit();
                }
            });
        }

        // Show alerts for session flash messages
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                customClass: {
                    popup: 'border-0 shadow-2xl',
                    title: 'text-lg font-semibold text-green-800',
                    content: 'text-green-600'
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonColor: '#EF4444',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'border-0 shadow-2xl',
                    title: 'text-lg font-semibold text-red-800',
                    content: 'text-red-600',
                    confirmButton: 'font-medium px-4 py-2 rounded-lg'
                }
            });
        @endif
    </script>
    @endpush
</x-layouts.app>
