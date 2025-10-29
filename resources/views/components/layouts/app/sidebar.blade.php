<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>

                    <!-- Debug Info -->
                    @auth
                        <!-- Debug: User Role: {{ auth()->user()->role ?? 'no role' }} -->
                    @endauth

                    @auth
                        @if(auth()->user()->role === 'user')
                            <!-- Sewa Tenda Inline Accordion -->
                            <div>
                                <!-- Accordion Trigger -->
                                <div class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 rounded-lg cursor-pointer transition-all duration-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100 group {{ request()->routeIs('user.tents.index') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100' : '' }}"
                                     onclick="toggleAccordion()">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400 group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-all duration-200 {{ request()->routeIs('user.tents.index') ? 'text-zinc-700 dark:text-zinc-300' : '' }}"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <span>Sewa Produk</span>
                                    </div>

                                    <!-- Animated Arrow -->
                                    <svg id="accordion-arrow" class="w-4 h-4 text-zinc-500 dark:text-zinc-400 transition-all duration-300 transform {{ request()->routeIs('user.tents.index') ? 'rotate-180 text-zinc-700 dark:text-zinc-300' : '' }}"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>

                                <!-- Inline Dropdown Content -->
                                <div id="accordion-content" class="overflow-hidden transition-all duration-300 {{ request()->routeIs('user.tents.index') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} bg-zinc-50 dark:bg-zinc-800/50 border-l-2 border-zinc-200 dark:border-zinc-700 ml-3 mb-2">

                                    <!-- Submenu Items -->
                                    <div class="py-1 space-y-1">
                                        <!-- All Products -->
                                        <a href="{{ route('user.tents.index') }}"
                                           wire:navigate
                                           class="flex items-center px-6 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700/50 transition-all duration-200 group {{ request()->routeIs('user.tents.index') && !request()->has('kategori') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-900 dark:text-blue-200' : '' }}">
                                            <svg class="w-3 h-3 text-blue-500 mr-3 transition-all duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            <span class="transition-all duration-200 group-hover:translate-x-1">Semua Produk</span>
                                        </a>

                                        @if(isset($sidebarKategoris) && $sidebarKategoris->count() > 0)
                                            <!-- Categories -->
                                            @foreach($sidebarKategoris as $kategori)
                                                <a href="{{ route('user.tents.index', ['kategori' => $kategori->id]) }}"
                                                   wire:navigate
                                                   class="flex items-center px-6 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700/50 transition-all duration-200 group {{ request()->get('kategori') == $kategori->id ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-200' : '' }}">
                                                    <svg class="w-3 h-3 text-emerald-500 mr-3 transition-all duration-200 group-hover:scale-110 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                    <span class="transition-all duration-200 group-hover:translate-x-1">{{ $kategori->nama_kategori }}</span>
                                                </a>
                                            @endforeach
                                        @else
                                            <!-- No Categories State -->
                                            <div class="px-6 py-3 text-center">
                                                <svg class="w-6 h-6 text-zinc-400 dark:text-zinc-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Belum ada kategori</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Footer Info -->
                                    <div class="px-6 py-2 border-t border-zinc-200 dark:border-zinc-600 bg-zinc-100/50 dark:bg-zinc-700/30">
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 flex items-center space-x-1">
                                            <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ isset($sidebarKategoris) ? $sidebarKategoris->count() : 0 }} kategori tersedia</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <script>
                            function toggleAccordion() {
                                const content = document.getElementById('accordion-content');
                                const arrow = document.getElementById('accordion-arrow');

                                if (content.style.maxHeight === '0px' || content.style.maxHeight === '') {
                                    content.style.maxHeight = '24rem';
                                    content.style.opacity = '1';
                                    arrow.style.transform = 'rotate(180deg)';
                                } else {
                                    content.style.maxHeight = '0px';
                                    content.style.opacity = '0';
                                    arrow.style.transform = 'rotate(0deg)';
                                }
                            }
                            </script>

                            <!-- Keranjang Belanja -->
                            <a href="{{ route('user.cart.index') }}"
                               wire:navigate
                               class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 rounded-lg cursor-pointer transition-all duration-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100 group {{ request()->routeIs('user.cart.*') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400 group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-all duration-200 {{ request()->routeIs('user.cart.*') ? 'text-zinc-700 dark:text-zinc-300' : '' }}"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293A1 1 0 005 16h12M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"/>
                                    </svg>
                                    <span>Keranjang</span>
                                </div>

                                <!-- Cart Badge -->
                                <span id="cartBadge" class="bg-red-500 text-white text-xs rounded-full h-5 min-w-[20px] items-center justify-center px-1" style="display: none;">
                                    0
                                </span>
                            </a>

                            <!-- Riwayat Penyewaan -->
                            <flux:navlist.item icon="clock" :href="route('user.rental-history.index')" :current="request()->routeIs('user.rental-history.*')" wire:navigate>
                                Riwayat Penyewaan
                            </flux:navlist.item>
                        @endif
                    @endauth
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            {{-- <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist> --}}

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
        </flux:header>

        <!-- Flash Messages -->
        {{-- Flash messages removed - using SweetAlert instead --}}

        {{ $slot }}

        @auth
            @if(auth()->user()->role === 'user')
                <script>
                    // Update cart count on page load
                    document.addEventListener('DOMContentLoaded', function() {
                        updateCartCount();
                    });

                    function updateCartCount() {
                        fetch('{{ route('user.cart.count') }}')
                            .then(response => response.json())
                            .then(data => {
                                const cartBadge = document.getElementById('cartBadge');
                                if (cartBadge) {
                                    cartBadge.textContent = data.count;
                                    if (data.count > 0) {
                                        cartBadge.style.display = 'flex';
                                    } else {
                                        cartBadge.style.display = 'none';
                                    }
                                }
                            })
                            .catch(error => console.error('Error updating cart count:', error));
                    }

                    // Expose updateCartCount globally for use in other scripts
                    window.updateCartCount = updateCartCount;
                </script>
            @endif
        @endauth

        @stack('scripts')
        @fluxScripts
    </body>
</html>
