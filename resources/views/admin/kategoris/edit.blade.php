<x-layouts.admin :title="__('Edit Category')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Category</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Modify details for category: <span class="font-medium">{{ $kategori->nama_kategori }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="outline" href="{{ route('admin.kategoris.show', $kategori) }}">
                    <flux:icon.eye class="size-4" />
                    View Details
                </flux:button>
                <flux:button variant="outline" href="{{ route('admin.kategoris.index') }}">
                    <flux:icon.arrow-left class="size-4" />
                    Back to Categories
                </flux:button>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <form method="POST" action="{{ route('admin.kategoris.update', $kategori) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Category Information</h3>
                    <div class="space-y-6">
                        <!-- Category Name -->
                        <div>
                            <flux:field>
                                <flux:label>Category Name</flux:label>
                                <flux:input
                                    name="nama_kategori"
                                    placeholder="e.g., Family Tents, Camping Gear, Hiking Equipment"
                                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                    required
                                />
                                <flux:description>Enter a clear, descriptive name for the category</flux:description>
                                @error('nama_kategori')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Category Description -->
                        <div>
                            <flux:field>
                                <flux:label>Description</flux:label>
                                <flux:textarea
                                    name="deskripsi"
                                    placeholder="Describe what types of units belong to this category, their features, or intended use..."
                                    rows="4"
                                >{{ old('deskripsi', $kategori->deskripsi) }}</flux:textarea>
                                <flux:description>Provide a detailed description to help users understand this category</flux:description>
                                @error('deskripsi')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Assign Units -->
                @if($availableUnits->count() > 0 || $kategori->units->count() > 0)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Assigned Units</h3>
                        <flux:field>
                            <flux:label>Select Units to Include</flux:label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-2 max-h-60 overflow-y-auto border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                @foreach($allUnits as $unit)
                                    <div class="flex items-center">
                                        <input
                                            type="checkbox"
                                            id="unit_{{ $unit->id }}"
                                            name="units[]"
                                            value="{{ $unit->id }}"
                                            {{ in_array($unit->id, old('units', $kategori->units->pluck('id')->toArray())) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                        >
                                        <label
                                            for="unit_{{ $unit->id }}"
                                            class="ml-3 text-sm text-gray-700 dark:text-gray-300"
                                        >
                                            <span class="font-medium">{{ $unit->kode_unit }}</span>
                                            <span class="text-gray-500">- {{ $unit->nama_unit }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <flux:description>Select units that belong to this category</flux:description>
                            @error('units')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                @endif

                <!-- Form Actions -->
                                <!-- Form Actions -->
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button type="button" variant="primary" onclick="confirmUpdate()">
                        <div class="flex items-center gap-2">
                            <flux:icon.check class="size-4" />
                            <span>Update Category</span>
                        </div>
                    </flux:button>
                    <flux:button type="button" variant="outline" onclick="window.history.back()">
                        <div class="flex items-center gap-2">
                            <flux:icon.arrow-left class="size-4" />
                            <span>Cancel</span>
                        </div>
                    </flux:button>
                </div>
            </form>

            <!-- Delete Section (only if no units) -->
            @if($kategori->units->count() === 0)
                <div class="flex justify-end mt-4">
                    <flux:button type="button" variant="danger" onclick="confirmDelete()">
                        <div class="flex items-center gap-2">
                            <flux:icon.trash class="size-4" />
                            <span>Delete Category</span>
                        </div>
                    </flux:button>
                    <form id="delete-form" method="POST" action="{{ route('admin.kategoris.destroy', $kategori) }}" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @else
                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                    <div class="flex items-center gap-2">
                        <flux:icon.exclamation-triangle class="size-5 text-yellow-600 dark:text-yellow-400" />
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            This category cannot be deleted because it has {{ $kategori->units->count() }} unit(s) assigned to it.
                            Remove or reassign all units first before deleting this category.
                        </p>
                    </div>
                </div>
            @endif
            </form>

            <!-- Separate Delete Form - OUTSIDE of Update Form -->
            @if($kategori->units->count() === 0)
                <div class="flex justify-end mt-4">
                    <form
                        method="POST"
                        action="{{ route('admin.kategoris.destroy', $kategori) }}"
                        class="inline"
                        data-kategori-id="{{ $kategori->id }}"
                        data-kategori-name="{{ $kategori->nama_kategori }}"
                        onsubmit="return debugDeleteKategori('{{ $kategori->id }}', '{{ addslashes($kategori->nama_kategori) }}')"
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
            @endif
        </div>

        <!-- Category Statistics -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Category Statistics</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $kategori->units->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Units</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $kategori->units->where('status', 'tersedia')->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Available Units</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $kategori->units->where('status', 'disewa')->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Rented Units</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmUpdate() {
            // Get form data for preview
            const categoryName = document.querySelector('input[name="nama_kategori"]').value;
            const description = document.querySelector('textarea[name="deskripsi"]').value;

            // Basic validation
            if (!categoryName || categoryName.trim() === '') {
                Swal.fire({
                    title: 'Missing Information',
                    text: 'Please enter a category name before updating.',
                    icon: 'warning',
                    confirmButtonColor: '#F59E0B',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'border-0 shadow-2xl',
                        title: 'text-lg font-semibold text-gray-900',
                        content: 'text-gray-600',
                        confirmButton: 'font-medium px-4 py-2 rounded-lg'
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Update Category?',
                html: `
                    <div class="text-left">
                        <p class="text-gray-600 mb-3">You are about to update the category with the following details:</p>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg space-y-2">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Category Name:</span>
                                <span class="text-gray-900 dark:text-white">${categoryName}</span>
                            </div>
                            ${description ? `
                                <div class="mt-2">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Description:</span>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 bg-white dark:bg-gray-800 p-2 rounded">${description}</p>
                                </div>
                            ` : ''}
                        </div>
                        <p class="text-blue-600 dark:text-blue-400 text-sm mt-3">
                            <strong>Note:</strong> Changes will be saved and applied to all units in this category.
                        </p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3B82F6',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, Update Category',
                cancelButtonText: 'Review Again',
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
                        title: 'Updating Category...',
                        text: 'Please wait while we save the changes',
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
                    document.querySelector('form').submit();
                }
            });
        }

        function confirmDelete() {
            const categoryName = '{{ $kategori->nama_kategori }}';
            const unitCount = {{ $kategori->units->count() }};

            if (unitCount > 0) {
                Swal.fire({
                    title: 'Cannot Delete Category',
                    html: `
                        <div class="text-left">
                            <p class="text-gray-600 mb-2">The category "<strong>${categoryName}</strong>" cannot be deleted because:</p>
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-3 rounded-lg">
                                <p class="text-red-800 dark:text-red-200">
                                    It currently has <strong>${unitCount} unit(s)</strong> assigned to it.
                                </p>
                            </div>
                            <p class="text-blue-600 dark:text-blue-400 text-sm mt-3">
                                <strong>Suggestion:</strong> First remove or reassign all units from this category, then try deleting again.
                            </p>
                        </div>
                    `,
                    icon: 'error',
                    confirmButtonColor: '#EF4444',
                    confirmButtonText: 'Understood',
                    customClass: {
                        popup: 'border-0 shadow-2xl',
                        title: 'text-lg font-semibold text-gray-900',
                        content: 'text-gray-600',
                        confirmButton: 'font-medium px-4 py-2 rounded-lg'
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Delete Category?',
                html: `
                    <div class="text-left">
                        <p class="text-gray-600 mb-2">You are about to delete the category:</p>
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                            <p class="font-semibold text-gray-900 dark:text-white">${categoryName}</p>
                        </div>
                        <p class="text-red-600 dark:text-red-400 text-sm mt-3">
                            <strong>Warning:</strong> This action cannot be undone. The category will be permanently removed from the system.
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

                    // Submit the delete form
                    document.getElementById('delete-form').submit();
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

        @if($errors->any())
            Swal.fire({
                title: 'Validation Error!',
                html: `
                    <div class="text-left">
                        <p class="text-gray-600 mb-3">Please fix the following errors:</p>
                        <ul class="list-disc list-inside text-red-600 dark:text-red-400 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                `,
                icon: 'error',
                confirmButtonColor: '#EF4444',
                confirmButtonText: 'Fix Errors',
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
