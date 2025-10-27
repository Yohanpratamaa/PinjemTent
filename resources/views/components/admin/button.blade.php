@props([
    'type' => 'button',
    'variant' => 'primary',
    'icon' => null,
    'text' => '',
    'iconPosition' => 'left'
])

<flux:button
    type="{{ $type }}"
    variant="{{ $variant }}"
    {{ $attributes->except(['icon', 'text', 'iconPosition']) }}
>
    @if($icon && $iconPosition === 'left')
        <div class="flex items-center gap-2">
            <flux:icon name="{{ $icon }}" class="size-4" />
            <span>{{ $text ?: $slot }}</span>
        </div>
    @elseif($icon && $iconPosition === 'right')
        <div class="flex items-center gap-2">
            <span>{{ $text ?: $slot }}</span>
            <flux:icon name="{{ $icon }}" class="size-4" />
        </div>
    @else
        {{ $text ?: $slot }}
    @endif
</flux:button>
