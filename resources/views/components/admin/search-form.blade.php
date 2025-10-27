@props([
    'action',
    'method' => 'GET',
    'searchPlaceholder' => 'Search...',
    'searchValue' => null,
    'filters' => [],
    'showExport' => false
])

<div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
    <form method="{{ $method }}" action="{{ $action }}" class="space-y-4">
        @if($method !== 'GET')
            @csrf
            @if($method === 'PUT' || $method === 'PATCH' || $method === 'DELETE')
                @method($method)
            @endif
        @endif

        <div class="grid grid-cols-1 md:grid-cols-{{ count($filters) + 2 }} gap-4">
            <!-- Search Input -->
            <div class="md:col-span-2">
                <flux:input
                    name="search"
                    placeholder="{{ $searchPlaceholder }}"
                    value="{{ $searchValue ?? request('search') }}"
                />
            </div>

            <!-- Dynamic Filters -->
            @foreach($filters as $filter)
                <div>
                    <flux:select name="{{ $filter['name'] }}" placeholder="{{ $filter['placeholder'] ?? 'Select...' }}">
                        <option value="">{{ $filter['placeholder'] ?? 'All' }}</option>
                        @foreach($filter['options'] as $value => $label)
                            <option value="{{ $value }}" {{ request($filter['name']) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>
            @endforeach
        </div>

        <div class="flex items-center gap-3">
            <flux:button type="submit" variant="outline">
                <flux:icon.magnifying-glass class="size-4" />
                Search
            </flux:button>
            <flux:button type="button" variant="ghost" onclick="window.location.href='{{ $action }}'">
                Clear Filters
            </flux:button>
            @if($showExport)
                <flux:button type="button" variant="outline">
                    <flux:icon.document-arrow-down class="size-4" />
                    Export
                </flux:button>
            @endif

            <!-- Additional Buttons Slot -->
            {{ $slot ?? '' }}
        </div>
    </form>
</div>
