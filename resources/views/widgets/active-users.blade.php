@php
    $heading = $this->getHeading();
    $description = $this->getDescription();
    $color = $this->getColor();
    $filters = $this->getFilters();
@endphp

<div class="fi-wi-stats-overview-card relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
    <div class="grid gap-y-2">
        <div class="flex items-center gap-x-2">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ $description }}
            </span>
            @if ($filters)
                    <x-filament::input.wrapper
                        inline-prefix
                        wire:target="filter"
                        class="ms-auto"
                    >
                        <x-filament::input.select
                            inline-prefix
                            wire:model.live="filter"
                        >
                            @foreach ($filters as $value => $label)
                                <option value="{{ $value }}">
                                    {{ $label }}
                                </option>
                            @endforeach
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                @endif
        </div>

        <div class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white">
            {{ $heading }}
        </div>
    </div>

    <div
        @if ($pollingInterval = $this->getPollingInterval())
            wire:poll.{{ $pollingInterval }}="updateChartData"
        @endif

    >
        <div
            ax-load
            ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('chart', 'filament/widgets') }}"
            wire:ignore
            x-data="chart({
                cachedData: @js($this->getCachedData()),
                options: @js($this->getOptions()),
                type: @js($this->getType()),
            })"
            x-ignore
            @class([
                'absolute inset-x-0 bottom-0 overflow-hidden rounded-b-xl',
            ])
            @style([
                \Filament\Support\get_color_css_variables($color, shades: [50, 400, 500]) => $color !== 'gray',
            ])
            @updateChartData.camel="console.log('updateChartData')"
        >
            <canvas :id="$id('fi-wi-stats-overview-card')" x-ref="canvas" class="h-6"></canvas>

            <span
                x-ref="backgroundColorElement"
                @class([
                    match ($color) {
                        'gray' => 'text-gray-100 dark:text-gray-800',
                        default => 'text-custom-50 dark:text-custom-400/10',
                    },
                ])
            ></span>

            <span
                x-ref="borderColorElement"
                @class([
                    match ($color) {
                        'gray' => 'text-gray-400',
                        default => 'text-custom-500 dark:text-custom-400',
                    },
                ])
            ></span>

            <span
                x-ref="gridColorElement"
                class="text-gray-300 dark:text-gray-700"
            ></span>

            <span
                x-ref="textColorElement"
                class="text-gray-500 dark:text-gray-400"
            ></span>
        </div>
    </div>
</div>
