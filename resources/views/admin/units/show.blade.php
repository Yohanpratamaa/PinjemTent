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
                <flux:button variant="primary" href="{{ route('admin.units.edit', $unit) }}">
                    <flux:icon.pencil class="size-4" />
                    Edit Unit
                </flux:button>
                <flux:button variant="outline" href="{{ route('admin.units.index') }}">
                    <flux:icon.arrow-left class="size-4" />
                    Back to Units
                </flux:button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="lg:col-span-2 space-y-6">
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
                            <dd class="mt-1 text-lg font-medium text-gray-900 dark:text-white">{{ $unit->stok }}</dd>
                        </div>
                    </dl>

                    @if($unit->deskripsi)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                            <dd class="mt-2 text-gray-900 dark:text-white">{{ $unit->deskripsi }}</dd>
                        </div>
                    @endif
                </div>

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
                    @if($unit->peminjamans->count() > 0)
                        <div class="space-y-4">
                            @foreach($unit->peminjamans->take(5) as $peminjaman)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $peminjaman->user->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $peminjaman->tanggal_pinjam->format('M d, Y') }} -
                                            {{ $peminjaman->tanggal_kembali?->format('M d, Y') ?? 'Not returned' }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        @switch($peminjaman->status)
                                            @case('active')
                                                <flux:badge color="blue">Active</flux:badge>
                                                @break
                                            @case('returned')
                                                <flux:badge color="green">Returned</flux:badge>
                                                @break
                                            @case('overdue')
                                                <flux:badge color="red">Overdue</flux:badge>
                                                @break
                                            @default
                                                <flux:badge color="gray">{{ ucfirst($peminjaman->status) }}</flux:badge>
                                        @endswitch
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            Qty: {{ $peminjaman->jumlah }}
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
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Rentals</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $unit->peminjamans->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Active Rentals</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $unit->peminjamans->where('status', 'active')->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Categories</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $unit->kategoris->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Available Stock</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $unit->stok }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h3>
                    <div class="space-y-3">
                        <flux:button variant="outline" class="w-full" href="{{ route('admin.units.edit', $unit) }}">
                            <flux:icon.pencil class="size-4" />
                            Edit Unit
                        </flux:button>

                        @if($unit->status === 'tersedia')
                            <flux:button variant="outline" class="w-full">
                                <flux:icon.plus class="size-4" />
                                Create Rental
                            </flux:button>
                        @endif

                        <form
                            method="POST"
                            action="{{ route('admin.units.destroy', $unit) }}"
                            onsubmit="return confirm('Are you sure you want to delete this unit? This action cannot be undone.')"
                        >
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="danger" class="w-full">
                                <flux:icon.trash class="size-4" />
                                Delete Unit
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
