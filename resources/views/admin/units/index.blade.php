<x-layouts.admin :title="__('Unit Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Unit Management</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage tent units and their categories</p>
            </div>
            <flux:button variant="primary" href="{{ route('admin.units.create') }}">
                <flux:icon.plus class="size-4" />
                Add New Unit
            </flux:button>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            <form method="GET" action="{{ route('admin.units.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <flux:input
                            name="search"
                            placeholder="Search units by code or name..."
                            value="{{ request('search') }}"
                        />
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <flux:select name="status" placeholder="Filter by status">
                            <option value="">All Status</option>
                            <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Available</option>
                            <option value="disewa" {{ request('status') === 'disewa' ? 'selected' : '' }}>Rented</option>
                            <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </flux:select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <flux:select name="category" placeholder="Filter by category">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <flux:button type="submit" variant="outline">
                        <flux:icon.magnifying-glass class="size-4" />
                        Search
                    </flux:button>
                    <flux:button type="button" variant="ghost" onclick="window.location.href='{{ route('admin.units.index') }}'">
                        Clear Filters
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                        <flux:icon.check class="size-5 text-green-600 dark:text-green-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Available</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['tersedia'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                        <flux:icon.clock class="size-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Rented</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['disewa'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-800">
                        <flux:icon.cog-6-tooth class="size-5 text-yellow-600 dark:text-yellow-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Maintenance</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['maintenance'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-800">
                        <flux:icon.cube class="size-5 text-purple-600 dark:text-purple-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Units</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $units->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Units Table -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
            @if($units->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Unit Code
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Unit Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Brand
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Capacity
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Categories
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Rental Price
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Last Updated
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($units as $unit)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $unit->kode_unit }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $unit->nama_unit }}</div>
                                        @if($unit->deskripsi)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                                {{ Str::limit($unit->deskripsi, 50) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $unit->merk ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $unit->kapasitas ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($unit->kategoris as $kategori)
                                                <flux:badge size="sm" color="blue">
                                                    {{ $kategori->nama_kategori }}
                                                </flux:badge>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-green-600 dark:text-green-400">
                                            {{ $unit->harga_sewa_per_hari ? 'Rp ' . number_format($unit->harga_sewa_per_hari, 0, ',', '.') : '-' }}
                                        </div>
                                        @if($unit->harga_sewa_per_hari)
                                            <div class="text-xs text-gray-500 dark:text-gray-400">per hari</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $unit->stok }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $unit->updated_at->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <flux:button
                                                size="sm"
                                                variant="ghost"
                                                href="{{ route('admin.units.show', $unit) }}"
                                                title="View Details"
                                            >
                                                <flux:icon.eye class="size-4" />
                                            </flux:button>
                                            <flux:button
                                                size="sm"
                                                variant="ghost"
                                                href="{{ route('admin.units.edit', $unit) }}"
                                                title="Edit Unit"
                                            >
                                                <flux:icon.pencil class="size-4" />
                                            </flux:button>
                                            <form
                                                method="POST"
                                                action="{{ route('admin.units.destroy', $unit) }}"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this unit?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <flux:button
                                                    size="sm"
                                                    variant="ghost"
                                                    type="submit"
                                                    title="Delete Unit"
                                                >
                                                    <flux:icon.trash class="size-4" />
                                                </flux:button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white dark:bg-neutral-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $units->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <flux:icon.cube class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No units found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Get started by creating a new unit.
                    </p>
                    <div class="mt-6">
                        <flux:button variant="primary" href="{{ route('admin.units.create') }}">
                            <flux:icon.plus class="size-4" />
                            Add New Unit
                        </flux:button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
