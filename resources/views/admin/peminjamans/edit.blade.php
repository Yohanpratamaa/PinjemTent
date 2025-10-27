<x-layouts.admin :title="__('Edit Rental')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Rental</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Modify rental details for: <span class="font-medium">{{ $peminjaman->unit->nama_unit }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="outline" href="{{ route('admin.peminjamans.show', $peminjaman) }}">
                    <flux:icon.eye class="size-4" />
                    View Details
                </flux:button>
                <flux:button variant="outline" href="{{ route('admin.peminjamans.index') }}">
                    <flux:icon.arrow-left class="size-4" />
                    Back to Rentals
                </flux:button>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <form method="POST" action="{{ route('admin.peminjamans.update', $peminjaman) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Rental Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Rental Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User -->
                        <div>
                            <flux:field>
                                <flux:label>Renter</flux:label>
                                <flux:select name="user_id" placeholder="Select user" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $peminjaman->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </flux:select>
                                <flux:description>User who is renting the unit</flux:description>
                                @error('user_id')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Unit -->
                        <div>
                            <flux:field>
                                <flux:label>Unit</flux:label>
                                <flux:select name="unit_id" placeholder="Select unit" required>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ old('unit_id', $peminjaman->unit_id) == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->kode_unit }} - {{ $unit->nama_unit }}
                                        </option>
                                    @endforeach
                                </flux:select>
                                <flux:description>Unit being rented</flux:description>
                                @error('unit_id')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Rental Date -->
                        <div>
                            <flux:field>
                                <flux:label>Rental Date</flux:label>
                                <flux:input
                                    type="date"
                                    name="tanggal_pinjam"
                                    value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam->format('Y-m-d')) }}"
                                    required
                                />
                                <flux:description>Date when the rental starts</flux:description>
                                @error('tanggal_pinjam')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Planned Return Date -->
                        <div>
                            <flux:field>
                                <flux:label>Planned Return Date</flux:label>
                                <flux:input
                                    type="date"
                                    name="tanggal_kembali_rencana"
                                    value="{{ old('tanggal_kembali_rencana', $peminjaman->tanggal_kembali_rencana->format('Y-m-d')) }}"
                                    required
                                />
                                <flux:description>Date when the unit should be returned</flux:description>
                                @error('tanggal_kembali_rencana')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Actual Return Date -->
                        <div>
                            <flux:field>
                                <flux:label>Actual Return Date (Optional)</flux:label>
                                <flux:input
                                    type="date"
                                    name="tanggal_kembali_aktual"
                                    value="{{ old('tanggal_kembali_aktual', $peminjaman->tanggal_kembali_aktual?->format('Y-m-d')) }}"
                                />
                                <flux:description>Actual date when the unit was returned</flux:description>
                                @error('tanggal_kembali_aktual')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Status -->
                        <div>
                            <flux:field>
                                <flux:label>Status</flux:label>
                                <flux:select name="status" placeholder="Select status" required>
                                    <option value="dipinjam" {{ old('status', $peminjaman->status) === 'dipinjam' ? 'selected' : '' }}>
                                        Rented
                                    </option>
                                    <option value="dikembalikan" {{ old('status', $peminjaman->status) === 'dikembalikan' ? 'selected' : '' }}>
                                        Returned
                                    </option>
                                    <option value="terlambat" {{ old('status', $peminjaman->status) === 'terlambat' ? 'selected' : '' }}>
                                        Overdue
                                    </option>
                                </flux:select>
                                <flux:description>Current status of the rental</flux:description>
                                @error('status')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Information</h3>
                    <flux:field>
                        <flux:label>Notes (Optional)</flux:label>
                        <flux:textarea
                            name="catatan"
                            placeholder="Add any notes about this rental..."
                            rows="4"
                        >{{ old('catatan', $peminjaman->catatan) }}</flux:textarea>
                        <flux:description>Optional notes about the rental</flux:description>
                        @error('catatan')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </flux:field>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button type="submit" variant="primary" class="flex items-center gap-2">
                        <flux:icon.check class="size-4" />
                        Update Rental
                    </flux:button>
                    <flux:button type="button" variant="outline" onclick="window.history.back()">
                        Cancel
                    </flux:button>

                    <!-- Return Button -->
                    @if($peminjaman->status === 'dipinjam')
                        <div class="ml-auto">
                            <form
                                method="POST"
                                action="{{ route('admin.peminjamans.return', $peminjaman) }}"
                                class="inline"
                                onsubmit="return confirm('Mark this rental as returned?')"
                            >
                                @csrf
                                @method('PUT')
                                <flux:button type="submit" variant="outline" class="flex items-center gap-2">
                                    <flux:icon.arrow-uturn-left class="size-4" />
                                    Mark as Returned
                                </flux:button>
                            </form>
                        </div>
                    @endif
                </div>
            </form>
        </div>

        <!-- Rental Timeline -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Rental Timeline</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                            <flux:icon.clock class="size-4 text-green-600 dark:text-green-400" />
                        </div>
                        <div>
                            <p class="text-gray-900 dark:text-white">Rental created</p>
                            <p class="text-gray-500 dark:text-gray-400">{{ $peminjaman->created_at->format('M d, Y at g:i A') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                            <flux:icon.calendar class="size-4 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div>
                            <p class="text-gray-900 dark:text-white">Rental start date</p>
                            <p class="text-gray-500 dark:text-gray-400">{{ $peminjaman->tanggal_pinjam->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-800">
                            <flux:icon.calendar class="size-4 text-yellow-600 dark:text-yellow-400" />
                        </div>
                        <div>
                            <p class="text-gray-900 dark:text-white">Planned return date</p>
                            <p class="text-gray-500 dark:text-gray-400">{{ $peminjaman->tanggal_kembali_rencana->format('M d, Y') }}</p>
                        </div>
                    </div>

                    @if($peminjaman->tanggal_kembali_aktual)
                        <div class="flex items-center gap-3 text-sm">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                                <flux:icon.check-circle class="size-4 text-green-600 dark:text-green-400" />
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white">Actually returned</p>
                                <p class="text-gray-500 dark:text-gray-400">{{ $peminjaman->tanggal_kembali_aktual->format('M d, Y') }}</p>
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
                        <li>• Changing the unit will affect inventory status</li>
                        <li>• Setting status to "Returned" will make the unit available again</li>
                        <li>• Overdue rentals are automatically flagged based on planned return date</li>
                        <li>• Changes will update the rental history</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
