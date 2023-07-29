<x-filament-widgets::widget class="filament-wigets-chart-widget">
    <x-filament::card>
        <div wire:init='init'>
            @if ($readyToLoad)
                <div class="flex items-center justify-between gap-8">
                    <div class="font-medium text-gray-500 text-md dark:text-gray-200">
                        {{ $this->label() }}
                    </div>
                    <span
                        class="inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-lg font-medium tracking-tight rounded-xl text-primary-700 bg-primary-500/10 whitespace-normal dark:text-primary-500">
                        {{ $data['total'] }}
                    </span>
                </div>

                <div wire:ignore>
                    <div x-ignore ax-load
                        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('chart', 'filament/widgets') }}"
                        x-data="chart({
                            cachedData: @js($data['chartData']),
                            options: @js($data['chartOptions']),
                            type: 'doughnut',
                        })" wire:ignore>

                        <canvas x-ref="canvas" style="height:80px; width:80px"></canvas>

                        <span
                            x-ref="backgroundColorElement"
                            @class([
                                match ('primary') {
                                    'gray' => 'text-gray-100 dark:text-gray-800',
                                    default => 'text-custom-50 dark:text-custom-400/10',
                                },
                            ])
                        ></span>

                        <span
                            x-ref="borderColorElement"
                            @class([
                                match ('primary') {
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
            @else
                <div class="flex justify-center items-center h-[270px] w-full">
                    <x-filament-google-analytics::loading-indicator />
                </div>
            @endif
        </div>
    </x-filament::card>
</x-filament-widgets::widget>
