<x-layouts.app :title="__('User Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Welcome User Section -->
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Welcome, {{ auth()->user()->name }}!
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        You are logged in as User
                    </p>
                </div>
            </div>
        </div>

        <!-- User Features Cards -->
                <!-- User Features Cards -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <a href="{{ route('user.tents.index') }}" class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 hover:shadow-lg transition-shadow duration-300">
                <div class="p-6 h-full flex flex-col justify-center">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                            <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sewa Tenda</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Temukan tenda terbaik</p>
                        </div>
                    </div>
                </div>
            </a>

            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <div class="p-6 h-full flex flex-col justify-center">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-800">
                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">My Profile</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Manage your profile</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <div class="p-6 h-full flex flex-col justify-center">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-800">
                            <svg class="h-5 w-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-3m-2 8h4a2 2 0 002-2v-8a2 2 0 00-2-2H8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Security</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Account security</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <div class="p-6 h-full flex flex-col justify-center">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-800">
                            <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Preferences</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Your settings</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Your Dashboard</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Welcome to your personal dashboard. Here you can manage your profile, view your activity, and access various features.
                </p>

                <!-- Quick Actions -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('profile.edit') }}" class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="text-left">
                            <h4 class="font-medium text-gray-900 dark:text-white">Edit Profile</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update your personal information</p>
                        </div>
                    </a>

                    <a href="{{ route('user-password.edit') }}" class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="text-left">
                            <h4 class="font-medium text-gray-900 dark:text-white">Change Password</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update your account password</p>
                        </div>
                    </a>

                    <button class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="text-left">
                            <h4 class="font-medium text-gray-900 dark:text-white">Activity Log</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">View your recent activity</p>
                        </div>
                    </button>

                    <button class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="text-left">
                            <h4 class="font-medium text-gray-900 dark:text-white">Help & Support</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Get help and support</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
