<x-layouts.admin :title="__('Category Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Category Details</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    View details for category: <span class="font-medium">{{ $kategori->nama_kategori }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="outline" href="{{ route('admin.kategoris.edit', $kategori) }}">
                    <div class="flex items-center gap-2">
                        <flux:icon.pencil class="size-4" />
                        <span>Edit Category</span>
                    </div>
                </flux:button>
                <flux:button variant="outline" href="{{ route('admin.kategoris.index') }}">
                    <div class="flex items-center gap-2">
                        <flux:icon.arrow-left class="size-4" />
                        <span>Back to Categories</span>
                    </div>
                </flux:button>
            </div>
        </div>

        <!-- Category Information -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Category Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category Name -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $kategori->nama_kategori }}</dd>
                    </div>

                    <!-- Description -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $kategori->deskripsi ?: 'No description provided' }}
                        </dd>
                    </div>

                    <!-- Created Date -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $kategori->created_at->format('M d, Y at g:i A') }}
                        </dd>
                    </div>

                    <!-- Last Updated -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $kategori->updated_at->format('M d, Y at g:i A') }}
                        </dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Associated Units -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Associated Units ({{ $kategori->units->count() }})
                    </h3>
                    @if($kategori->units->count() > 0)
                        <flux:button variant="outline" href="{{ route('admin.units.index', ['kategori' => $kategori->id]) }}">
                            <div class="flex items-center gap-2">
                                <flux:icon.arrow-top-right-on-square class="size-4" />
                                <span>View All Units</span>
                            </div>
                        </flux:button>
                    @endif
                </div>

                @if($kategori->units->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($kategori->units as $unit)
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 dark:text-white">{{ $unit->nama_unit }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $unit->kode_unit }}</p>

                                        <!-- Status Badge -->
                                        <div class="mt-2">
                                            @if($unit->status === 'tersedia')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                    Available
                                                </span>
                                            @elseif($unit->status === 'disewa')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100">
                                                    Rented
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                                    Maintenance
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Stock & Pricing Info -->
                                        <div class="mt-2 space-y-1">
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                Stock: <span class="font-medium">{{ $unit->stok }}</span>
                                            </p>
                                            @if($unit->harga_sewa_per_hari)
                                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                                    Rental: <span class="font-medium">Rp {{ number_format($unit->harga_sewa_per_hari, 0, ',', '.') }}/day</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <flux:button variant="ghost" href="{{ route('admin.units.show', $unit) }}" size="sm">
                                        <flux:icon.eye class="size-3" />
                                    </flux:button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="flex justify-center mb-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                <flux:icon.cube class="size-6 text-gray-400" />
                            </div>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">No units assigned</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            This category doesn't have any units assigned to it yet.
                        </p>
                        <div class="mt-4">
                            <flux:button variant="outline" href="{{ route('admin.kategoris.edit', $kategori) }}">
                                <div class="flex items-center gap-2">
                                    <flux:icon.plus class="size-4" />
                                    <span>Assign Units</span>
                                </div>
                            </flux:button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Category Statistics -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Category Statistics</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Total Units -->
                    <x-admin.stats-card
                        title="Total Units"
                        :value="$kategori->units->count()"
                        icon="cube"
                        color="blue"
                        subtitle="Units in this category"
                    />

                    <!-- Available Units -->
                    <x-admin.stats-card
                        title="Available"
                        :value="$kategori->units->where('status', 'tersedia')->sum('stok')"
                        icon="check-circle"
                        color="green"
                        subtitle="Ready for rent"
                    />

                    <!-- Rented Units -->
                    <x-admin.stats-card
                        title="Rented"
                        :value="$kategori->units->where('status', 'disewa')->sum('stok')"
                        icon="clock"
                        color="orange"
                        subtitle="Currently rented"
                    />

                    <!-- Total Stock -->
                    <x-admin.stats-card
                        title="Total Stock"
                        :value="$kategori->units->sum('stok')"
                        icon="chart-bar"
                        color="purple"
                        subtitle="Total inventory"
                    />
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3 pt-4">
            <flux:button variant="primary" href="{{ route('admin.kategoris.edit', $kategori) }}">
                <div class="flex items-center gap-2">
                    <flux:icon.pencil class="size-4" />
                    <span>Edit Category</span>
                </div>
            </flux:button>

            <!-- Delete Button -->
            <form
                method="POST"
                action="{{ route('admin.kategoris.destroy', $kategori) }}"
                class="inline"
                onsubmit="return confirm('Are you sure you want to delete this category? This will remove the category association from all units but will not delete the units themselves.')"
            >
                @csrf
                @method('DELETE')
                <flux:button type="submit" variant="danger">
                    <div class="flex items-center gap-2">
                        <flux:icon.trash class="size-4" />
                        <span>Delete Category</span>
                    </div>
                </flux:button>
            </form>
        </div>

        <!-- Help Section -->
        @if($kategori->units->count() > 0)
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                <div class="flex items-start gap-3">
                    <flux:icon.information-circle class="size-5 text-blue-600 dark:text-blue-400 mt-0.5" />
                    <div>
                        <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">Category Management</h4>
                        <ul class="mt-2 text-sm text-blue-700 dark:text-blue-200 space-y-1">
                            <li>• Deleting this category will not delete the associated units</li>
                            <li>• Units will simply lose their association with this category</li>
                            <li>• You can reassign units to other categories or create new ones</li>
                            <li>• Category statistics are calculated in real-time</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.admin>
