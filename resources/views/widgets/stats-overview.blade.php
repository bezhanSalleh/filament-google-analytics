@php
    $heading = $this->getHeading();
    $filters = $this->getFilters();
@endphp

<div class="fi-wi-stats-overview-card relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
    <div class="grid gap-y-2">
        <div class="grid gap-y-2">
            <div class="flex items-center gap-x-2">
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ $heading }}
                </span>
                @if ($filters)
                <x-filament::input.wrapper inline-prefix wire:target="filter" class="ms-auto">
                    <x-filament::input.select inline-prefix wire:model.live="filter">
                        @foreach ($filters as $val => $label)
                        <option value="{{ $val }}">
                            {{ $label }}
                        </option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
                @endif
            </div>

            @php
                $description = $this->getCachedData()['description'];
                $value = $this->getCachedData()['value'];
                $color = $this->getCachedData()['color'];
                $icon = $this->getCachedData()['icon'];

                $descriptionIconClasses = \Illuminate\Support\Arr::toCssClasses([
                    'fi-wi-stats-overview-card-description-icon h-5 w-5',
                    match ($color) {
                        'gray' => 'text-gray-400 dark:text-gray-500',
                        default => 'text-custom-600 dark:text-custom-500',
                    },
                ]);

                $descriptionIconStyles = \Illuminate\Support\Arr::toCssStyles([
                    \Filament\Support\get_color_css_variables($color, shades: [500,600]) => $color !== 'gray',
                ]);
            @endphp
            <div class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white">
                {{ $value }}
            </div>

            <div class="flex items-center gap-x-1">
                <span
                    @class([
                        'fi-wi-stats-overview-card-description text-sm font-medium',
                        match ($color) {
                            'gray' => 'text-gray-500 dark:text-gray-400',
                            default => 'text-custom-600 dark:text-custom-500',
                        },
                    ])
                    @style([
                        \Filament\Support\get_color_css_variables($color, shades: [500, 600]) => $color !== 'gray',
                    ])
                >
                    {{ $description }}
                </span>
                <x-filament::icon :icon="$icon" :class="$descriptionIconClasses" :style="$descriptionIconStyles" />
            </div>
        </div>
    </div>
</div>
