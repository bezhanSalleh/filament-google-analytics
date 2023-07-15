<x-filament-widgets::widget class="filament-wigets-chart-widget">
    <div @class([
        'filament-stats-overview-widget-card relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/20',
    ])>
        <div wire:init='init'>
            @if ($readyToLoad)

                <div @class(['space-y-2'])>
                    <div @class([
                        'flex flex-wrap justify-between items-center space-y-1' => $filters,
                    ])>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-200">
                            {{ $this->label() }}
                        </div>
                        <div class="flex items-center gap-3">
                            @if ($hasFilterLoadingIndicator)
                                <div wire:loading wire:target='filter'>
                                    <x-filament-google-analytics::loading-indicator />
                                </div>
                            @endif

                            <select
                                class="block text-sm font-medium text-gray-500 transition duration-75 border-gray-300 rounded-lg shadow-sm filament-forms-select-component focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                wire:model="filter"
                                wire:loading.class="animate-pulse"
                                style="padding-block: 4px"
                            >
                                @foreach ($filters as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="text-3xl">
                        {{ $data['value'] }}
                    </div>
                </div>

                <div wire:ignore>
                    <div x-ignore ax-load
                        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('fGAChart', 'bezhansalleh/filament-google-analytics') }}"
                        x-data="statsOverviewCardChart({
                            labels: @js($data['chart']),
                            values: @js($data['chart']),
                        })" wire:ignore
                        x-on:theme-changed.window="
                            chart.destroy()
                            initChart()
                        "
                        class="absolute inset-x-0 bottom-0 overflow-hidden rounded-b-xl"
                        style="{{ \Filament\Support\get_color_css_variables($data['color'] ?? 'gray', shades: [50, 400, 700]) }}">
                        <canvas x-ref="fgaCanvas" class="h-6"></canvas>

                        <span x-ref="backgroundColorElement" class="text-custom-50 dark:text-custom-700"></span>

                        <span x-ref="borderColorElement" class="text-custom-400"></span>
                    </div>
                </div>
            @else
                <div class="flex h-[270px] w-full items-center justify-center">
                    <x-filament-google-analytics::loading-indicator />
                </div>
            @endif
        </div>
    </div>

</x-filament-widgets::widget>
