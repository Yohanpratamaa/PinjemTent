<x-layouts.admin :title="__('Create Category')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Category</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Add a new category to organize your rental items
                </p>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="outline" href="{{ route('admin.kategoris.index') }}">
                    <div class="flex items-center gap-2">
                        <flux:icon.arrow-left class="size-4" />
                        <span>Back to Categories</span>
                    </div>
                </flux:button>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <form method="POST" action="{{ route('admin.kategoris.store') }}" class="p-6 space-y-6">
                @csrf

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Category Name -->
                        <div>
                            <flux:field>
                                <flux:label>Category Name</flux:label>
                                <flux:input
                                    name="nama_kategori"
                                    placeholder="e.g., Tenda Camping, Sleeping Bags, Cooking Equipment"
                                    value="{{ old('nama_kategori') }}"
                                    required
                                />
                                <flux:description>Unique name for the category</flux:description>
                                @error('nama_kategori')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Description -->
                        <div>
                            <flux:field>
                                <flux:label>Description</flux:label>
                                <flux:textarea
                                    name="deskripsi"
                                    placeholder="Describe what types of items belong to this category..."
                                    rows="4"
                                >{{ old('deskripsi') }}</flux:textarea>
                                <flux:description>Optional description to help users understand this category</flux:description>
                                @error('deskripsi')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Assign Units (Optional) -->
                @if($availableUnits->count() > 0)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Assign Units (Optional)</h3>
                        <flux:field>
                            <flux:label>Select Units to Add to This Category</flux:label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-2 max-h-64 overflow-y-auto border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                @foreach($availableUnits as $unit)
                                    <div class="flex items-center">
                                        <input
                                            type="checkbox"
                                            id="unit_{{ $unit->id }}"
                                            name="units[]"
                                            value="{{ $unit->id }}"
                                            {{ in_array($unit->id, old('units', [])) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                        >
                                        <label
                                            for="unit_{{ $unit->id }}"
                                            class="ml-3 text-sm text-gray-700 dark:text-gray-300"
                                        >
                                            <div>
                                                <span class="font-medium">{{ $unit->nama_unit }}</span>
                                                <span class="text-gray-500">({{ $unit->kode_unit }})</span>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                Stock: {{ $unit->stok }} • Status: {{ ucfirst($unit->status) }}
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <flux:description>You can assign units to this category now or add them later</flux:description>
                            @error('units')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                @endif

                <!-- Form Actions -->
                                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button variant="outline" href="{{ route('admin.kategoris.index') }}">
                        Cancel
                    </flux:button>
                    <flux:button type="button" variant="primary" onclick="confirmSubmit()">
                        <flux:icon.plus class="size-4" />
                        Create Category
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Tips Section -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <flux:icon.information-circle class="size-5 text-blue-600 dark:text-blue-400 mt-0.5" />
                <div>
                    <h3 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">Category Examples</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-700 dark:text-blue-200">
                        <div>
                            <p class="font-medium">By Size:</p>
                            <ul class="text-xs space-y-1 mt-1">
                                <li>• Small Tents (1-2 person)</li>
                                <li>• Medium Tents (3-4 person)</li>
                                <li>• Large Tents (5+ person)</li>
                                <li>• Group/Event Tents</li>
                            </ul>
                        </div>
                        <div>
                            <p class="font-medium">By Activity:</p>
                            <ul class="text-xs space-y-1 mt-1">
                                <li>• Hiking/Backpacking</li>
                                <li>• Car Camping</li>
                                <li>• Emergency/Disaster</li>
                                <li>• Events/Festivals</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmSubmit() {
            // Get form data for preview
            const categoryName = document.querySelector('input[name="nama_kategori"]').value;
            const description = document.querySelector('textarea[name="deskripsi"]').value;

            // Basic validation
            if (!categoryName || categoryName.trim() === '') {
                Swal.fire({
                    title: 'Missing Information',
                    text: 'Please enter a category name before creating the category.',
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
                title: 'Create New Category?',
                html: `
                    <div class="text-left">
                        <p class="text-gray-600 mb-3">You are about to create a new category with the following details:</p>
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
                        <p class="text-green-600 dark:text-green-400 text-sm mt-3">
                            <strong>Note:</strong> You can start assigning units to this category once it's created.
                        </p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, Create Category',
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
                        title: 'Creating Category...',
                        text: 'Please wait while we add the category',
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

        // Show alerts for session flash messages
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
            </form>
        </div>

        <!-- Category Examples -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <flux:icon.light-bulb class="size-5 text-blue-600 dark:text-blue-400 mt-0.5" />
                <div>
                    <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">Category Examples</h4>
                    <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-blue-700 dark:text-blue-200">
                        <div>
                            <p class="font-medium">By Equipment Type:</p>
                            <ul class="text-xs space-y-1 mt-1">
                                <li>• Tenda Camping</li>
                                <li>• Sleeping Bags</li>
                                <li>• Cooking Equipment</li>
                                <li>• Navigation Tools</li>
                                <li>• Safety Equipment</li>
                            </ul>
                        </div>
                        <div>
                            <p class="font-medium">By Size/Capacity:</p>
                            <ul class="text-xs space-y-1 mt-1">
                                <li>• Solo Equipment</li>
                                <li>• Small Group (2-4 people)</li>
                                <li>• Family Size (4-6 people)</li>
                                <li>• Large Group (8+ people)</li>
                            </ul>
                        </div>
                        <div>
                            <p class="font-medium">By Activity:</p>
                            <ul class="text-xs space-y-1 mt-1">
                                <li>• Hiking/Backpacking</li>
                                <li>• Car Camping</li>
                                <li>• Emergency/Disaster</li>
                                <li>• Events/Festivals</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
