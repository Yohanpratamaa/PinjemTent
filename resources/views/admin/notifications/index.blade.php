<x-layouts.admin :title="__('Return Request Notifications')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Return Request Notifications</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage user return requests and notifications</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                @if($stats['unread'] > 0)
                    <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="inline">
                        @csrf
                        <flux:button variant="outline" size="sm" type="submit">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mark All Read
                        </flux:button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 17H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v5"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Requests</p>
                        <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-amber-100 dark:bg-amber-800 rounded-lg">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-amber-600 dark:text-amber-400">Unread</p>
                        <p class="text-2xl font-bold text-amber-900 dark:text-amber-100">{{ $stats['unread'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-800 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h6a2 2 0 012 2v4m1 5v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h14a2 2 0 012 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Today</p>
                        <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">{{ $stats['today'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-4 mb-6">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter:</span>

                <a href="{{ route('admin.notifications.index') }}"
                   class="px-3 py-1 text-sm rounded-full transition-colors {{ $filter === 'all' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                    All ({{ $stats['total'] }})
                </a>

                <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}"
                   class="px-3 py-1 text-sm rounded-full transition-colors {{ $filter === 'unread' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/20 dark:text-amber-400' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                    Unread ({{ $stats['unread'] }})
                </a>

                <a href="{{ route('admin.notifications.index', ['filter' => 'read']) }}"
                   class="px-3 py-1 text-sm rounded-full transition-colors {{ $filter === 'read' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                    Read ({{ $stats['total'] - $stats['unread'] }})
                </a>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            @if($notifications->count() > 0)
                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($notifications as $notification)
                        <div class="p-6 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors {{ $notification->is_read ? '' : 'bg-blue-50/30 dark:bg-blue-900/10' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4 flex-1">
                                    <!-- User Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">
                                                {{ $notification->user->initials() }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Notification Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2">
                                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $notification->title }}
                                            </h3>
                                            @if(!$notification->is_read)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                                                    New
                                                </span>
                                            @endif
                                        </div>

                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            {{ $notification->message }}
                                        </p>

                                        <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                            <span>{{ $notification->user->name }}</span>
                                            <span>•</span>
                                            <span>{{ $notification->peminjaman->unit->nama_unit }}</span>
                                            <span>•</span>
                                            <span>{{ $notification->time_ago }}</span>
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <div class="flex-shrink-0">
                                        @php
                                            $returnStatus = $notification->peminjaman->return_status;
                                            $statusConfig = [
                                                'requested' => ['color' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400', 'text' => 'Pending'],
                                                'approved' => ['color' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400', 'text' => 'Approved'],
                                                'rejected' => ['color' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400', 'text' => 'Rejected']
                                            ];
                                            $config = $statusConfig[$returnStatus] ?? $statusConfig['requested'];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['color'] }}">
                                            {{ $config['text'] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="ml-4 flex-shrink-0">
                                    <flux:button
                                        :href="route('admin.notifications.show', $notification->id)"
                                        variant="outline"
                                        size="sm"
                                        wire:navigate
                                    >
                                        View Details
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $notifications->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 17H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v5"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-100">No return requests</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        @if($filter === 'unread')
                            No unread return requests at the moment.
                        @elseif($filter === 'read')
                            No read return requests found.
                        @else
                            No return requests have been made yet.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
