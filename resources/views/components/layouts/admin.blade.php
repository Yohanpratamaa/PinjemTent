<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('admin.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Dashboard')" class="grid">
                    <flux:navlist.item icon="home" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group :heading="__('Inventory Management')" class="grid">
                    <flux:navlist.item icon="squares-2x2" :href="route('admin.units.index')" :current="request()->routeIs('admin.units.*')" wire:navigate>
                        {{ __('Units') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="tag" :href="route('admin.kategoris.index')" :current="request()->routeIs('admin.kategoris.*')" wire:navigate>
                        {{ __('Categories') }}
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group :heading="__('Rental Management')" class="grid">
                    <flux:navlist.item icon="document" :href="route('admin.peminjamans.index')" :current="request()->routeIs('admin.peminjamans.*')" wire:navigate>
                        {{ __('Rentals') }}
                    </flux:navlist.item>
                    {{-- <flux:navlist.item icon="clock" href="#" wire:navigate>
                        {{ __('Overdue') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="chart-bar" href="#" wire:navigate>
                        {{ __('Reports') }}
                    </flux:navlist.item> --}}
                </flux:navlist.group>

                <flux:navlist.group :heading="__('Notifications')" class="grid">
                    <flux:navlist.item icon="bell" :href="route('admin.notifications.index')" :current="request()->routeIs('admin.notifications.*')" wire:navigate>
                        <div class="flex items-center justify-between w-full">
                            <span>{{ __('Return Requests') }}</span>
                            @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                <span class="bg-red-500 text-white text-xs rounded-full h-5 min-w-[20px] flex items-center justify-center px-1 ml-2">
                                    {{ $unreadNotificationsCount }}
                                </span>
                            @endif
                        </div>
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group :heading="__('User Management')" class="grid">
                    <flux:navlist.item icon="users" :href="route('admin.users.index')" :current="request()->routeIs('admin.users.*')" wire:navigate>
                        {{ __('Users') }}
                    </flux:navlist.item>
                </flux:navlist.group>

            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    <span class="truncate text-xs font-medium text-green-600 dark:text-green-400">Admin</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    <span class="truncate text-xs font-medium text-green-600 dark:text-green-400">Admin</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        <flux:menu.item :href="route('dashboard')" icon="home" wire:navigate>{{ __('User Dashboard') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <flux:main>
            {{ $slot }}
        </flux:main>

        @fluxScripts

        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Unit Management SweetAlert Enhancement -->
        @if(request()->routeIs('admin.units.*'))
            <script src="{{ asset('js/unit-sweetalert.js') }}"></script>
        @endif

        <!-- Unit Management SweetAlert Script -->
        <script>
            // SweetAlert for Flash Messages (Units)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true,
                    confirmButtonColor: '#ef4444'
                });
            @endif

            @if(session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: '{{ session('warning') }}',
                    showConfirmButton: true,
                    confirmButtonColor: '#f59e0b'
                });
            @endif

            @if(session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Information',
                    text: '{{ session('info') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end'
                });
            @endif

            // Unit Delete Confirmation
            function confirmDeleteUnit(unitId, unitName) {
                Swal.fire({
                    title: 'Delete Unit?',
                    html: `Are you sure you want to delete unit:<br><strong>${unitName}</strong>?<br><br>This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, Delete!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the delete form
                        document.getElementById(`delete-unit-form-${unitId}`).submit();
                    }
                });
            }

            // Unit Status Change Confirmation
            function confirmStatusChange(unitId, unitName, newStatus) {
                const statusMessages = {
                    'tersedia': 'make this unit available',
                    'maintenance': 'set this unit to maintenance mode',
                    'dipinjam': 'mark this unit as rented'
                };

                Swal.fire({
                    title: 'Change Unit Status?',
                    html: `Are you sure you want to ${statusMessages[newStatus]} for:<br><strong>${unitName}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, Change Status!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create and submit form for status change
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/units/${unitId}/status`;

                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'PUT';

                        const statusField = document.createElement('input');
                        statusField.type = 'hidden';
                        statusField.name = 'status';
                        statusField.value = newStatus;

                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        form.appendChild(statusField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

            // Unit Form Validation Enhancement
            function validateUnitForm(formElement) {
                const requiredFields = formElement.querySelectorAll('[required]');
                let hasErrors = false;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        hasErrors = true;
                        field.classList.add('border-red-500');
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });

                if (hasErrors) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill in all required fields.',
                        confirmButtonColor: '#ef4444'
                    });
                    return false;
                }

                return true;
            }

            // Unit Stock Update Confirmation
            function confirmStockUpdate(unitId, unitName, currentStock, newStock) {
                if (newStock < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Stock',
                        text: 'Stock cannot be negative.',
                        confirmButtonColor: '#ef4444'
                    });
                    return false;
                }

                Swal.fire({
                    title: 'Update Unit Stock?',
                    html: `
                        <div class="text-left">
                            <p><strong>Unit:</strong> ${unitName}</p>
                            <p><strong>Current Stock:</strong> ${currentStock}</p>
                            <p><strong>New Stock:</strong> ${newStock}</p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, Update Stock!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form
                        document.getElementById(`update-stock-form-${unitId}`).submit();
                    }
                });
            }

            // Success notification for operations
            function showSuccessNotification(title, message) {
                Swal.fire({
                    icon: 'success',
                    title: title,
                    text: message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end'
                });
            }

            // Error notification for operations
            function showErrorNotification(title, message) {
                Swal.fire({
                    icon: 'error',
                    title: title,
                    text: message,
                    showConfirmButton: true,
                    confirmButtonColor: '#ef4444'
                });
            }

            // Unit Photo Upload Preview
            function previewUnitPhoto(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('photo-preview');
                        if (preview) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Unit Category Assignment Confirmation
            function confirmCategoryAssignment(unitId, unitName, categories) {
                const categoryList = categories.join(', ');

                Swal.fire({
                    title: 'Assign Categories?',
                    html: `
                        <div class="text-left">
                            <p><strong>Unit:</strong> ${unitName}</p>
                            <p><strong>Categories:</strong> ${categoryList || 'None'}</p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, Assign Categories!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        return true;
                    }
                    return false;
                });
            }
        </script>

        @stack('scripts')
    </body>
</html>
