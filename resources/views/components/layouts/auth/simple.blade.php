<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="fixed inset-0 z-0">
            <img src="{{ asset('images/pexels-ajaybhargavguduru-939723.jpg') }}"
                 alt="Background"
                 class="w-full h-full object-cover">
            <!-- Dark overlay for better readability -->
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-9 w-9 mb-1 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current text-white" />
                    </span>
                    <span class="sr-only">{{ config('app.name', 'PinjemTent') }}</span>
                </a>

                <!-- Auth Card with Glass Effect -->
                <div class="backdrop-blur-md bg-white/10 border border-white/20 rounded-2xl p-8 shadow-2xl">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
