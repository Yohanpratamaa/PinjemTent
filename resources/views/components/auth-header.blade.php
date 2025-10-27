@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <flux:heading size="xl" class="text-gray-900 dark:text-white font-bold mb-2">{{ $title }}</flux:heading>
    <flux:subheading class="text-gray-600 dark:text-gray-300">{{ $description }}</flux:subheading>
</div>
