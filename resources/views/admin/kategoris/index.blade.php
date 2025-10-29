<x-layouts.admin :title="__('Category Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Category Management</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Organize tent units by categories</p>
            </div>
            <flux:button variant="primary" href="{{ route('admin.kategoris.create') }}">
                <flux:icon.plus class="size-4" />
                Add New Category
            </flux:button>
        </div>

        <!-- Search Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            <form method="GET" action="{{ route('admin.kategoris.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <flux:input
                            name="search"
                            placeholder="Search categories by name or description..."
                            value="{{ request('search') }}"
                        />
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <flux:select name="sort" placeholder="Sort by">
                            <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                            <option value="units_desc" {{ request('sort') === 'units_desc' ? 'selected' : '' }}>Most Units</option>
                            <option value="created_desc" {{ request('sort') === 'created_desc' ? 'selected' : '' }}>Newest First</option>
                        </flux:select>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <flux:button type="submit" variant="outline">
                        <div class="flex items-center gap-2">
                            <flux:icon.magnifying-glass class="size-4" />
                            <span>Search</span>
                        </div>
                    </flux:button>
                    <flux:button type="button" variant="ghost" onclick="window.location.href='{{ route('admin.kategoris.index') }}'">
                        Clear Filters
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                        <flux:icon.tag class="size-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Categories</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $kategoris->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                        <flux:icon.squares-2x2 class="size-5 text-green-600 dark:text-green-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Units</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_units'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-800">
                        <flux:icon.chart-bar class="size-5 text-purple-600 dark:text-purple-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Avg Units/Category</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['avg_units'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100 dark:bg-orange-800">
                        <flux:icon.folder class="size-5 text-orange-600 dark:text-orange-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Empty Categories</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['empty_categories'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
            @if($kategoris->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                    @foreach($kategoris as $kategori)
                        <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-6 hover:shadow-md transition-shadow">
                            <!-- Category Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $kategori->nama_kategori }}
                                    </h3>
                                    @if($kategori->deskripsi)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-3">
                                            {{ $kategori->deskripsi }}
                                        </p>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <flux:badge color="blue">
                                        {{ $kategori->units_count }} units
                                    </flux:badge>
                                </div>
                            </div>

                            <!-- Unit Examples -->
                            @if($kategori->units->count() > 0)
                                <div class="mb-4">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                                        Related Units
                                    </p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($kategori->units->take(3) as $unit)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200">
                                                {{ $unit->kode_unit }}
                                            </span>
                                        @endforeach
                                        @if($kategori->units->count() > 3)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-300">
                                                +{{ $kategori->units->count() - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600">
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    Updated {{ $kategori->updated_at->diffForHumans() }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <flux:button
                                        size="sm"
                                        variant="ghost"
                                        href="{{ route('admin.kategoris.show', $kategori) }}"
                                        title="View Details"
                                    >
                                        <flux:icon.eye class="size-4" />
                                    </flux:button>
                                    <flux:button
                                        size="sm"
                                        variant="ghost"
                                        href="{{ route('admin.kategoris.edit', $kategori) }}"
                                        title="Edit Category"
                                    >
                                        <flux:icon.pencil class="size-4" />
                                    </flux:button>
                                    @if($kategori->units->count() === 0)
                                        <flux:button
                                            size="sm"
                                            variant="ghost"
                                            type="button"
                                            title="Delete Category"
                                            onclick="confirmDelete('{{ $kategori->id }}', '{{ $kategori->nama_kategori }}')"
                                        >
                                            <flux:icon.trash class="size-4" />
                                        </flux:button>
                                        <form id="delete-form-{{ $kategori->id }}" method="POST" action="{{ route('admin.kategoris.destroy', $kategori) }}" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @else
                                        <flux:button
                                            size="sm"
                                            variant="ghost"
                                            type="button"
                                            title="Cannot delete - category has units"
                                            onclick="showCannotDeleteAlert('{{ $kategori->nama_kategori }}', {{ $kategori->units->count() }})"
                                            disabled
                                        >
                                            <flux:icon.trash class="size-4 text-gray-400" />
                                        </flux:button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="bg-white dark:bg-neutral-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $kategoris->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <flux:icon.tag class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No categories found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Get started by creating a new category.
                    </p>
                    <div class="mt-6">
                        <flux:button variant="primary" href="{{ route('admin.kategoris.create') }}">
                            <flux:icon.plus class="size-4" />
                            Add New Category
                        </flux:button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(categoryId, categoryName) {
            Swal.fire({
                title: 'Delete Category?',
                html: `
                    <div class="text-left">
                        <p class="text-gray-600 mb-2">You are about to delete the category:</p>
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                            <p class="font-semibold text-gray-900 dark:text-white">${categoryName}</p>
                        </div>
                        <p class="text-red-600 dark:text-red-400 text-sm mt-3">
                            <strong>Warning:</strong> This action cannot be undone. Make sure no units are assigned to this category before deleting.
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, Delete Category',
                cancelButtonText: 'Cancel',
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
                        title: 'Deleting Category...',
                        text: 'Please wait while we remove the category',
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

                    // Submit the form
                    document.getElementById(`delete-form-${categoryId}`).submit();
                }
            });
        }

        function showCannotDeleteAlert(categoryName, unitCount) {
            Swal.fire({
                title: 'Cannot Delete Category',
                html: `
                    <div class="text-left">
                        <p class="text-gray-600 mb-2">The category "<strong>${categoryName}</strong>" cannot be deleted because:</p>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 p-3 rounded-lg">
                            <p class="text-yellow-800 dark:text-yellow-200">
                                It currently has <strong>${unitCount} unit(s)</strong> assigned to it.
                            </p>
                        </div>
                        <p class="text-blue-600 dark:text-blue-400 text-sm mt-3">
                            <strong>Suggestion:</strong> First remove or reassign all units from this category, then try deleting again.
                        </p>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#3B82F6',
                confirmButtonText: 'Understood',
                customClass: {
                    popup: 'border-0 shadow-2xl',
                    title: 'text-lg font-semibold text-gray-900',
                    content: 'text-gray-600',
                    confirmButton: 'font-medium px-4 py-2 rounded-lg'
                }
            });
        }

        // Show alerts for session flash messages
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
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
                title: 'Error!',
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
</x-layouts.admin>
