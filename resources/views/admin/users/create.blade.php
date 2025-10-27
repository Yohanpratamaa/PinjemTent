<x-layouts.admin :title="__('Create New User')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New User</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Add a new user to the system</p>
            </div>
            <flux:button variant="outline" href="{{ route('admin.users.index') }}">
                <flux:icon.arrow-left class="size-4" />
                Back to Users
            </flux:button>
        </div>

        <!-- Form Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl">
            <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 space-y-6">
                @csrf

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
                                    placeholder="Enter full name"
                                    value="{{ old('name') }}"
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
                                    placeholder="Enter email address"
                                    value="{{ old('email') }}"
                                    required
                                />
                                <flux:description>Must be a valid email address</flux:description>
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
                                    type="tel"
                                    name="phone"
                                    placeholder="Enter phone number"
                                    value="{{ old('phone') }}"
                                />
                                <flux:description>Optional contact number</flux:description>
                                @error('phone')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Role -->
                        <div>
                            <flux:field>
                                <flux:label>User Role</flux:label>
                                <flux:select name="role" placeholder="Select role" required>
                                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>
                                        Regular User
                                    </option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                        Administrator
                                    </option>
                                </flux:select>
                                <flux:description>User's role in the system</flux:description>
                                @error('role')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Password</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <flux:field>
                                <flux:label>Password</flux:label>
                                <flux:input
                                    type="password"
                                    name="password"
                                    placeholder="Enter password"
                                    required
                                />
                                <flux:description>Minimum 8 characters</flux:description>
                                @error('password')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <flux:field>
                                <flux:label>Confirm Password</flux:label>
                                <flux:input
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Confirm password"
                                    required
                                />
                                <flux:description>Must match the password above</flux:description>
                                @error('password_confirmation')
                                    <flux:error>{{ $message }}</flux:error>
                                @enderror
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Information</h3>
                    <div class="space-y-4">
                        <!-- Email Verification -->
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="email_verified"
                                name="email_verified"
                                value="1"
                                {{ old('email_verified') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                            >
                            <label for="email_verified" class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                Mark email as verified
                            </label>
                        </div>

                        <!-- Send Welcome Email -->
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="send_welcome_email"
                                name="send_welcome_email"
                                value="1"
                                {{ old('send_welcome_email', true) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                            >
                            <label for="send_welcome_email" class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                Send welcome email to user
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button type="submit" variant="primary">
                        <flux:icon.plus class="size-4" />
                        Create User
                    </flux:button>
                    <flux:button type="button" variant="outline" onclick="window.history.back()">
                        Cancel
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <flux:icon.information-circle class="size-5 text-blue-600 dark:text-blue-400 mt-0.5" />
                <div>
                    <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">User Creation Tips</h4>
                    <ul class="mt-2 text-sm text-blue-700 dark:text-blue-200 space-y-1">
                        <li>• Admin users have full access to the admin panel</li>
                        <li>• Regular users can only access the rental system</li>
                        <li>• Email verification is recommended for security</li>
                        <li>• Welcome emails help users get started quickly</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
