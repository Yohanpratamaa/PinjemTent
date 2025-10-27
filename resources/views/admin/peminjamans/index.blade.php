<x-layouts.admin :title="__('Rental Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Rental Management</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Track and manage all tent rentals</p>
            </div>
            <flux:button variant="primary" href="{{ route('admin.peminjamans.create') }}">
                <flux:icon.plus class="size-4" />
                Create New Rental
            </flux:button>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            <form method="GET" action="{{ route('admin.peminjamans.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <flux:input
                            name="search"
                            placeholder="Search by user name, unit code, or rental ID..."
                            value="{{ request('search') }}"
                        />
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <flux:select name="status" placeholder="Filter by status">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned</option>
                            <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </flux:select>
                    </div>

                    <!-- Date Filter -->
                    <div>
                        <flux:input
                            type="date"
                            name="date_from"
                            placeholder="From date"
                            value="{{ request('date_from') }}"
                        />
                    </div>

                    <div>
                        <flux:input
                            type="date"
                            name="date_to"
                            placeholder="To date"
                            value="{{ request('date_to') }}"
                        />
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <flux:button type="submit" variant="outline">
                        <flux:icon.magnifying-glass class="size-4" />
                        Search
                    </flux:button>
                    <flux:button type="button" variant="ghost" onclick="window.location.href='{{ route('admin.peminjamans.index') }}'">
                        Clear Filters
                    </flux:button>
                    <flux:button type="button" variant="outline">
                        <flux:icon.document-arrow-down class="size-4" />
                        Export
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                        <flux:icon.document class="size-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Rentals</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $peminjamans->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                        <flux:icon.clock class="size-5 text-green-600 dark:text-green-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Active</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['active'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-800">
                        <flux:icon.check-circle class="size-5 text-purple-600 dark:text-purple-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Returned</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['returned'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 dark:bg-red-800">
                        <flux:icon.exclamation-triangle class="size-5 text-red-600 dark:text-red-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Overdue</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['overdue'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-800">
                        <flux:icon.currency-dollar class="size-5 text-yellow-600 dark:text-yellow-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Monthly Revenue</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($stats['monthly_revenue'] ?? 0, 0) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rentals Table -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
            @if($peminjamans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Rental ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Unit
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Rental Period
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($peminjamans as $peminjaman)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            #{{ $peminjaman->id }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $peminjaman->created_at->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-600">
                                                <span class="text-xs font-medium text-gray-700 dark:text-gray-200">
                                                    {{ strtoupper(substr($peminjaman->user->name, 0, 2)) }}
                                                </span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $peminjaman->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $peminjaman->user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $peminjaman->unit->kode_unit }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $peminjaman->unit->nama_unit }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Qty: {{ $peminjaman->jumlah }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $peminjaman->tanggal_pinjam->format('M d, Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            to {{ $peminjaman->tanggal_kembali_rencana->format('M d, Y') }}
                                        </div>
                                        @if($peminjaman->tanggal_kembali)
                                            <div class="text-xs text-green-600 dark:text-green-400">
                                                Returned: {{ $peminjaman->tanggal_kembali->format('M d, Y') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($peminjaman->status)
                                            @case('active')
                                                <flux:badge color="blue">Active</flux:badge>
                                                @break
                                            @case('returned')
                                                <flux:badge color="green">Returned</flux:badge>
                                                @break
                                            @case('overdue')
                                                <flux:badge color="red">Overdue</flux:badge>
                                                @break
                                            @case('cancelled')
                                                <flux:badge color="gray">Cancelled</flux:badge>
                                                @break
                                            @default
                                                <flux:badge color="gray">{{ ucfirst($peminjaman->status) }}</flux:badge>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            ${{ number_format($peminjaman->total_biaya ?? 0, 2) }}
                                        </div>
                                        @if($peminjaman->denda && $peminjaman->denda > 0)
                                            <div class="text-sm text-red-600 dark:text-red-400">
                                                Fine: ${{ number_format($peminjaman->denda, 2) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <flux:button
                                                size="sm"
                                                variant="ghost"
                                                href="{{ route('admin.peminjamans.show', $peminjaman) }}"
                                                title="View Details"
                                            >
                                                <flux:icon.eye class="size-4" />
                                            </flux:button>

                                            @if($peminjaman->status === 'active')
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.peminjamans.return', $peminjaman) }}"
                                                    class="inline"
                                                >
                                                    @csrf
                                                    @method('PUT')
                                                    <flux:button
                                                        size="sm"
                                                        variant="ghost"
                                                        type="submit"
                                                        title="Mark as Returned"
                                                    >
                                                        <flux:icon.check class="size-4" />
                                                    </flux:button>
                                                </form>
                                            @endif

                                            <flux:button
                                                size="sm"
                                                variant="ghost"
                                                href="{{ route('admin.peminjamans.edit', $peminjaman) }}"
                                                title="Edit Rental"
                                            >
                                                <flux:icon.pencil class="size-4" />
                                            </flux:button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white dark:bg-neutral-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $peminjamans->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <flux:icon.document class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No rentals found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Get started by creating a new rental.
                    </p>
                    <div class="mt-6">
                        <flux:button variant="primary" href="{{ route('admin.peminjamans.create') }}">
                            <flux:icon.plus class="size-4" />
                            Create New Rental
                        </flux:button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
