<x-layouts.admin :title="__('Edit Unit')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Unit</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Modify details for unit: <span class="font-medium">{{ $unit->kode_unit }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="outline" href="{{ route('admin.units.show', $unit) }}">
                    <flux:icon.eye class="size-4" />
                    View Details
                </flux:button>
                <flux:button variant="outline" href="{{ route('admin.units.index') }}">
                    <flux:icon.arrow-left class="size-4" />
                    Back to Units
                </flux:button>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <form method="POST" action="{{ route('admin.units.update', $unit) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

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
                                    value="{{ old('kode_unit', $unit->kode_unit) }}"
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
                                    value="{{ old('nama_unit', $unit->nama_unit) }}"
                                    required
                                />
                                <flux:description>Display name for the unit</flux:description>
                                @error('nama_unit')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Status -->
                        <div>
                            <flux:field>
                                <flux:label>Status</flux:label>
                                <flux:select name="status" placeholder="Select status" required>
                                    <option value="tersedia" {{ old('status', $unit->status) === 'tersedia' ? 'selected' : '' }}>
                                        Available
                                    </option>
                                    <option value="disewa" {{ old('status', $unit->status) === 'disewa' ? 'selected' : '' }}>
                                        Rented
                                    </option>
                                    <option value="maintenance" {{ old('status', $unit->status) === 'maintenance' ? 'selected' : '' }}>
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
                                    value="{{ old('stok', $unit->stok) }}"
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
                                        {{ in_array($category->id, old('kategoris', $unit->kategoris->pluck('id')->toArray())) ? 'checked' : '' }}
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
                        >{{ old('deskripsi', $unit->deskripsi) }}</flux:textarea>
                        <flux:description>Optional description for the unit</flux:description>
                        @error('deskripsi')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </flux:field>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button type="submit" variant="primary" class="flex items-center gap-2">
                        <flux:icon.check class="size-4" />
                        Update Unit
                    </flux:button>
                    <flux:button type="button" variant="outline" onclick="window.history.back()">
                        Cancel
                    </flux:button>

                    <!-- Delete Button -->
                    <div class="ml-auto">
                        <form
                            method="POST"
                            action="{{ route('admin.units.destroy', $unit) }}"
                            class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this unit? This action cannot be undone.')"
                        >
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="danger" class="flex items-center gap-2">
                                <flux:icon.trash class="size-4" />
                                Delete Unit
                            </flux:button>
                        </form>
                    </div>
                </div>
            </form>
        </div>

        <!-- Unit Activity History -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Activity</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                            <flux:icon.clock class="size-4 text-green-600 dark:text-green-400" />
                        </div>
                        <div>
                            <p class="text-gray-900 dark:text-white">Unit created</p>
                            <p class="text-gray-500 dark:text-gray-400">{{ $unit->created_at->format('M d, Y at g:i A') }}</p>
                        </div>
                    </div>

                    @if($unit->updated_at != $unit->created_at)
                        <div class="flex items-center gap-3 text-sm">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                                <flux:icon.pencil class="size-4 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white">Last updated</p>
                                <p class="text-gray-500 dark:text-gray-400">{{ $unit->updated_at->format('M d, Y at g:i A') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <flux:icon.exclamation-triangle class="size-5 text-yellow-600 dark:text-yellow-400 mt-0.5" />
                <div>
                    <h4 class="text-sm font-medium text-yellow-900 dark:text-yellow-100">Important notes</h4>
                    <ul class="mt-2 text-sm text-yellow-700 dark:text-yellow-200 space-y-1">
                        <li>• Changing the unit code may affect existing rental records</li>
                        <li>• Setting status to "Maintenance" will make the unit unavailable for new rentals</li>
                        <li>• Reducing stock below current rentals may cause conflicts</li>
                        <li>• Changes will be logged for audit purposes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
