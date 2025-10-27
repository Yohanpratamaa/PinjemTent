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
            <form
                method="POST"
                action="{{ route('admin.units.update', $unit) }}"
                class="p-6 space-y-6"
                onsubmit="return debugUnitUpdateForm(this) && validateForm()"
                data-unit-id="{{ $unit->id }}"
                data-unit-name="{{ $unit->nama_unit }}"
            >
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
                                    value="{{ old('kode_unit', $unit->kode_unit ?? '') }}"
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
                                    value="{{ old('nama_unit', $unit->nama_unit ?? '') }}"
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
                                    value="{{ old('merk', $unit->merk) }}"
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
                                    value="{{ old('kapasitas', $unit->kapasitas) }}"
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
                                    placeholder="0"
                                    value="{{ old('stok', $unit->stok ?? 0) }}"
                                    min="0"
                                    step="1"
                                    required
                                    class="stock-input"
                                />
                                <flux:description>
                                    Number of units available (can be 0 or more)
                                    @if($unit->peminjamans()->where('status', 'dipinjam')->count() > 0)
                                        <br><span class="text-amber-600 dark:text-amber-400">
                                            Note: {{ $unit->peminjamans()->where('status', 'dipinjam')->count() }} unit(s) currently rented
                                        </span>
                                    @endif
                                </flux:description>
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
                                    value="{{ old('harga_sewa_per_hari', $unit->harga_sewa_per_hari) }}"
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
                                    value="{{ old('denda_per_hari', $unit->denda_per_hari) }}"
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
                                    value="{{ old('harga_beli', $unit->harga_beli) }}"
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
                    <flux:button type="submit" variant="primary" onclick="return validateForm()">
                        <div class="flex items-center gap-2">
                            <flux:icon.check class="size-4" />
                            <span>Update Unit</span>
                        </div>
                    </flux:button>
                    <flux:button type="button" variant="outline" onclick="window.history.back()">
                        <div class="flex items-center gap-2">
                            <flux:icon.arrow-left class="size-4" />
                            <span>Cancel</span>
                        </div>
                    </flux:button>

                    <!-- Delete Button -->
                    <div class="ml-auto">
                        <form
                            method="POST"
                            action="{{ route('admin.units.destroy', $unit) }}"
                            class="inline"
                            data-unit-id="{{ $unit->id }}"
                            data-unit-name="{{ $unit->nama_unit }}"
                            onsubmit="return debugDeleteUnit('{{ $unit->id }}', '{{ addslashes($unit->nama_unit) }}')"
                        >
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="danger">
                                <div class="flex items-center gap-2">
                                    <flux:icon.trash class="size-4" />
                                    <span>Delete Unit</span>
                                </div>
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

    <script>
        // Separate function for update form debugging
        function debugUnitUpdateForm(formElement) {
            const formData = new FormData(formElement);
            console.log('🔄 UNIT UPDATE Form Debug ===');
            console.log('Form Action:', formElement.action);
            console.log('Form Method:', formElement.method);

            for (let [key, value] of formData.entries()) {
                console.log(`${key}: "${value}" (${typeof value})`);
            }
            console.log('=== End Update Debug ===');
            return true; // Allow form submission
        }

        function debugFormData(event) {
            const formData = new FormData(event.target);
            console.log('=== Form Data Debug ===');
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: "${value}" (${typeof value})`);
            }
            console.log('=== End Debug ===');

            // Pastikan stok tidak kosong sebelum submit
            const stokInput = document.querySelector('input[name="stok"]');
            if (!stokInput.value || stokInput.value.trim() === '') {
                console.warn('Empty stock detected, setting to current value:', {{ $unit->stok }});
                stokInput.value = {{ $unit->stok }};
            }
        }

        function validateForm() {
            const stokInput = document.querySelector('input[name="stok"]');
            let stokValue = stokInput.value.trim();

            // Jika kosong, set ke nilai saat ini
            if (!stokValue || stokValue === '') {
                console.warn('Empty stock input detected, using current stock value');
                stokInput.value = {{ $unit->stok }};
                stokValue = {{ $unit->stok }};
            }

            const stokInt = parseInt(stokValue);
            const minActiveRentals = {{ $unit->peminjamans()->where('status', 'dipinjam')->count() }};

            // Validasi stok tidak negatif (boleh 0)
            if (isNaN(stokInt) || stokInt < 0) {
                alert('Stock quantity harus berupa angka dan tidak boleh negatif!');
                stokInput.focus();
                return false;
            }

            // Validasi stok tidak kurang dari yang sedang dipinjam
            if (minActiveRentals > 0 && stokInt < minActiveRentals) {
                alert(`Stock tidak boleh kurang dari ${minActiveRentals} karena masih ada unit yang dipinjam!`);
                stokInput.focus();
                return false;
            }

            // Validasi stock terlalu besar
            if (stokInt > 1000) {
                return confirm('Stock yang dimasukkan cukup besar (' + stokInt + '). Apakah Anda yakin?');
            }

            return true;
        }

        // Real-time validation saat user mengetik
        document.addEventListener('DOMContentLoaded', function() {
            const stokInput = document.querySelector('input[name="stok"]');
            const minActiveRentals = {{ $unit->peminjamans()->where('status', 'dipinjam')->count() }};
            const currentStock = {{ $unit->stok }};

            // Pastikan nilai awal tidak kosong
            if (!stokInput.value || stokInput.value.trim() === '') {
                stokInput.value = currentStock;
            }

            // Remove oninput restriction untuk lebih fleksibel
            stokInput.removeAttribute('oninput');

            stokInput.addEventListener('input', function() {
                let value = this.value.trim();

                // Allow temporary empty for editing
                if (value === '') {
                    return; // Allow empty during editing
                }

                let intValue = parseInt(value);

                // Pastikan tidak negatif
                if (intValue < 0 || isNaN(intValue)) {
                    this.style.borderColor = '#ef4444';
                    this.style.boxShadow = '0 0 0 1px #ef4444';
                } else if (minActiveRentals > 0 && intValue < minActiveRentals) {
                    // Warning jika kurang dari rental aktif
                    this.style.borderColor = '#f59e0b';
                    this.style.boxShadow = '0 0 0 1px #f59e0b';
                } else {
                    this.style.borderColor = '';
                    this.style.boxShadow = '';
                }
            });

            // Validasi saat blur (kehilangan focus)
            stokInput.addEventListener('blur', function() {
                let value = this.value.trim();
                if (value === '' || parseInt(value) < 0) {
                    this.value = Math.max(currentStock, minActiveRentals, 0);
                }
            });
        });
    </script>

    <!-- Debug Script -->
    <script src="{{ asset('js/unit-debug.js') }}"></script>
</x-layouts.admin>
