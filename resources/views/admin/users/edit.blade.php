<x-layouts.admin :title="__('Edit User')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit User</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Modify details for user: <span class="font-medium">{{ $user->name }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="outline" href="{{ route('admin.users.show', $user) }}">
                    <flux:icon.eye class="size-4" />
                    View Details
                </flux:button>
                <flux:button variant="outline" href="{{ route('admin.users.index') }}">
                    <flux:icon.arrow-left class="size-4" />
                    Back to Users
                </flux:button>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <flux:field>
                                <flux:label>Full Name</flux:label>
                                <flux:input
                                    name="name"
                                    placeholder="e.g., John Doe"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                />
                                <flux:description>User's full name</flux:description>
                                @error('name')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Email -->
                        <div>
                            <flux:field>
                                <flux:label>Email Address</flux:label>
                                <flux:input
                                    type="email"
                                    name="email"
                                    placeholder="e.g., john@example.com"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                />
                                <flux:description>User's email address</flux:description>
                                @error('email')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Phone -->
                        <div>
                            <flux:field>
                                <flux:label>Phone Number</flux:label>
                                <flux:input
                                    name="phone"
                                    type="tel"
                                    placeholder="e.g., +62 812 3456 7890"
                                    value="{{ old('phone', $user->phone ?? '') }}"
                                />
                                <flux:description>User's phone number (optional)</flux:description>
                                @error('phone')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Role -->
                        <div>
                            <flux:field>
                                <flux:label>Role</flux:label>
                                <flux:select name="role" placeholder="Select role" required>
                                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                                        User
                                    </option>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                        Admin
                                    </option>
                                </flux:select>
                                <flux:description>User's role in the system</flux:description>
                                @error('role')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Password -->
                        <div>
                            <flux:field>
                                <flux:label>New Password (Optional)</flux:label>
                                <flux:input
                                    type="password"
                                    name="password"
                                    placeholder="Leave blank to keep current password"
                                />
                                <flux:description>Leave blank to keep current password</flux:description>
                                @error('password')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Confirm Password -->
                        <div class="md:col-span-2">
                            <flux:field>
                                <flux:label>Confirm New Password</flux:label>
                                <flux:input
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Confirm the new password"
                                />
                                <flux:description>Required if setting a new password</flux:description>
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button type="submit" variant="primary" class="flex items-center gap-2">
                        <flux:icon.check class="size-4" />
                        Update User
                    </flux:button>
                    <flux:button type="button" variant="outline" onclick="window.history.back()">
                        Cancel
                    </flux:button>
                </div>
            </form>

            <!-- Separate Delete Form - OUTSIDE of Update Form -->
            @if($user->id !== auth()->id() && $user->email !== 'admin@pinjemtent.com')
                <div class="flex justify-end mt-4">
                    <form
                        method="POST"
                        action="{{ route('admin.users.destroy', $user) }}"
                        class="inline"
                        data-user-id="{{ $user->id }}"
                        data-user-name="{{ $user->name }}"
                        onsubmit="return debugDeleteUser('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                    >
                        @csrf
                        @method('DELETE')
                        <flux:button type="submit" variant="danger" class="flex items-center gap-2">
                            <flux:icon.trash class="size-4" />
                            Delete User
                        </flux:button>
                    </form>
                </div>
            @endif
        </div>

        <!-- User Activity -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">User Activity</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->peminjamans->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Rentals</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->peminjamans->where('status', 'dipinjam')->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Active Rentals</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->peminjamans->where('status', 'dikembalikan')->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Completed Rentals</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Account Information</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                            <flux:icon.clock class="size-4 text-green-600 dark:text-green-400" />
                        </div>
                        <div>
                            <p class="text-gray-900 dark:text-white">Account created</p>
                            <p class="text-gray-500 dark:text-gray-400">{{ $user->created_at->format('M d, Y at g:i A') }}</p>
                        </div>
                    </div>

                    @if($user->updated_at != $user->created_at)
                        <div class="flex items-center gap-3 text-sm">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                                <flux:icon.pencil class="size-4 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white">Last updated</p>
                                <p class="text-gray-500 dark:text-gray-400">{{ $user->updated_at->format('M d, Y at g:i A') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($user->email_verified_at)
                        <div class="flex items-center gap-3 text-sm">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                                <flux:icon.check-circle class="size-4 text-green-600 dark:text-green-400" />
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white">Email verified</p>
                                <p class="text-gray-500 dark:text-gray-400">{{ $user->email_verified_at->format('M d, Y at g:i A') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 text-sm">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-800">
                                <flux:icon.exclamation-triangle class="size-4 text-yellow-600 dark:text-yellow-400" />
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white">Email not verified</p>
                                <p class="text-gray-500 dark:text-gray-400">User needs to verify their email address</p>
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
                        <li>• Changing a user's email will require them to verify the new address</li>
                        <li>• Admin users have full access to the system</li>
                        <li>• Users with active rentals cannot be deleted</li>
                        <li>• Password changes will log the user out of all devices</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Debug function for user update form
        function debugUserUpdateForm(formElement) {
            const formData = new FormData(formElement);
            console.log('🔄 USER UPDATE Form Debug ===');
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
            console.log('=== End User Update Debug ===');
            return true; // Allow form submission
        }

        // Debug function for user delete
        function debugDeleteUser(userId, userName) {
            console.group("🗑️ Delete User Debug");
            console.log("IMPORTANT: This is a DELETE operation, not UPDATE");
            console.log("User ID:", userId);
            console.log("User Name:", userName);
            console.log("Timestamp:", new Date().toISOString());
            console.log("Action: DELETE USER (Permanent)");

            const confirmed = confirm(
                `⚠️ DELETE CONFIRMATION ⚠️\n\nAre you sure you want to PERMANENTLY DELETE user "${userName}"?\n\nThis action CANNOT be undone!\n\nClick OK to DELETE or Cancel to abort.`
            );
            console.log("User Confirmed Delete:", confirmed);
            console.groupEnd();

            if (confirmed) {
                console.warn("🗑️ DELETE CONFIRMED - User will be deleted!");
            } else {
                console.log("✅ DELETE CANCELLED - User will not be deleted");
            }

            return confirmed;
        }

        // Add form event listener
        document.addEventListener('DOMContentLoaded', function() {
            const updateForm = document.querySelector('form[action*="users"][method="POST"]:not([action*="destroy"])');
            if (updateForm) {
                updateForm.addEventListener('submit', function(e) {
                    if (!debugUserUpdateForm(this)) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
        });
    </script>

    <!-- Debug Script -->
    <script src="{{ asset('js/user-debug.js') }}"></script>
</x-layouts.admin>
