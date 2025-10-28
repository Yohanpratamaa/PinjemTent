<x-layouts.admin :title="__('Rental Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Rental Management</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Track and manage all tent rentals</p>
            </div>
            {{-- <flux:button variant="primary" href="{{ route('admin.peminjamans.create') }}">
                <flux:icon.plus class="size-4" />
                Create New Rental
            </flux:button> --}}
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            <form method="GET" action="{{ route('admin.peminjamans.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                    <!-- Search Input -->
                    <div class="md:col-span-2 mt-5">
                        <div class="relative">
                            <flux:input
                                name="search"
                                placeholder="Search by user name, unit code, rental ID, or email..."
                                value="{{ request('search') }}"
                                {{-- class="pr-20" --}}
                            />
                            {{-- <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <kbd class="inline-flex items-center rounded border border-gray-200 px-1.5 py-0.5 text-xs font-mono text-gray-500 dark:border-gray-700 dark:text-gray-400">
                                    Ctrl K
                                </kbd>
                            </div> --}}
                        </div>
                        @if(request('search'))
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Searching for: <span class="font-medium">"{{ request('search') }}"</span>
                            </div>
                        @endif
                    </div>

                    <!-- Status Filter -->
                    <div class="mt-5">
                        <flux:select name="status" placeholder="Filter by status">
                            <option value="">All Status</option>
                            <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </flux:select>
                    </div>

                    <!-- Date Filter -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            From Date
                        </label>
                        <flux:input
                            type="date"
                            name="date_from"
                            placeholder="From date"
                            value="{{ request('date_from') }}"
                            max="{{ request('date_to') ?: date('Y-m-d') }}"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            To Date
                        </label>
                        <flux:input
                            type="date"
                            name="date_to"
                            placeholder="To date"
                            value="{{ request('date_to') }}"
                            min="{{ request('date_from') }}"
                            max="{{ date('Y-m-d') }}"
                        />
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <flux:button type="submit" variant="outline">
                        <div class="flex items-center gap-2">
                            <flux:icon.magnifying-glass class="size-4" />
                            Search
                        </div>
                    </flux:button>
                    <flux:button type="button" variant="ghost" onclick="window.location.href='{{ route('admin.peminjamans.index') }}'">
                        Clear Filters
                    </flux:button>

                    <!-- Active Filters Indicator -->
                    @php
                        $activeFilters = array_filter([
                            'search' => request('search'),
                            'status' => request('status'),
                            'date_from' => request('date_from'),
                            'date_to' => request('date_to')
                        ]);
                    @endphp

                    @if(count($activeFilters) > 0)
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>
                            @foreach($activeFilters as $key => $value)
                                <flux:badge color="blue" size="sm">
                                    @switch($key)
                                        @case('search')
                                            Search: {{ Str::limit($value, 15) }}
                                            @break
                                        @case('status')
                                            Status: {{ ucfirst($value) }}
                                            @break
                                        @case('date_from')
                                            From: {{ \Carbon\Carbon::parse($value)->format('M d, Y') }}
                                            @break
                                        @case('date_to')
                                            To: {{ \Carbon\Carbon::parse($value)->format('M d, Y') }}
                                            @break
                                    @endswitch
                                </flux:badge>
                            @endforeach
                        </div>
                    @endif

                    {{-- <flux:button type="button" variant="outline">
                        <flux:icon.document-arrow-down class="size-4" />
                        Export
                    </flux:button> --}}
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
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['dipinjam'] ?? 0 }}</p>
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
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['dikembalikan'] ?? 0 }}</p>
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
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['terlambat'] ?? 0 }}</p>
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
                            {{ $stats['monthly_revenue_formatted'] ?? 'Rp0' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rentals Table -->
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
            <!-- Results Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Rental Records
                        </h3>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            @if($peminjamans->total() > 0)
                                Showing {{ $peminjamans->firstItem() }} to {{ $peminjamans->lastItem() }}
                                of {{ $peminjamans->total() }} results
                                @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                                    <span class="text-blue-600 dark:text-blue-400">(filtered)</span>
                                @endif
                            @else
                                No results found
                                @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                                    <span class="text-blue-600 dark:text-blue-400">with current filters</span>
                                @endif
                            @endif
                        </div>
                    </div>

                    @if($peminjamans->total() > 0)
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            Last updated: {{ now()->format('M d, Y H:i') }}
                        </div>
                    @endif
                </div>
            </div>

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
                                            @case('dipinjam')
                                                <flux:badge color="green">Active</flux:badge>
                                                @break
                                            @case('dikembalikan')
                                                <flux:badge color="purple">Returned</flux:badge>
                                                @break
                                            @case('terlambat')
                                                <flux:badge color="red">Overdue</flux:badge>
                                                @break
                                            @case('dibatalkan')
                                                <flux:badge color="gray">Cancelled</flux:badge>
                                                @break
                                            @default
                                                <flux:badge color="gray">{{ ucfirst($peminjaman->status) }}</flux:badge>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $peminjaman->getFormattedTotalBayar() }}
                                        </div>
                                        @if($peminjaman->denda_total && $peminjaman->denda_total > 0)
                                            <div class="text-sm text-red-600 dark:text-red-400">
                                                Denda: {{ \App\Helpers\CurrencyHelper::formatIDR($peminjaman->denda_total) }}
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

                                            @if($peminjaman->status === 'dipinjam')
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
                    {{-- <div class="mt-6">
                        <flux:button variant="primary" href="{{ route('admin.peminjamans.create') }}">
                            <flux:icon.plus class="size-4" />
                            Create New Rental
                        </flux:button>
                    </div> --}}
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript untuk meningkatkan filter functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Keyboard shortcut untuk search (Ctrl+K)
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const searchInput = document.querySelector('input[name="search"]');
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }
            });

            // Auto-submit form ketika status filter berubah
            const statusSelect = document.querySelector('select[name="status"]');
            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            }

            // Auto-submit form ketika date filter berubah
            const dateInputs = document.querySelectorAll('input[type="date"]');
            dateInputs.forEach(input => {
                input.addEventListener('change', function() {
                    // Tambahkan sedikit delay untuk memungkinkan user memilih kedua tanggal
                    setTimeout(() => {
                        this.closest('form').submit();
                    }, 500);
                });
            });

            // Live search dengan debounce
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const form = this.closest('form');

                    // Show loading indicator
                    showLoadingIndicator();

                    searchTimeout = setTimeout(() => {
                        if (this.value.length >= 3 || this.value.length === 0) {
                            form.submit();
                        } else {
                            hideLoadingIndicator();
                        }
                    }, 800); // 800ms delay
                });
            }

            // Highlight active filters
            highlightActiveFilters();

            // Reset filter validation
            const clearButton = document.querySelector('button[onclick*="peminjamans.index"]');
            if (clearButton) {
                clearButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = '{{ route("admin.peminjamans.index") }}';
                });
            }

            // Validasi date range
            validateDateRange();
        });

        function highlightActiveFilters() {
            const params = new URLSearchParams(window.location.search);

            // Highlight search input if active
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput && params.get('search')) {
                searchInput.classList.add('ring-2', 'ring-blue-500');
            }

            // Highlight status filter if active
            const statusSelect = document.querySelector('select[name="status"]');
            if (statusSelect && params.get('status')) {
                statusSelect.classList.add('ring-2', 'ring-blue-500');
            }

            // Highlight date filters if active
            const dateFromInput = document.querySelector('input[name="date_from"]');
            const dateToInput = document.querySelector('input[name="date_to"]');

            if (dateFromInput && params.get('date_from')) {
                dateFromInput.classList.add('ring-2', 'ring-blue-500');
            }

            if (dateToInput && params.get('date_to')) {
                dateToInput.classList.add('ring-2', 'ring-blue-500');
            }
        }

        function validateDateRange() {
            const dateFromInput = document.querySelector('input[name="date_from"]');
            const dateToInput = document.querySelector('input[name="date_to"]');

            if (dateFromInput && dateToInput) {
                function checkDateRange() {
                    const fromDate = new Date(dateFromInput.value);
                    const toDate = new Date(dateToInput.value);

                    if (dateFromInput.value && dateToInput.value && fromDate > toDate) {
                        // Show error message
                        showDateError('End date cannot be before start date');
                        dateToInput.value = '';
                    } else {
                        // Remove error message
                        removeDateError();
                    }
                }

                dateFromInput.addEventListener('change', checkDateRange);
                dateToInput.addEventListener('change', checkDateRange);
            }
        }

        function showDateError(message) {
            removeDateError(); // Remove existing error first

            const dateToInput = document.querySelector('input[name="date_to"]');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'mt-1 text-xs text-red-600 dark:text-red-400 date-error';
            errorDiv.textContent = message;

            dateToInput.parentNode.appendChild(errorDiv);
            dateToInput.classList.add('border-red-500', 'ring-red-500');
        }

        function removeDateError() {
            const errorDiv = document.querySelector('.date-error');
            const dateToInput = document.querySelector('input[name="date_to"]');

            if (errorDiv) {
                errorDiv.remove();
            }

            if (dateToInput) {
                dateToInput.classList.remove('border-red-500', 'ring-red-500');
            }
        }

        function showLoadingIndicator() {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                // Add loading state to search input
                searchInput.style.background = 'linear-gradient(90deg, #f3f4f6 25%, transparent 25%, transparent 50%, #f3f4f6 50%, #f3f4f6 75%, transparent 75%, transparent)';
                searchInput.style.backgroundSize = '20px 20px';
                searchInput.style.animation = 'loading 1s linear infinite';

                // Add CSS animation if not exists
                if (!document.querySelector('#loading-animation-style')) {
                    const style = document.createElement('style');
                    style.id = 'loading-animation-style';
                    style.textContent = `
                        @keyframes loading {
                            0% { background-position: 0 0; }
                            100% { background-position: 20px 0; }
                        }
                    `;
                    document.head.appendChild(style);
                }
            }
        }

        function hideLoadingIndicator() {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.style.background = '';
                searchInput.style.backgroundSize = '';
                searchInput.style.animation = '';
            }
        }

        // Function untuk export data (untuk future implementation)
        function exportData() {
            const params = new URLSearchParams(window.location.search);
            params.set('export', 'excel');
            window.location.href = '{{ route("admin.peminjamans.index") }}?' + params.toString();
        }
    </script>
</x-layouts.app>
