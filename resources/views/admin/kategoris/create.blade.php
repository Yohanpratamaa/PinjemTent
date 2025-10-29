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
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button type="submit" variant="primary">
                        <div class="flex items-center gap-2">
                            <flux:icon.plus class="size-4" />
                            <span>Create Category</span>
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
