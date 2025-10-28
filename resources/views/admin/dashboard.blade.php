<x-layouts.admin :title="__('Admin Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Welcome Admin Section -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Welcome, {{ auth()->user()->name }}!
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        You are logged in as Admin
                    </p>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <x-admin.stats-card
                title="Total Unit Barang"
                :value="number_format($totalUnits)"
                icon="cube"
                color="blue"
                subtitle="Total inventory items"
                :href="route('admin.units.index')"
            />

            <x-admin.stats-card
                title="Stok Barang Tersedia"
                :value="number_format($unitsAvailable)"
                icon="check-circle"
                color="green"
                subtitle="Available for rent"
            />

            <x-admin.stats-card
                title="Barang Disewa"
                :value="number_format($unitsRented)"
                icon="clock"
                color="orange"
                subtitle="Currently rented out"
                :href="route('admin.peminjamans.index')"
            />
        </div>

        <!-- Charts Section -->
        <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-2">
            <!-- Monthly Rentals Chart -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Grafik Peminjaman Bulanan</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Trend peminjaman dalam 12 bulan terakhir</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="monthlyRentalsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Category Rentals Chart -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-800">
                                <svg class="h-5 w-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kategori Paling Disewa</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Top kategori dengan peminjaman terbanyak</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-80 flex items-center justify-center">
                        <canvas id="categoryRentalsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Admin Control Panel</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Welcome to the admin dashboard. From here you can manage users, system settings, and view analytics.
                </p>

                <!-- Quick Actions -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <button class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="text-left">
                            <h4 class="font-medium text-gray-900 dark:text-white">User Management</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add, edit, or remove users</p>
                        </div>
                    </button>

                    <button class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="text-left">
                            <h4 class="font-medium text-gray-900 dark:text-white">System Logs</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">View system activity</p>
                        </div>
                    </button>

                    <button class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="text-left">
                            <h4 class="font-medium text-gray-900 dark:text-white">Settings</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Configure application</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Rentals Line Chart
            const monthlyCtx = document.getElementById('monthlyRentalsChart').getContext('2d');
            const monthlyChart = new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: @json($monthlyRentals['labels']),
                    datasets: [{
                        label: 'Peminjaman',
                        data: @json($monthlyRentals['data']),
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3B82F6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6B7280'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(107, 114, 128, 0.1)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6B7280',
                                stepSize: 1
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverBackgroundColor: '#1D4ED8'
                        }
                    }
                }
            });

            // Category Rentals Pie Chart
            const categoryCtx = document.getElementById('categoryRentalsChart').getContext('2d');
            const categoryChart = new Chart(categoryCtx, {
                type: 'pie',
                data: {
                    labels: @json($categoryRentals['labels']),
                    datasets: [{
                        data: @json($categoryRentals['data']),
                        backgroundColor: @json($categoryRentals['colors']),
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                },
                                color: document.documentElement.classList.contains('dark') ? '#F3F4F6' : '#374151'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });

            // Handle dark mode changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        const isDark = document.documentElement.classList.contains('dark');
                        const textColor = isDark ? '#F3F4F6' : '#374151';
                        const gridColor = isDark ? 'rgba(156, 163, 175, 0.1)' : 'rgba(107, 114, 128, 0.1)';

                        // Update monthly chart
                        monthlyChart.options.scales.x.ticks.color = textColor;
                        monthlyChart.options.scales.y.ticks.color = textColor;
                        monthlyChart.options.scales.y.grid.color = gridColor;
                        monthlyChart.update();

                        // Update category chart
                        categoryChart.options.plugins.legend.labels.color = textColor;
                        categoryChart.update();
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    </script>
</x-layouts.admin>
