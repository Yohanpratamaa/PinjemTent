<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <!-- Left Side with Background Image -->
            <div class="relative hidden h-full flex-col p-10 text-white lg:flex">
                <!-- Background Image -->
                <div class="absolute inset-0">
                    <img src="{{ asset('images/pexels-ajaybhargavguduru-939723.jpg') }}"
                         alt="Tent camping in mountains"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40"></div>
                </div>

                <!-- Logo -->
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                    <span class="flex h-10 w-10 items-center justify-center rounded-md">
                        <x-app-logo-icon class="me-2 h-7 fill-current text-white" />
                    </span>
                    {{ config('app.name', 'PinjemTent') }}
                </a>

                <!-- Quote Section -->
                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-4">
                        <flux:heading size="lg" class="text-white leading-relaxed">
                            &ldquo;Adventure awaits in every tent, and every journey begins with a single step into the wilderness.&rdquo;
                        </flux:heading>
                        <footer>
                            <flux:heading class="text-white/80">PinjemTent Team</flux:heading>
                        </footer>
                    </blockquote>
                </div>
            </div>

            <!-- Right Side with Auth Form -->
            <div class="w-full lg:p-8 bg-white dark:bg-neutral-900">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <!-- Mobile Logo -->
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <span class="flex h-9 w-9 items-center justify-center rounded-md">
                            <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                        </span>
                        <span class="sr-only">{{ config('app.name', 'PinjemTent') }}</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
