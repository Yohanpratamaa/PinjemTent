<x-layouts.app>
    <x-slot name="title">{{ __('Detail Penyewaan #' . $rental->id) }}</x-slot>

    <div class="p-6 lg:p-8 bg-white dark:bg-zinc-800 min-h-screen">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <flux:button
                            :href="route('user.rental-history.index')"
                            variant="outline"
                            size="sm"
                            icon="arrow-left"
                            wire:navigate
                        >
                            Kembali
                        </flux:button>
                        <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">
                            Detail Penyewaan #{{ $rental->id }}
                        </h1>
                    </div>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        Dibuat pada {{ $rental->created_at->format('d F Y, H:i') }}
                    </p>
                </div>

                <div class="mt-4 sm:mt-0 flex space-x-2">
                    @if(in_array($rental->status, ['pending', 'disetujui']))
                        <form action="{{ route('user.rental-history.cancel', $rental->id) }}"
                              method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan penyewaan ini?')"
                              class="inline">
                            @csrf
                            @method('PATCH')
                            <flux:button type="submit" variant="danger" size="sm" icon="x-mark">
                                Batalkan Penyewaan
                            </flux:button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Status Badge -->
            <div class="mb-6">
                @php
                    $statusConfig = [
                        'pending' => [
                            'color' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/20 dark:text-yellow-400 dark:border-yellow-800',
                            'icon' => 'clock',
                            'message' => 'Menunggu persetujuan admin'
                        ],
                        'disetujui' => [
                            'color' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800',
                            'icon' => 'check-circle',
                            'message' => 'Penyewaan telah disetujui'
                        ],
                        'dipinjam' => [
                            'color' => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800',
                            'icon' => 'play',
                            'message' => 'Sedang dalam masa penyewaan'
                        ],
                        'dikembalikan' => [
                            'color' => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-900/20 dark:text-gray-400 dark:border-gray-800',
                            'icon' => 'check-circle',
                            'message' => 'Penyewaan telah selesai'
                        ],
                        'dibatalkan' => [
                            'color' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800',
                            'icon' => 'x-circle',
                            'message' => 'Penyewaan dibatalkan'
                        ]
                    ];
                    $config = $statusConfig[$rental->status] ?? $statusConfig['pending'];
                @endphp

                <div class="inline-flex items-center px-4 py-2 rounded-lg border {{ $config['color'] }}">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($config['icon'] === 'clock')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @elseif($config['icon'] === 'check-circle')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @elseif($config['icon'] === 'play')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1"></path>
                        @elseif($config['icon'] === 'x-circle')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @endif
                    </svg>
                    <span class="font-semibold">{{ ucfirst($rental->status) }}</span>
                    <span class="ml-2 text-sm opacity-75">{{ $config['message'] }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Unit Information -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Informasi Unit</h2>

                    <div class="flex flex-col md:flex-row md:items-start space-y-4 md:space-y-0 md:space-x-6">
                        @if($rental->unit->foto)
                            <img class="w-full md:w-48 h-32 object-cover rounded-lg"
                                 src="{{ asset('storage/' . $rental->unit->foto) }}"
                                 alt="{{ $rental->unit->nama_unit }}">
                        @else
                            <div class="w-full md:w-48 h-32 bg-zinc-200 dark:bg-zinc-700 rounded-lg flex items-center justify-center">
                                <svg class="w-12 h-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        @endif

                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-2">
                                {{ $rental->unit->nama_unit }}
                            </h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-zinc-500 dark:text-zinc-400">Merek:</span>
                                    <span class="ml-2 text-zinc-900 dark:text-zinc-100">{{ $rental->unit->merek }}</span>
                                </div>
                                <div>
                                    <span class="text-zinc-500 dark:text-zinc-400">Kondisi:</span>
                                    <span class="ml-2 text-zinc-900 dark:text-zinc-100">{{ $rental->unit->kondisi }}</span>
                                </div>
                                <div>
                                    <span class="text-zinc-500 dark:text-zinc-400">Kategori:</span>
                                    <span class="ml-2 text-zinc-900 dark:text-zinc-100">
                                        @foreach($rental->unit->kategoris as $kategori)
                                            <span class="inline-flex px-2 py-1 bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-400 text-xs rounded-full mr-1">
                                                {{ $kategori->nama_kategori }}
                                            </span>
                                        @endforeach
                                    </span>
                                </div>
                                <div>
                                    <span class="text-zinc-500 dark:text-zinc-400">Harga/Hari:</span>
                                    <span class="ml-2 text-zinc-900 dark:text-zinc-100 font-semibold">
                                        Rp {{ number_format($rental->unit->harga_sewa_per_hari, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            @if($rental->unit->deskripsi)
                                <div class="mt-4">
                                    <span class="text-zinc-500 dark:text-zinc-400 text-sm">Deskripsi:</span>
                                    <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">{{ $rental->unit->deskripsi }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Rental Timeline -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Timeline Penyewaan</h2>

                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Penyewaan Dibuat</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $rental->created_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>

                        @if($rental->status !== 'pending')
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-emerald-100 dark:bg-emerald-900/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        @if($rental->status === 'dibatalkan')
                                            Penyewaan Dibatalkan
                                        @else
                                            Penyewaan Disetujui
                                        @endif
                                    </p>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $rental->updated_at->format('d F Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if(in_array($rental->status, ['dipinjam', 'dikembalikan']))
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-purple-100 dark:bg-purple-900/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Periode Penyewaan Dimulai</p>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ \Carbon\Carbon::parse($rental->tanggal_pinjam)->format('d F Y') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($rental->status === 'dikembalikan')
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-gray-100 dark:bg-gray-900/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Unit Dikembalikan</p>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ \Carbon\Carbon::parse($rental->tanggal_kembali_rencana)->format('d F Y') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Additional Notes -->
                @if($rental->keterangan)
                    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Catatan</h2>
                        <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $rental->keterangan }}</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Rental Summary -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Ringkasan Penyewaan</h2>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Tanggal Mulai:</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                {{ \Carbon\Carbon::parse($rental->tanggal_pinjam)->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Tanggal Selesai:</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                {{ \Carbon\Carbon::parse($rental->tanggal_kembali_rencana)->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Durasi:</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                {{ \Carbon\Carbon::parse($rental->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($rental->tanggal_kembali_rencana)) + 1 }} hari
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Jumlah Unit:</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $rental->jumlah }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Harga per Hari:</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                Rp {{ number_format($rental->unit->harga_sewa_per_hari, 0, ',', '.') }}
                            </span>
                        </div>

                        <hr class="border-zinc-200 dark:border-zinc-700">

                        <div class="flex justify-between">
                            <span class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Total:</span>
                            <span class="text-base font-bold text-zinc-900 dark:text-zinc-100">
                                Rp {{ number_format($rental->harga_sewa_total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Aksi Cepat</h2>

                    <div class="space-y-3">
                        <flux:button
                            :href="route('user.tents.show', $rental->unit->id)"
                            variant="outline"
                            class="w-full justify-center"
                            wire:navigate
                        >
                            Lihat Unit
                        </flux:button>

                        <flux:button
                            :href="route('user.tents.index')"
                            variant="outline"
                            class="w-full justify-center"
                            wire:navigate
                        >
                            Sewa Lagi
                        </flux:button>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 p-6">
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">Butuh Bantuan?</h3>
                    <p class="text-sm text-blue-700 dark:text-blue-300 mb-4">
                        Hubungi tim support kami jika ada pertanyaan tentang penyewaan ini.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm text-blue-700 dark:text-blue-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            support@pinjemtent.com
                        </div>
                        <div class="flex items-center text-sm text-blue-700 dark:text-blue-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            +62 123 456 7890
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
