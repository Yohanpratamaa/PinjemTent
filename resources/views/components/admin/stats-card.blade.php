@props([
    'title',
    'value',
    'icon' => 'chart-bar',
    'color' => 'blue',
    'subtitle' => null,
    'trend' => null,
    'href' => null
])

@php
$colorClasses = [
    'blue' => 'bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-400',
    'green' => 'bg-green-100 dark:bg-green-800 text-green-600 dark:text-green-400',
    'red' => 'bg-red-100 dark:bg-red-800 text-red-600 dark:text-red-400',
    'yellow' => 'bg-yellow-100 dark:bg-yellow-800 text-yellow-600 dark:text-yellow-400',
    'purple' => 'bg-purple-100 dark:bg-purple-800 text-purple-600 dark:text-purple-400',
    'orange' => 'bg-orange-100 dark:bg-orange-800 text-orange-600 dark:text-orange-400',
    'gray' => 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400',
];

$iconClass = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 {{ $href ? 'hover:shadow-md transition-shadow cursor-pointer' : '' }}"
     @if($href) onclick="window.location.href='{{ $href }}'" @endif>
    <div class="flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-full {{ $iconClass }}">
            <flux:icon name="{{ $icon }}" class="size-5" />
        </div>
        <div class="flex-1">
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $title }}</p>
            <div class="flex items-center gap-2">
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
                @if($trend)
                    <span class="text-sm {{ $trend['type'] === 'up' ? 'text-green-600' : 'text-red-600' }}">
                        @if($trend['type'] === 'up')
                            ↗
                        @else
                            ↘
                        @endif
                        {{ $trend['value'] }}
                    </span>
                @endif
            </div>
            @if($subtitle)
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
</div>
