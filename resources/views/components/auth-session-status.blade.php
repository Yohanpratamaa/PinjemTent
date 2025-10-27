@props([
    'status',
])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-500/20 border border-green-200 dark:border-green-500/30 rounded-lg p-3']) }}>
        {{ $status }}
    </div>
@endif
