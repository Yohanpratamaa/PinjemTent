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
            <form method="POST" action="{{ route('admin.units.store') }}" class="p-6 space-y-6">
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
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button type="submit" variant="primary">
                        <div class="flex items-center gap-2">
                            <flux:icon.plus class="size-4" />
                            <span>Create Unit</span>
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
