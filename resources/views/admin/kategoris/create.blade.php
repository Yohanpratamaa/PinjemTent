<x-layouts.admin :title="__('Create New Category')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Category</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Add a new category to organize tent units</p>
            </div>
            <flux:button variant="outline" href="{{ route('admin.kategoris.index') }}">
                <flux:icon.arrow-left class="size-4" />
                Back to Categories
            </flux:button>
        </div>

        <!-- Form Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <form method="POST" action="{{ route('admin.kategoris.store') }}" class="p-6 space-y-6">
                @csrf

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
                                    value="{{ old('nama_kategori') }}"
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
                                >{{ old('deskripsi') }}</flux:textarea>
                                <flux:description>Provide a detailed description to help users understand this category</flux:description>
                                @error('deskripsi')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Category Properties (Optional) -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Category Properties</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Capacity Range -->
                        <div>
                            <flux:field>
                                <flux:label>Typical Capacity</flux:label>
                                <flux:input
                                    name="kapasitas"
                                    placeholder="e.g., 2-4 persons, 6-8 persons"
                                    value="{{ old('kapasitas') }}"
                                />
                                <flux:description>Typical capacity or size range for units in this category</flux:description>
                                @error('kapasitas')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Usage Type -->
                        <div>
                            <flux:field>
                                <flux:label>Usage Type</flux:label>
                                <flux:select name="jenis_penggunaan" placeholder="Select usage type">
                                    <option value="">Select type</option>
                                    <option value="outdoor" {{ old('jenis_penggunaan') === 'outdoor' ? 'selected' : '' }}>
                                        Outdoor Activities
                                    </option>
                                    <option value="camping" {{ old('jenis_penggunaan') === 'camping' ? 'selected' : '' }}>
                                        Camping
                                    </option>
                                    <option value="hiking" {{ old('jenis_penggunaan') === 'hiking' ? 'selected' : '' }}>
                                        Hiking/Backpacking
                                    </option>
                                    <option value="family" {{ old('jenis_penggunaan') === 'family' ? 'selected' : '' }}>
                                        Family Recreation
                                    </option>
                                    <option value="event" {{ old('jenis_penggunaan') === 'event' ? 'selected' : '' }}>
                                        Events/Festivals
                                    </option>
                                    <option value="emergency" {{ old('jenis_penggunaan') === 'emergency' ? 'selected' : '' }}>
                                        Emergency/Relief
                                    </option>
                                </flux:select>
                                <flux:description>Primary intended use for units in this category</flux:description>
                                @error('jenis_penggunaan')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Assign Existing Units (Optional) -->
                @if($availableUnits->count() > 0)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Assign Existing Units</h3>
                        <flux:field>
                            <flux:label>Select Units to Include</flux:label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-2 max-h-60 overflow-y-auto border border-gray-200 dark:border-gray-600 rounded-lg p-4">
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
                                            <span class="font-medium">{{ $unit->kode_unit }}</span>
                                            <span class="text-gray-500">- {{ $unit->nama_unit }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <flux:description>Optional: You can assign existing units to this category now, or do it later</flux:description>
                            @error('units')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                @endif

                <!-- Form Actions -->
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button type="submit" variant="primary">
                        <flux:icon.plus class="size-4" />
                        Create Category
                    </flux:button>
                    <flux:button type="button" variant="outline" onclick="window.history.back()">
                        Cancel
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Example Categories -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <flux:icon.light-bulb class="size-5 text-blue-600 dark:text-blue-400 mt-0.5" />
                <div>
                    <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">Category Ideas</h4>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                            <div>
                                <p class="font-medium">By Size:</p>
                                <ul class="text-xs space-y-1 mt-1">
                                    <li>• Solo/1-Person Tents</li>
                                    <li>• Small (2-3 Person) Tents</li>
                                    <li>• Family (4-6 Person) Tents</li>
                                    <li>• Large Group (8+ Person) Tents</li>
                                </ul>
                            </div>
                            <div>
                                <p class="font-medium">By Purpose:</p>
                                <ul class="text-xs space-y-1 mt-1">
                                    <li>• Backpacking/Hiking Tents</li>
                                    <li>• Car Camping Tents</li>
                                    <li>• Emergency/Disaster Relief</li>
                                    <li>• Event/Festival Tents</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
