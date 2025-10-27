<x-layouts.admin :title="__('User Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">User Details</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Complete information for user: <span class="font-medium">{{ $user->name }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="primary" href="{{ route('admin.users.edit', $user) }}" class="flex items-center gap-2">
                    <flux:icon.pencil class="size-4" />
                    Edit User
                </flux:button>
                <flux:button variant="outline" href="{{ route('admin.users.index') }}" class="flex items-center gap-2">
                    <flux:icon.arrow-left class="size-4" />
                    Back to Users
                </flux:button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Details Card -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">User Information</h3>
                    <div class="flex items-start gap-4">
                        <!-- Avatar -->
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                            <span class="text-xl font-medium text-gray-700 dark:text-gray-300">
                                {{ $user->initials() }}
                            </span>
                        </div>

                        <!-- User Details -->
                        <div class="flex-1">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Address</dt>
                                    <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ $user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</dt>
                                    <dd class="mt-1">
                                        @if($user->role === 'admin')
                                            <flux:badge color="red">Administrator</flux:badge>
                                        @else
                                            <flux:badge color="blue">User</flux:badge>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Status</dt>
                                    <dd class="mt-1">
                                        @if($user->email_verified_at)
                                            <flux:badge color="green">Verified</flux:badge>
                                        @else
                                            <flux:badge color="yellow">Unverified</flux:badge>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Rental History -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Rental History</h3>
                    @if($user->peminjamans->count() > 0)
                        <div class="space-y-4">
                            @foreach($user->peminjamans->take(5) as $peminjaman)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white">
                                                {{ $peminjaman->unit->nama_unit }}
                                            </h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Code: {{ $peminjaman->unit->kode_unit }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $peminjaman->tanggal_pinjam->format('M d, Y') }} -
                                                {{ $peminjaman->tanggal_kembali_rencana->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            @switch($peminjaman->status)
                                                @case('dipinjam')
                                                    <flux:badge color="blue">Active</flux:badge>
                                                    @break
                                                @case('dikembalikan')
                                                    <flux:badge color="green">Returned</flux:badge>
                                                    @break
                                                @case('terlambat')
                                                    <flux:badge color="red">Overdue</flux:badge>
                                                    @break
                                            @endswitch
                                            <flux:button variant="outline" size="sm" href="{{ route('admin.peminjamans.show', $peminjaman) }}" class="flex items-center gap-1 mt-2">
                                                <flux:icon.eye class="size-3" />
                                                View
                                            </flux:button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if($user->peminjamans->count() > 5)
                                <div class="text-center">
                                    <flux:button variant="outline" href="{{ route('admin.peminjamans.index', ['user_id' => $user->id]) }}" class="flex items-center gap-2">
                                        <flux:icon.eye class="size-4" />
                                        View All Rentals
                                    </flux:button>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <flux:icon.archive-box class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No rentals yet</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This user hasn't made any rentals.</p>
                        </div>
                    @endif
                </div>

                <!-- Account Timeline -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Account Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-sm">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                                <flux:icon.user-plus class="size-4 text-green-600 dark:text-green-400" />
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white">Account created</p>
                                <p class="text-gray-500 dark:text-gray-400">{{ $user->created_at->format('M d, Y at g:i A') }}</p>
                            </div>
                        </div>

                        @if($user->email_verified_at)
                            <div class="flex items-center gap-3 text-sm">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                                    <flux:icon.check-circle class="size-4 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div>
                                    <p class="text-gray-900 dark:text-white">Email verified</p>
                                    <p class="text-gray-500 dark:text-gray-400">{{ $user->email_verified_at->format('M d, Y at g:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($user->updated_at != $user->created_at)
                            <div class="flex items-center gap-3 text-sm">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-800">
                                    <flux:icon.pencil class="size-4 text-yellow-600 dark:text-yellow-400" />
                                </div>
                                <div>
                                    <p class="text-gray-900 dark:text-white">Last updated</p>
                                    <p class="text-gray-500 dark:text-gray-400">{{ $user->updated_at->format('M d, Y at g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statistics -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Statistics</h3>
                    <div class="space-y-4">
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
                            <p class="text-sm text-gray-600 dark:text-gray-400">Completed</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h3>
                    <div class="space-y-3">
                        <flux:button variant="outline" class="w-full flex items-center gap-2" href="{{ route('admin.users.edit', $user) }}">
                            <flux:icon.pencil class="size-4" />
                            Edit User
                        </flux:button>

                        <flux:button variant="outline" class="w-full flex items-center gap-2" href="{{ route('admin.peminjamans.create', ['user_id' => $user->id]) }}">
                            <flux:icon.plus class="size-4" />
                            Create Rental
                        </flux:button>

                        @if($user->id !== auth()->id() && $user->email !== 'admin@pinjemtent.com' && $user->peminjamans->where('status', 'dipinjam')->count() === 0)
                            <form
                                method="POST"
                                action="{{ route('admin.users.destroy', $user) }}"
                                onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                            >
                                @csrf
                                @method('DELETE')
                                <flux:button type="submit" variant="danger" class="w-full flex items-center gap-2">
                                    <flux:icon.trash class="size-4" />
                                    Delete User
                                </flux:button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
