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
                enctype="multipart/form-data"
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

                        <!-- Photo Upload -->
                        <div class="md:col-span-2">
                            <flux:field>
                                <flux:label>Unit Photo</flux:label>
                                @if($unit->foto && file_exists(public_path('images/units/' . $unit->foto)))
                                    <div class="mb-3">
                                        <img src="{{ asset('images/units/' . $unit->foto) }}"
                                             alt="{{ $unit->nama_unit }}"
                                             class="w-32 h-32 object-cover rounded-lg border">
                                        <p class="text-sm text-gray-500 mt-1">Current photo</p>
                                    </div>
                                @endif
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
                                <flux:description>Upload a new image for this unit (JPEG, PNG, JPG, GIF - Max: 2MB). Leave empty to keep current photo.</flux:description>
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
                    <flux:button type="button" variant="primary" onclick="confirmUpdate()">
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
                </div>
            </form>

            <!-- Separate Delete Form - OUTSIDE of Update Form -->
            <div class="flex justify-end mt-4">
                <flux:button type="button" variant="danger" onclick="confirmDelete()">
                    <div class="flex items-center gap-2">
                        <flux:icon.trash class="size-4" />
                        <span>Delete Unit</span>
                    </div>
                </flux:button>
                <form id="delete-form" method="POST" action="{{ route('admin.units.destroy', $unit) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
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
    </div>

    @push('scripts')
    <script>
        function confirmUpdate() {
            // Validate form first
            if (!validateForm()) {
                return;
            }

            // Get form data for preview
            const unitCode = document.querySelector('input[name="kode_unit"]').value;
            const unitName = document.querySelector('input[name="nama_unit"]').value;
            const price = document.querySelector('input[name="harga_sewa_per_hari"]').value;
            const stock = document.querySelector('input[name="stok"]').value;
            const status = document.querySelector('select[name="status"]').value;

            Swal.fire({
                title: 'Update Unit?',
                html: `
                    <div class="text-left">
                        <p class="text-gray-600 mb-3">You are about to update the unit with the following details:</p>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg space-y-2">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Unit Code:</span>
                                <span class="text-gray-900 dark:text-white">${unitCode}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Unit Name:</span>
                                <span class="text-gray-900 dark:text-white">${unitName}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Status:</span>
                                <span class="text-blue-600 dark:text-blue-400">${status.charAt(0).toUpperCase() + status.slice(1)}</span>
                            </div>
                            ${price ? `
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Rental Price:</span>
                                    <span class="text-green-600 dark:text-green-400">Rp ${parseInt(price).toLocaleString('id-ID')}/day</span>
                                </div>
                            ` : ''}
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Stock:</span>
                                <span class="text-blue-600 dark:text-blue-400">${stock} units</span>
                            </div>
                        </div>
                        <p class="text-blue-600 dark:text-blue-400 text-sm mt-3">
                            <strong>Note:</strong> Changes will be saved and logged for audit purposes.
                        </p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3B82F6',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, Update Unit',
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
                        title: 'Updating Unit...',
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
            const unitName = '{{ $unit->nama_unit }}';
            const unitCode = '{{ $unit->kode_unit }}';
            const activeRentals = {{ $unit->peminjamans()->where('status', 'dipinjam')->count() }};

            if (activeRentals > 0) {
                Swal.fire({
                    title: 'Cannot Delete Unit',
                    html: `
                        <div class="text-left">
                            <p class="text-gray-600 mb-2">The unit "<strong>${unitName}</strong>" cannot be deleted because:</p>
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-3 rounded-lg">
                                <p class="text-red-800 dark:text-red-200">
                                    It currently has <strong>${activeRentals} active rental(s)</strong>.
                                </p>
                            </div>
                            <p class="text-blue-600 dark:text-blue-400 text-sm mt-3">
                                <strong>Suggestion:</strong> Wait for all rentals to be returned, then try deleting again.
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
                title: 'Delete Unit?',
                html: `
                    <div class="text-left">
                        <p class="text-gray-600 mb-2">You are about to delete:</p>
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                            <p class="font-semibold text-gray-900 dark:text-white">${unitName}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Code: ${unitCode}</p>
                        </div>
                        <p class="text-red-600 dark:text-red-400 text-sm mt-3">
                            <strong>Warning:</strong> This action cannot be undone. All rental history for this unit will remain, but the unit will be permanently removed from inventory.
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, Delete Unit',
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
                        title: 'Deleting Unit...',
                        text: 'Please wait while we remove the unit from inventory',
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

        function validateForm() {
            const stokInput = document.querySelector('input[name="stok"]');
            let stokValue = stokInput.value.trim();

            // Jika kosong, set ke nilai saat ini
            if (!stokValue || stokValue === '') {
                stokInput.value = {{ $unit->stok }};
                stokValue = {{ $unit->stok }};
            }

            const stokInt = parseInt(stokValue);
            const minActiveRentals = {{ $unit->peminjamans()->where('status', 'dipinjam')->count() }};

            // Validasi stok tidak negatif (boleh 0)
            if (isNaN(stokInt) || stokInt < 0) {
                Swal.fire({
                    title: 'Invalid Stock',
                    text: 'Stock quantity must be a number and cannot be negative!',
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
                stokInput.focus();
                return false;
            }

            // Validasi stok tidak kurang dari yang sedang dipinjam
            if (minActiveRentals > 0 && stokInt < minActiveRentals) {
                Swal.fire({
                    title: 'Stock Too Low',
                    text: `Stock cannot be less than ${minActiveRentals} because there are units currently being rented!`,
                    icon: 'warning',
                    confirmButtonColor: '#F59E0B',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'border-0 shadow-2xl',
                        title: 'text-lg font-semibold text-yellow-800',
                        content: 'text-yellow-600',
                        confirmButton: 'font-medium px-4 py-2 rounded-lg'
                    }
                });
                stokInput.focus();
                return false;
            }

            // Validasi stock terlalu besar
            if (stokInt > 1000) {
                return new Promise((resolve) => {
                    Swal.fire({
                        title: 'Large Stock Quantity',
                        text: `The stock quantity you entered (${stokInt}) is quite large. Are you sure this is correct?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3B82F6',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Yes, Correct',
                        cancelButtonText: 'Let me check',
                        customClass: {
                            popup: 'border-0 shadow-2xl',
                            title: 'text-lg font-semibold text-gray-900',
                            content: 'text-gray-600',
                            confirmButton: 'font-medium px-4 py-2 rounded-lg',
                            cancelButton: 'font-medium px-4 py-2 rounded-lg'
                        }
                    }).then((result) => {
                        resolve(result.isConfirmed);
                    });
                });
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

            stokInput.addEventListener('input', function() {
                let value = this.value.trim();

                // Allow temporary empty for editing
                if (value === '') {
                    return;
                }

                let intValue = parseInt(value);

                // Visual feedback
                if (intValue < 0 || isNaN(intValue)) {
                    this.style.borderColor = '#ef4444';
                    this.style.boxShadow = '0 0 0 1px #ef4444';
                } else if (minActiveRentals > 0 && intValue < minActiveRentals) {
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
