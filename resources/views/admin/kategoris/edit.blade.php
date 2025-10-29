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
                                    name="deskripsi_kategori"
                                    placeholder="Describe what types of units belong to this category, their features, or intended use..."
                                    rows="4"
                                >{{ old('deskripsi_kategori', $kategori->deskripsi_kategori) }}</flux:textarea>
                                <flux:description>Provide a detailed description to help users understand this category</flux:description>
                                @error('deskripsi_kategori')
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
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button type="submit" variant="primary">
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

    <script>
        // Debug function for category update form
        function debugKategoriUpdateForm(formElement) {
            const formData = new FormData(formElement);
            console.log('🔄 KATEGORI UPDATE Form Debug ===');
            console.log('IMPORTANT: This is UPDATE operation, NOT DELETE');
            console.log('Form Action:', formElement.action);
            console.log('Form Method:', formElement.method);

            // Critical validation - ensure this is update form
            if (formElement.action.includes('destroy')) {
                console.error('🚨 CRITICAL ERROR: Update form has DELETE action!');
                alert('ERROR: Form configuration error detected! This form is trying to DELETE instead of UPDATE. Please contact administrator.');
                return false; // Prevent submission
            }

            // Check for proper method override
            const methodInput = formElement.querySelector('input[name="_method"]');
            if (methodInput && methodInput.value === 'PUT') {
                console.log('✅ Correct method override found: PUT');
            } else {
                console.warn('⚠️ Method override issue detected');
            }

            for (let [key, value] of formData.entries()) {
                console.log(`${key}: "${value}" (${typeof value})`);
            }
            console.log('=== End Kategori Update Debug ===');
            return true; // Allow form submission
        }

        // Debug function for category delete
        function debugDeleteKategori(kategoriId, kategoriName) {
            console.group("🗑️ Delete Kategori Debug");
            console.log("IMPORTANT: This is a DELETE operation, not UPDATE");
            console.log("Kategori ID:", kategoriId);
            console.log("Kategori Name:", kategoriName);
            console.log("Timestamp:", new Date().toISOString());
            console.log("Action: DELETE KATEGORI (Permanent)");

            const confirmed = confirm(
                `⚠️ DELETE CONFIRMATION ⚠️\n\nAre you sure you want to PERMANENTLY DELETE category "${kategoriName}"?\n\nThis action CANNOT be undone!\n\nClick OK to DELETE or Cancel to abort.`
            );
            console.log("User Confirmed Delete:", confirmed);
            console.groupEnd();

            if (confirmed) {
                console.warn("🗑️ DELETE CONFIRMED - Kategori will be deleted!");
            } else {
                console.log("✅ DELETE CANCELLED - Kategori will not be deleted");
            }

            return confirmed;
        }

        // Add form event listener
        document.addEventListener('DOMContentLoaded', function() {
            const updateForm = document.querySelector('form[action*="kategoris"][method="POST"]:not([action*="destroy"])');
            if (updateForm) {
                updateForm.addEventListener('submit', function(e) {
                    if (!debugKategoriUpdateForm(this)) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
        });
    </script>

    <!-- Debug Script -->
    <script src="{{ asset('js/kategori-debug.js') }}"></script>
</x-layouts.admin>
