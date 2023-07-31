@php
    $color = $this->getColor();
    $filters = $this->getFilters();
    $heading = $this->getHeading();
    $headingIcon = $this->category === 'country' ? 'heroicon-s-globe-alt' : 'heroicon-s-computer-desktop';
@endphp
<div
    class="fi-wi-stats-overview-card relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
    <div class="grid gap-y-2">
        <div class="flex items-center gap-x-2">
            <span
                class="text-lg font-semibold text-gray-500 dark:text-gray-100 inline-flex gap-x-1 items-center justify-center">
                <x-filament::icon class="w-6 h-6 text-primary-400 dark:text-primary-500" :icon="$headingIcon" />
                <span>
                    {{ $heading }}
                </span>

            </span>

            <x-filament::badge :color="$color">
                {{ $this->total }}
            </x-filament::badge>

            @if ($filters)
                <x-filament::input.wrapper inline-prefix wire:target="filter" class="ms-auto">
                    <x-filament::input.select inline-prefix wire:model.live="filter">
                        @foreach ($filters as $value => $label)
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            @endif
        </div>

    </div>

    <div @if ($pollingInterval = $this->getPollingInterval()) wire:poll.{{ $pollingInterval }}="updateChartData" @endif>
        <div ax-load
            ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('chart', 'filament/widgets') }}"
            wire:ignore x-data="chart({
                cachedData: @js($this->getCachedData()),
                options: @js($this->getOptions()),
                type: @js($this->getType()),
            })" x-ignore>

            <canvas x-ref="canvas"></canvas>

            <span x-ref="backgroundColorElement" @class([
                match ($color) {
                    'gray' => 'text-gray-100 dark:text-gray-800',
                    default => 'text-custom-50 dark:text-custom-400/10',
                },
            ])></span>

            <span x-ref="borderColorElement" @class([
                match ($color) {
                    'gray' => 'text-gray-400',
                    default => 'text-custom-500 dark:text-custom-400',
                },
            ])></span>

            <span x-ref="gridColorElement" class="text-gray-300 dark:text-gray-700"></span>

            <span x-ref="textColorElement" class="text-gray-500 dark:text-gray-400"></span>
        </div>
    </div>
</div>
