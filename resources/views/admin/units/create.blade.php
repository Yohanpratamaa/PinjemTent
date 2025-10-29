<x-layouts.admin :title="__('Create New Unit')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Unit</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Add a new tent unit to the inventory</p>
            </div>
            <flux:button variant="outline" href="{{ route('admin.units.index') }}">
                <flux:icon.arrow-left class="size-4" />
                Back to Units
            </flux:button>
        </div>

        <!-- Form Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <form method="POST" action="{{ route('admin.units.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Unit Code -->
                        <div>
                            <flux:field>
                                <flux:label>Unit Code</flux:label>
                                <flux:input
                                    name="kode_unit"
                                    placeholder="e.g., TNT-001"
                                    value="{{ old('kode_unit') }}"
                                    required
                                />
                                <flux:description>Unique identifier for the unit</flux:description>
                                @error('kode_unit')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Unit Name -->
                        <div>
                            <flux:field>
                                <flux:label>Unit Name</flux:label>
                                <flux:input
                                    name="nama_unit"
                                    placeholder="e.g., Large Family Tent"
                                    value="{{ old('nama_unit') }}"
                                    required
                                />
                                <flux:description>Display name for the unit</flux:description>
                                @error('nama_unit')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Brand -->
                        <div>
                            <flux:field>
                                <flux:label>Brand/Merk</flux:label>
                                <flux:input
                                    name="merk"
                                    placeholder="e.g., Coleman, Eiger"
                                    value="{{ old('merk') }}"
                                />
                                <flux:description>Brand manufacturer of the unit</flux:description>
                                @error('merk')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Capacity -->
                        <div>
                            <flux:field>
                                <flux:label>Capacity/Kapasitas</flux:label>
                                <flux:input
                                    name="kapasitas"
                                    placeholder="e.g., 4 Orang, 60L, 2 Burner"
                                    value="{{ old('kapasitas') }}"
                                />
                                <flux:description>Capacity specification of the unit</flux:description>
                                @error('kapasitas')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Status -->
                        <div>
                            <flux:field>
                                <flux:label>Status</flux:label>
                                <flux:select name="status" placeholder="Select status" required>
                                    <option value="tersedia" {{ old('status') === 'tersedia' ? 'selected' : '' }}>
                                        Available
                                    </option>
                                    <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>
                                        Maintenance
                                    </option>
                                </flux:select>
                                <flux:description>Current status of the unit</flux:description>
                                @error('status')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Stock -->
                        <div>
                            <flux:field>
                                <flux:label>Stock Quantity</flux:label>
                                <flux:input
                                    type="number"
                                    name="stok"
                                    placeholder="1"
                                    value="{{ old('stok', 1) }}"
                                    min="0"
                                    required
                                />
                                <flux:description>Number of units available</flux:description>
                                @error('stok')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Photo Upload -->
                        <div class="md:col-span-2">
                            <flux:field>
                                <flux:label>Unit Photo</flux:label>
                                <input
                                    type="file"
                                    name="foto"
                                    accept="image/jpeg,image/png,image/jpg,image/gif"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                           file:mr-4 file:py-2 file:px-4
                                           file:rounded-lg file:border-0
                                           file:text-sm file:font-medium
                                           file:bg-blue-50 file:text-blue-700
                                           hover:file:bg-blue-100
                                           dark:file:bg-blue-900 dark:file:text-blue-300
                                           dark:hover:file:bg-blue-800"
                                />
                                <flux:description>Upload an image for this unit (JPEG, PNG, JPG, GIF - Max: 2MB)</flux:description>
                                @error('foto')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Pricing Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Pricing Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Harga Sewa per Hari -->
                        <div>
                            <flux:field>
                                <flux:label>Harga Sewa per Hari</flux:label>
                                <flux:input
                                    type="number"
                                    name="harga_sewa_per_hari"
                                    placeholder="50000"
                                    value="{{ old('harga_sewa_per_hari') }}"
                                    min="0"
                                    step="1000"
                                />
                                <flux:description>Rental price per day (IDR)</flux:description>
                                @error('harga_sewa_per_hari')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Denda per Hari -->
                        <div>
                            <flux:field>
                                <flux:label>Denda per Hari</flux:label>
                                <flux:input
                                    type="number"
                                    name="denda_per_hari"
                                    placeholder="10000"
                                    value="{{ old('denda_per_hari') }}"
                                    min="0"
                                    step="1000"
                                />
                                <flux:description>Late return penalty per day (IDR)</flux:description>
                                @error('denda_per_hari')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Harga Beli -->
                        <div>
                            <flux:field>
                                <flux:label>Harga Beli</flux:label>
                                <flux:input
                                    type="number"
                                    name="harga_beli"
                                    placeholder="1200000"
                                    value="{{ old('harga_beli') }}"
                                    min="0"
                                    step="10000"
                                />
                                <flux:description>Purchase price for inventory (IDR)</flux:description>
                                @error('harga_beli')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Categories</h3>
                    <flux:field>
                        <flux:label>Select Categories</flux:label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-2">
                            @foreach($categories as $category)
                                <div class="flex items-center">
                                    <input
                                        type="checkbox"
                                        id="category_{{ $category->id }}"
                                        name="kategoris[]"
                                        value="{{ $category->id }}"
                                        {{ in_array($category->id, old('kategoris', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                    >
                                    <label
                                        for="category_{{ $category->id }}"
                                        class="ml-3 text-sm text-gray-700 dark:text-gray-300"
                                    >
                                        {{ $category->nama_kategori }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <flux:description>Select one or more categories for this unit</flux:description>
                        @error('kategoris')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </flux:field>
                </div>

                <!-- Description (Optional) -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Information</h3>
                    <flux:field>
                        <flux:label>Description (Optional)</flux:label>
                        <flux:textarea
                            name="deskripsi"
                            placeholder="Add any additional information about this unit..."
                            rows="4"
                        >{{ old('deskripsi') }}</flux:textarea>
                        <flux:description>Optional description for the unit</flux:description>
                        @error('deskripsi')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </flux:field>
                </div>

                <!-- Form Actions -->
                                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button variant="outline" href="{{ route('admin.units.index') }}">
                        Cancel
                    </flux:button>
                    <flux:button type="button" variant="primary" onclick="confirmSubmit()">
                        <flux:icon.plus class="size-4" />
                        Create Unit
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Tips Section -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <flux:icon.information-circle class="size-5 text-blue-600 dark:text-blue-400 mt-0.5" />
                <div>
                    <h3 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">Tips for Creating Units</h3>
                    <ul class="mt-2 text-sm text-blue-700 dark:text-blue-200 space-y-1">
                        <li>• Use a consistent naming convention for unit codes (e.g., TNT-001, TNT-002)</li>
                        <li>• Make sure the unit code is unique across all units</li>
                        <li>• Select appropriate categories that describe the unit's features</li>
                        <li>• Set initial stock quantity based on available inventory</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmSubmit() {
            // Get form data for preview
            const unitCode = document.querySelector('input[name="kode_unit"]').value;
            const unitName = document.querySelector('input[name="nama_unit"]').value;
            const price = document.querySelector('input[name="harga_sewa_per_hari"]').value;
            const stock = document.querySelector('input[name="stok_tersedia"]').value;

            // Basic validation
            if (!unitCode || !unitName) {
                Swal.fire({
                    title: 'Missing Information',
                    text: 'Please fill in the required fields (Unit Code and Unit Name) before creating the unit.',
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
                title: 'Create New Unit?',
                html: `
                    <div class="text-left">
                        <p class="text-gray-600 mb-3">You are about to create a new unit with the following details:</p>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg space-y-2">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Unit Code:</span>
                                <span class="text-gray-900 dark:text-white">${unitCode}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Unit Name:</span>
                                <span class="text-gray-900 dark:text-white">${unitName}</span>
                            </div>
                            ${price ? `
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Rental Price:</span>
                                    <span class="text-green-600 dark:text-green-400">Rp ${parseInt(price).toLocaleString('id-ID')}/day</span>
                                </div>
                            ` : ''}
                            ${stock ? `
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Initial Stock:</span>
                                    <span class="text-blue-600 dark:text-blue-400">${stock} units</span>
                                </div>
                            ` : ''}
                        </div>
                        <p class="text-green-600 dark:text-green-400 text-sm mt-3">
                            <strong>Note:</strong> The unit will be available for rental once created.
                        </p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, Create Unit',
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
                        title: 'Creating Unit...',
                        text: 'Please wait while we add the unit to inventory',
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

        <!-- Help Section -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <flux:icon.information-circle class="size-5 text-blue-600 dark:text-blue-400 mt-0.5" />
                <div>
                    <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">Tips for creating units</h4>
                    <ul class="mt-2 text-sm text-blue-700 dark:text-blue-200 space-y-1">
                        <li>• Use a consistent naming convention for unit codes (e.g., TNT-001, TNT-002)</li>
                        <li>• Make sure the unit code is unique across all units</li>
                        <li>• Select appropriate categories that describe the unit's features</li>
                        <li>• Set initial stock quantity based on available inventory</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
