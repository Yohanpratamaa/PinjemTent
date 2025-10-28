<x-layouts.admin :title="__('Unit Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Unit Details</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Complete information for unit: <span class="font-medium">{{ $unit->kode_unit }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="primary" href="{{ route('admin.units.edit', $unit) }}" class="flex items-center gap-2">
                    <flux:icon.pencil class="size-4" />
                    Edit Unit
                </flux:button>
                <flux:button variant="outline" href="{{ route('admin.units.index') }}" class="flex items-center gap-2">
                    <flux:icon.arrow-left class="size-4" />
                    Back to Units
                </flux:button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Unit Photo Card -->
                @if($unit->foto && file_exists(public_path('images/units/' . $unit->foto)))
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Unit Photo</h3>
                    <div class="flex justify-center">
                        <img src="{{ asset('images/units/' . $unit->foto) }}"
                             alt="{{ $unit->nama_unit }}"
                             class="max-w-full h-64 object-cover rounded-lg border">
                    </div>
                </div>
                @endif

                <!-- Basic Details Card -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Unit Code</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $unit->kode_unit }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Unit Name</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ $unit->nama_unit }}</dd>
                        </div>
                        @if($unit->merk)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Brand/Merk</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ $unit->merk }}</dd>
                        </div>
                        @endif
                        @if($unit->kapasitas)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Capacity/Kapasitas</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ $unit->kapasitas }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                            <dd class="mt-1">
                                @switch($unit->status)
                                    @case('tersedia')
                                        <flux:badge color="green">Available</flux:badge>
                                        @break
                                    @case('disewa')
                                        <flux:badge color="blue">Rented</flux:badge>
                                        @break
                                    @case('maintenance')
                                        <flux:badge color="yellow">Maintenance</flux:badge>
                                        @break
                                    @default
                                        <flux:badge color="gray">Unknown</flux:badge>
                                @endswitch
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock Quantity</dt>
                            <dd class="mt-1 text-lg font-medium text-gray-900 dark:text-white">
                                {{ $unit->available_stock }}
                            </dd>
                        </div>
                        {{-- <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Available Stock</dt>
                            <dd class="mt-1 text-lg font-medium text-green-600 dark:text-green-400">
                                {{ $unit->available_stock }}
                                <span class="text-sm text-gray-500 dark:text-gray-400">({{ $unit->stok - $unit->active_rentals_count }} available)</span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Currently Rented</dt>
                            <dd class="mt-1 text-lg font-medium text-blue-600 dark:text-blue-400">
                                {{ $unit->active_rentals_count }}
                                <span class="text-sm text-gray-500 dark:text-gray-400">({{ $unit->active_rentals->count() }} rental(s))</span>
                            </dd>
                        </div> --}}
                    </dl>

                    @if($unit->deskripsi)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                            <dd class="mt-2 text-gray-900 dark:text-white">{{ $unit->deskripsi }}</dd>
                        </div>
                    @endif
                </div>

                <!-- Pricing Information Card -->
                @if($unit->harga_sewa_per_hari || $unit->denda_per_hari || $unit->harga_beli)
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Pricing Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @if($unit->harga_sewa_per_hari)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Harga Sewa per Hari</dt>
                            <dd class="mt-1 text-lg font-medium text-green-600 dark:text-green-400">
                                Rp {{ number_format($unit->harga_sewa_per_hari, 0, ',', '.') }}
                            </dd>
                        </div>
                        @endif
                        @if($unit->denda_per_hari)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Denda per Hari</dt>
                            <dd class="mt-1 text-lg font-medium text-red-600 dark:text-red-400">
                                Rp {{ number_format($unit->denda_per_hari, 0, ',', '.') }}
                            </dd>
                        </div>
                        @endif
                        @if($unit->harga_beli)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Harga Beli</dt>
                            <dd class="mt-1 text-lg font-medium text-blue-600 dark:text-blue-400">
                                Rp {{ number_format($unit->harga_beli, 0, ',', '.') }}
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
                @endif

                @if($unit->deskripsi)
                    <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Description</h3>
                        <p class="text-gray-900 dark:text-white">{{ $unit->deskripsi }}</p>
                    </div>
                @endif

                <!-- Categories Card -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Categories</h3>
                    @if($unit->kategoris->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($unit->kategoris as $kategori)
                                <flux:badge size="lg" color="blue">
                                    {{ $kategori->nama_kategori }}
                                </flux:badge>
                            @endforeach
                        </div>
                        <div class="mt-4 space-y-2">
                            @foreach($unit->kategoris as $kategori)
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>{{ $kategori->nama_kategori }}:</strong> {{ $kategori->deskripsi ?? 'No description available' }}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No categories assigned to this unit.</p>
                    @endif
                </div>

                <!-- Recent Rentals -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Rental History</h3>
                    @if(isset($stats['recent_rentals']) && $stats['recent_rentals']->count() > 0)
                        <div class="space-y-4">
                            @foreach($stats['recent_rentals'] as $peminjaman)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $peminjaman->user->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $peminjaman->tanggal_pinjam->format('M d, Y') }} -
                                            {{ $peminjaman->tanggal_kembali_rencana?->format('M d, Y') ?? 'No return date' }}
                                        </p>
                                        @if($peminjaman->tanggal_kembali_aktual)
                                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                                Actual return: {{ $peminjaman->tanggal_kembali_aktual->format('M d, Y') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        @switch($peminjaman->status)
                                            @case('dipinjam')
                                                <flux:badge color="blue">Currently Rented</flux:badge>
                                                @break
                                            @case('dikembalikan')
                                                <flux:badge color="green">Returned</flux:badge>
                                                @break
                                            @case('terlambat')
                                                <flux:badge color="red">Overdue</flux:badge>
                                                @break
                                            @case('pending')
                                                <flux:badge color="yellow">Pending</flux:badge>
                                                @break
                                            @case('dibatalkan')
                                                <flux:badge color="gray">Cancelled</flux:badge>
                                                @break
                                            @default
                                                <flux:badge color="gray">{{ ucfirst($peminjaman->status) }}</flux:badge>
                                        @endswitch
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            Qty: {{ $peminjaman->jumlah ?? 1 }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                            {{ $peminjaman->getFormattedHargaSewaTotal() }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($unit->peminjamans->count() > 5)
                            <div class="mt-4 text-center">
                                <flux:button variant="outline" size="sm">
                                    View All Rentals ({{ $unit->peminjamans->count() }})
                                </flux:button>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-6">
                            <flux:icon.document class="mx-auto h-12 w-12 text-gray-400" />
                            <h4 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No rental history</h4>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                This unit has not been rented yet.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Active Rentals Detail -->
                @if(isset($stats['active_rentals']) && $stats['active_rentals']->count() > 0)
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                        Currently Active Rentals
                        <flux:badge color="blue" class="ml-2">{{ $stats['active_rentals']->count() }} rental(s)</flux:badge>
                    </h3>
                    <div class="space-y-4">
                        @foreach($stats['active_rentals'] as $activeRental)
                            <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $activeRental->user->name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Code: {{ $activeRental->kode_peminjaman }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 ml-6">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <strong>Rental Period:</strong> {{ $activeRental->tanggal_pinjam->format('M d, Y') }} -
                                            {{ $activeRental->tanggal_kembali_rencana->format('M d, Y') }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <strong>Quantity:</strong> {{ $activeRental->jumlah ?? 1 }} unit(s)
                                        </p>
                                        @if($activeRental->is_terlambat)
                                            <p class="text-sm text-red-600 dark:text-red-400 font-medium">
                                                ⚠️ Overdue since {{ $activeRental->tanggal_kembali_rencana->format('M d, Y') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <flux:badge color="blue">Active</flux:badge>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $activeRental->getFormattedHargaSewaTotal() }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Rentals</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $stats['total_rentals'] ?? $unit->peminjamans->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Active Rentals</span>
                            <span class="font-medium text-blue-600 dark:text-blue-400">
                                {{ $stats['active_rentals_count'] ?? $unit->active_rentals_count }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Categories</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $unit->kategoris->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Stock</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $unit->stok }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Available Stock</span>
                            <span class="font-medium text-green-600 dark:text-green-400">
                                {{ $stats['available_stock'] ?? $unit->available_stock }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Availability Status</span>
                            <span class="font-medium">
                                @if($unit->is_available)
                                    <flux:badge color="green">Available</flux:badge>
                                @else
                                    <flux:badge color="red">Not Available</flux:badge>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h3>
                    <div class="space-y-3">
                        <flux:button variant="outline" class="w-full flex items-center gap-2" href="{{ route('admin.units.edit', $unit) }}">
                            <flux:icon.pencil class="size-4" />
                            Edit Unit
                        </flux:button>

                        {{-- @if($unit->status === 'tersedia')
                            <flux:button variant="outline" class="w-full flex items-center gap-2">
                                <flux:icon.plus class="size-4" />
                                Create Rental
                            </flux:button>
                        @endif --}}

                        <form
                            method="POST"
                            action="{{ route('admin.units.destroy', $unit) }}"
                            onsubmit="return confirm('Are you sure you want to delete this unit? This action cannot be undone.')"
                        >
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="danger" class="w-full flex items-center gap-2">
                                <div class="flex items-center gap-2">
                                    <flux:icon.trash class="size-4" />
                                    Delete Unit
                                </div>
                            </flux:button>
                        </form>
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Timestamps</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Created</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $unit->created_at->format('M d, Y at g:i A') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $unit->updated_at->format('M d, Y at g:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
