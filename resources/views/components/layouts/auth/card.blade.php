<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="fixed inset-0 z-0">
            <img src="{{ asset('images/pexels-ajaybhargavguduru-939723.jpg') }}"
                 alt="Mountain camping background"
                 class="w-full h-full object-cover">
            <!-- Dark overlay for better readability -->
            <div class="absolute inset-0 bg-black/60"></div>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-9 w-9 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current text-white" />
                    </span>
                    <span class="sr-only">{{ config('app.name', 'PinjemTent') }}</span>
                </a>

                <!-- Auth Card with Glass Effect -->
                <div class="flex flex-col gap-6">
                    <div class="rounded-xl backdrop-blur-md bg-white/95 dark:bg-gray-900/95 border border-white/20 shadow-2xl">
                        <div class="px-10 py-8">{{ $slot }}</div>
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
