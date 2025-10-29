<x-layouts.admin :title="__('Return Request Detail')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3">
                <flux:button
                    :href="route('admin.notifications.index')"
                    variant="outline"
                    size="sm"
                    icon="arrow-left"
                    wire:navigate
                >
                    Back to Notifications
                </flux:button>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Return Request Detail</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Review and manage return request</p>
                </div>
            </div>

            <!-- Status Badge -->
            <div>
                @php
                    $returnStatus = $notification->peminjaman->return_status;
                    $statusConfig = [
                        'requested' => ['color' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/20 dark:text-yellow-400 dark:border-yellow-800', 'text' => 'Pending Review'],
                        'approved' => ['color' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800', 'text' => 'Approved'],
                        'rejected' => ['color' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800', 'text' => 'Rejected']
                    ];
                    $config = $statusConfig[$returnStatus] ?? $statusConfig['requested'];
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $config['color'] }}">
                    {{ $config['text'] }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Notification Details -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Request Information</h2>

                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold">
                                    {{ $notification->user->initials() }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $notification->user->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $notification->user->email }}</p>
                                @if($notification->user->phone)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">📞 {{ $notification->user->phone }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Request Message</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                                {{ $notification->message }}
                            </p>
                            @if($notification->peminjaman->return_message)
                                <div class="mt-3">
                                    <h5 class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Additional Message from User:</h5>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 border border-blue-200 dark:border-blue-800">
                                        "{{ $notification->peminjaman->return_message }}"
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-600 dark:text-gray-400">Requested At:</span>
                                    <p class="text-gray-900 dark:text-white">{{ $notification->peminjaman->return_requested_at->format('d F Y, H:i') }}</p>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600 dark:text-gray-400">Notification Created:</span>
                                    <p class="text-gray-900 dark:text-white">{{ $notification->created_at->format('d F Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Unit Details -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Unit Information</h2>

                    <div class="flex flex-col md:flex-row md:items-start space-y-4 md:space-y-0 md:space-x-6">
                        <img class="w-full md:w-48 h-32 object-cover rounded-lg"
                             src="{{ $notification->peminjaman->unit->foto_url }}"
                             alt="{{ $notification->peminjaman->unit->nama_unit }}">

                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-2">
                                {{ $notification->peminjaman->unit->nama_unit }}
                            </h3>

                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-zinc-600 dark:text-zinc-400">Brand:</span>
                                    <span class="text-zinc-900 dark:text-zinc-100">{{ $notification->peminjaman->unit->merek }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-zinc-600 dark:text-zinc-400">Condition:</span>
                                    <span class="text-zinc-900 dark:text-zinc-100">{{ $notification->peminjaman->unit->kondisi }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-zinc-600 dark:text-zinc-400">Categories:</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($notification->peminjaman->unit->kategoris as $kategori)
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400 text-xs rounded-full">
                                                {{ $kategori->nama_kategori }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rental Details -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Rental Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-zinc-600 dark:text-zinc-400">Rental Period:</span>
                            <p class="text-zinc-900 dark:text-zinc-100">{{ $notification->peminjaman->tanggal_pinjam->format('d M Y') }} - {{ $notification->peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-zinc-600 dark:text-zinc-400">Quantity:</span>
                            <p class="text-zinc-900 dark:text-zinc-100">{{ $notification->peminjaman->jumlah }} unit(s)</p>
                        </div>
                        <div>
                            <span class="font-medium text-zinc-600 dark:text-zinc-400">Total Cost:</span>
                            <p class="text-zinc-900 dark:text-zinc-100">{{ $notification->peminjaman->getFormattedHargaSewaTotal() }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-zinc-600 dark:text-zinc-400">Current Status:</span>
                            <p class="text-zinc-900 dark:text-zinc-100">{{ ucfirst($notification->peminjaman->status) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-6">
                <!-- Action Buttons -->
                @if($notification->peminjaman->return_status === 'requested')
                    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Actions</h3>

                        <div class="space-y-3">
                            <!-- Approve Button -->
                            <form action="{{ route('admin.notifications.approve', $notification->id) }}" method="POST" class="w-full">
                                @csrf
                                <flux:button
                                    type="button"
                                    variant="primary"
                                    class="w-full"
                                    onclick="confirmApprove()"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approve Return
                                </flux:button>
                            </form>

                            <!-- Reject Button -->
                            <flux:button
                                type="button"
                                variant="danger"
                                class="w-full"
                                onclick="showRejectModal()"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reject Return
                            </flux:button>
                        </div>
                    </div>
                @elseif($notification->peminjaman->return_status === 'approved')
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-green-800 dark:text-green-200">Return Approved</h3>
                                <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                                    Approved on {{ $notification->peminjaman->approved_return_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($notification->peminjaman->return_status === 'rejected')
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-red-800 dark:text-red-200">Return Rejected</h3>
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">
                                    Rejected on {{ $notification->peminjaman->approved_return_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quick Info -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">Quick Info</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-blue-700 dark:text-blue-300">User:</span>
                            <span class="text-blue-900 dark:text-blue-100">{{ $notification->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-700 dark:text-blue-300">Unit:</span>
                            <span class="text-blue-900 dark:text-blue-100">{{ $notification->peminjaman->unit->nama_unit }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-700 dark:text-blue-300">Due Date:</span>
                            <span class="text-blue-900 dark:text-blue-100">{{ $notification->peminjaman->tanggal_kembali_rencana->format('d M Y') }}</span>
                        </div>
                        @if($notification->peminjaman->is_terlambat)
                            <div class="flex justify-between">
                                <span class="text-red-600 dark:text-red-400">Late by:</span>
                                <span class="text-red-700 dark:text-red-300">{{ now()->diffInDays($notification->peminjaman->tanggal_kembali_rencana) }} days</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact User -->
                <div class="bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Contact User</h3>
                    <div class="space-y-2">
                        <a href="mailto:{{ $notification->user->email }}"
                           class="flex items-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $notification->user->email }}
                        </a>
                        @if($notification->user->phone)
                            <a href="tel:{{ $notification->user->phone }}"
                               class="flex items-center text-sm text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $notification->user->phone }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmApprove() {
            Swal.fire({
                title: 'Approve Return Request?',
                text: 'This will mark the item as returned and restore the stock. This action cannot be undone.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, Approve',
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
                        title: 'Processing...',
                        text: 'Approving return request',
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
                    document.querySelector('form[action*="approve"]').submit();
                }
            });
        }

        function showRejectModal() {
            Swal.fire({
                title: 'Reject Return Request',
                html: `
                    <div class="text-left">
                        <p class="text-gray-600 mb-4">Please provide a reason for rejecting this return request:</p>
                        <textarea
                            id="rejectionReason"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            rows="4"
                            placeholder="Enter rejection reason..."
                            maxlength="500"
                            required
                        ></textarea>
                        <small class="text-gray-500">Maximum 500 characters</small>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Reject Request',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'border-0 shadow-2xl',
                    title: 'text-lg font-semibold text-gray-900',
                    content: 'text-gray-600',
                    confirmButton: 'font-medium px-4 py-2 rounded-lg',
                    cancelButton: 'font-medium px-4 py-2 rounded-lg'
                },
                preConfirm: () => {
                    const reason = document.getElementById('rejectionReason').value.trim();
                    if (!reason) {
                        Swal.showValidationMessage('Please provide a rejection reason');
                        return false;
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    submitReject(result.value);
                }
            });
        }

        function submitReject(reason) {
            // Show loading
            Swal.fire({
                title: 'Processing...',
                text: 'Rejecting return request',
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

            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('admin.notifications.reject', $notification->id) }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'rejection_reason';
            reasonInput.value = reason;
            form.appendChild(reasonInput);

            document.body.appendChild(form);
            form.submit();
        }

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
    </script>
    @endpush
</x-layouts.admin>
