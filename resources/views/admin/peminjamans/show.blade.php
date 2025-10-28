<x-layouts.admin :title="__('Rental Details - #' . $peminjaman->id)">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        <!-- Breadcrumb -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <flux:icon.home class="w-3 h-3 mr-2.5" />
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <flux:icon.chevron-right class="w-3 h-3 text-gray-400 mx-1" />
                        <a href="{{ route('admin.peminjamans.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                            Rental Management
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <flux:icon.chevron-right class="w-3 h-3 text-gray-400 mx-1" />
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                            Rental #{{ $peminjaman->id }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <flux:button
                    variant="ghost"
                    href="{{ route('admin.peminjamans.index') }}"
                    class="p-2"
                >
                    <flux:icon.arrow-left class="size-5" />
                </flux:button>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Rental Details
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        View complete rental information and history
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <!-- Status Badge -->
                @switch($peminjaman->status)
                    @case('dipinjam')
                        <flux:badge color="blue" size="lg">Dipinjam</flux:badge>
                        @break
                    @case('dikembalikan')
                        <flux:badge color="green" size="lg">Dikembalikan</flux:badge>
                        @break
                    @case('terlambat')
                        <flux:badge color="red" size="lg">Terlambat</flux:badge>
                        @break
                    @case('dibatalkan')
                        <flux:badge color="gray" size="lg">Dibatalkan</flux:badge>
                        @break
                    @default
                        <flux:badge color="gray" size="lg">{{ ucfirst($peminjaman->status) }}</flux:badge>
                @endswitch

                @if($peminjaman->status === 'dipinjam')
                    <flux:button
                        variant="primary"
                        href="{{ route('admin.peminjamans.edit', $peminjaman) }}"
                    >
                        <flux:icon.pencil class="size-4" />
                        Edit
                    </flux:button>
                @endif
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column - Main Information -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Rental Information Card -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Rental Information
                        </h2>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $peminjaman->kode_peminjaman }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Customer Info -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Customer
                                </label>
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-400 font-semibold">
                                        {{ strtoupper(substr($peminjaman->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $peminjaman->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $peminjaman->user->email }}
                                        </div>
                                        @if($peminjaman->user->phone)
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $peminjaman->user->phone }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Rental Dates -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Rental Period
                                </label>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-sm">
                                        <flux:icon.calendar class="size-4 text-gray-500" />
                                        <span class="text-gray-600 dark:text-gray-400">Start:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ $peminjaman->tanggal_pinjam->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm">
                                        <flux:icon.calendar class="size-4 text-gray-500" />
                                        <span class="text-gray-600 dark:text-gray-400">Due:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ $peminjaman->tanggal_kembali_rencana->format('M d, Y') }}
                                        </span>
                                    </div>
                                    @if($peminjaman->tanggal_kembali_aktual)
                                        <div class="flex items-center gap-2 text-sm">
                                            <flux:icon.check-circle class="size-4 text-green-500" />
                                            <span class="text-gray-600 dark:text-gray-400">Returned:</span>
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                {{ $peminjaman->tanggal_kembali_aktual->format('M d, Y') }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-2 text-sm">
                                        <flux:icon.clock class="size-4 text-gray-500" />
                                        <span class="text-gray-600 dark:text-gray-400">Duration:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ $peminjaman->calculateRentalDays() }} days
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Unit Info -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Rented Unit
                                </label>
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-800">
                                            <flux:icon.cube class="size-6 text-green-600 dark:text-green-400" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $peminjaman->unit->nama_unit }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                Code: {{ $peminjaman->unit->kode_unit }}
                                            </div>
                                            @if($peminjaman->unit->kategoris && $peminjaman->unit->kategoris->isNotEmpty())
                                                <div class="flex flex-wrap gap-1 mt-2">
                                                    @foreach($peminjaman->unit->kategoris as $kategori)
                                                        <flux:badge color="gray" size="sm">{{ $kategori->nama_kategori }}</flux:badge>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Created Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Created
                                </label>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $peminjaman->created_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                @if($peminjaman->catatan_peminjam || $peminjaman->catatan_admin)
                    <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Notes & Comments
                        </h2>

                        @if($peminjaman->catatan_peminjam)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Customer Notes
                                </label>
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $peminjaman->catatan_peminjam }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if($peminjaman->catatan_admin)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Admin Notes
                                </label>
                                <div class="bg-gray-50 dark:bg-gray-900/20 border border-gray-200 dark:border-gray-700 rounded-lg p-3">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $peminjaman->catatan_admin }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Return Action Section (Only if status is dipinjam) -->
                @if($peminjaman->status === 'dipinjam')
                    <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Mark as Returned
                        </h2>

                        <form method="POST" action="{{ route('admin.peminjamans.return', $peminjaman) }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="catatan_admin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Return Notes (Optional)
                                </label>
                                <flux:textarea
                                    name="catatan_admin"
                                    id="catatan_admin"
                                    rows="3"
                                    placeholder="Add notes about the return condition, any damages, or other observations..."
                                    value="{{ old('catatan_admin') }}"
                                />
                            </div>

                            <div class="flex items-center gap-3">
                                <flux:button type="submit" variant="primary">
                                    <flux:icon.check class="size-4" />
                                    Mark as Returned
                                </flux:button>

                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    This will update the status and calculate any late fees if applicable.
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Right Column - Financial & Actions -->
            <div class="space-y-6">

                <!-- Financial Summary -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Financial Summary
                    </h2>

                    <div class="space-y-4">
                        <!-- Rental Cost -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Rental Cost</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $peminjaman->getFormattedHargaSewaTotal() }}
                            </span>
                        </div>

                        <!-- Unit Daily Rate -->
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 dark:text-gray-400">
                                {{ \App\Helpers\CurrencyHelper::formatIDR($peminjaman->unit->harga_sewa_per_hari) }}/day × {{ $peminjaman->calculateRentalDays() }} days
                            </span>
                        </div>

                        <!-- Late Fee -->
                        @if($peminjaman->denda_total > 0)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-red-600 dark:text-red-400">Late Fee</span>
                                    <span class="text-sm font-medium text-red-600 dark:text-red-400">
                                        {{ $peminjaman->getFormattedDendaTotal() }}
                                    </span>
                                </div>
                                @if($peminjaman->calculateLateDays() > 0)
                                    <div class="flex items-center justify-between text-xs mt-1">
                                        <span class="text-red-500 dark:text-red-400">
                                            {{ \App\Helpers\CurrencyHelper::formatIDR($peminjaman->unit->denda_per_hari) }}/day × {{ $peminjaman->calculateLateDays() }} days late
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Total Amount -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                            <div class="flex items-center justify-between">
                                <span class="text-base font-semibold text-gray-900 dark:text-white">Total Amount</span>
                                <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                    {{ $peminjaman->getFormattedTotalBayar() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Timeline
                    </h2>

                    <div class="space-y-4">
                        <!-- Created -->
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                                <flux:icon.plus class="size-4 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    Rental Created
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $peminjaman->created_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full
                                {{ $peminjaman->tanggal_pinjam->isPast() ? 'bg-green-100 dark:bg-green-800' : 'bg-gray-100 dark:bg-gray-800' }}">
                                <flux:icon.play class="size-4
                                    {{ $peminjaman->tanggal_pinjam->isPast() ? 'text-green-600 dark:text-green-400' : 'text-gray-500' }}" />
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    Rental Started
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $peminjaman->tanggal_pinjam->format('M d, Y') }}
                                    @if($peminjaman->tanggal_pinjam->isFuture())
                                        ({{ $peminjaman->tanggal_pinjam->diffForHumans() }})
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Due Date -->
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full
                                {{ $peminjaman->tanggal_kembali_aktual ? 'bg-green-100 dark:bg-green-800' : ($peminjaman->tanggal_kembali_rencana->isPast() ? 'bg-red-100 dark:bg-red-800' : 'bg-gray-100 dark:bg-gray-800') }}">
                                <flux:icon.clock class="size-4
                                    {{ $peminjaman->tanggal_kembali_aktual ? 'text-green-600 dark:text-green-400' : ($peminjaman->tanggal_kembali_rencana->isPast() ? 'text-red-600 dark:text-red-400' : 'text-gray-500') }}" />
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    Due Date
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $peminjaman->tanggal_kembali_rencana->format('M d, Y') }}
                                    @if(!$peminjaman->tanggal_kembali_aktual && $peminjaman->tanggal_kembali_rencana->isPast())
                                        <span class="text-red-600 dark:text-red-400">(Overdue)</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Return Date -->
                        @if($peminjaman->tanggal_kembali_aktual)
                            <div class="flex items-start gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                                    <flux:icon.check class="size-4 text-green-600 dark:text-green-400" />
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        Returned
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $peminjaman->tanggal_kembali_aktual->format('M d, Y') }}
                                        @if($peminjaman->tanggal_kembali_aktual > $peminjaman->tanggal_kembali_rencana)
                                            <span class="text-red-600 dark:text-red-400">
                                                ({{ $peminjaman->calculateLateDays() }} days late)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Quick Actions
                    </h2>

                    <div class="space-y-3">
                        @if($peminjaman->status === 'dipinjam')
                            <flux:button
                                variant="outline"
                                href="{{ route('admin.peminjamans.edit', $peminjaman) }}"
                                class="w-full justify-start"
                            >
                                <flux:icon.pencil class="size-4" />
                                Edit Rental
                            </flux:button>
                        @endif

                        <flux:button
                            variant="outline"
                            href="{{ route('admin.users.show', $peminjaman->user) }}"
                            class="w-full justify-start"
                        >
                            <flux:icon.user class="size-4" />
                            View Customer
                        </flux:button>

                        <flux:button
                            variant="outline"
                            href="{{ route('admin.units.show', $peminjaman->unit) }}"
                            class="w-full justify-start"
                        >
                            <flux:icon.cube class="size-4" />
                            View Unit
                        </flux:button>

                        {{-- <flux:button
                            variant="outline"
                            onclick="window.print()"
                            class="w-full justify-start"
                        >
                            <flux:icon.printer class="size-4" />
                            Print Details
                        </flux:button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }

            body {
                background: white !important;
                color: black !important;
            }
        }
    </style>
</x-layouts.admin>
