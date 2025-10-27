@props([
    'title',
    'subtitle' => null,
    'breadcrumbs' => [],
    'actions' => null
])

<div class="flex items-center justify-between mb-6">
    <div>
        <!-- Breadcrumbs -->
        @if(count($breadcrumbs) > 0)
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    @foreach($breadcrumbs as $index => $breadcrumb)
                        <li class="inline-flex items-center">
                            @if($index > 0)
                                <flux:icon.chevron-right class="w-4 h-4 text-gray-400 mx-1" />
                            @endif
                            @if($breadcrumb['href'] ?? false)
                                <a href="{{ $breadcrumb['href'] }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                    {{ $breadcrumb['label'] }}
                                </a>
                            @else
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $breadcrumb['label'] }}</span>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif

        <!-- Title and Subtitle -->
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
        @if($subtitle)
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
        @endif
    </div>

    <!-- Actions -->
    @if($actions)
        <div class="flex items-center gap-3">
            {{ $actions }}
        </div>
    @endif
</div>
