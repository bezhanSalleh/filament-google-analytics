<x-filament-widgets::widget class="filament-wigets-chart-widget">
    <div @class(['filament-stats-overview-widget-card relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/20'])>
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
            <div wire:init='init'>
                @if ($readyToLoad)
                    <div class="text-3xl">
                        {{ $data['value'] }}
                    </div>

                    <div
                        class="flex items-center space-x-1 text-sm font-medium text-custom-600 rtl:space-x-reverse"
                        style="{{ \Filament\Support\get_color_css_variables($data['color'] ?? 'gray', shades: [600]) }}"
                    >
                        <span>{{ $data['description'] }}</span>
                        <x-filament::icon
                                :name="$data['icon']"
                                alias="widgets::stats-overview.card.description"
                                size="h-4 w-4"
                            />
                    </div>
                @else
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg shadow-lg">
                            <x-filament-google-analytics::loading-indicator />
                        </div>
                    </div>
                @endif

            </div>
        </div>

        @if ($data && $data['chart'])
            <div class="absolute inset-x-0 bottom-0 overflow-hidden rounded-b-2xl">
                <canvas x-data="{
                    chart: null,

                    init: function () {
                        let chart = this.initChart()

                        window.addEventListener('updateStatsChartData', (event) => {
                            {{-- if (@js($id) === event.detail.id) { --}}
                                chart.destroy()
                                chart = this.initChart(event.detail.data)
                            {{-- } --}}
                        })
                    },

                    initChart: function (data = null) {
                        data = data ?? @js($data['chart'])

                        return this.chart = new Chart($el, {
                            type: 'line',
                            data: {
                                labels: @js($data['chart']),
                                datasets: [{
                                    data: data,
                                    backgroundColor: getComputedStyle($refs.backgroundColorElement).color,
                                    borderColor: getComputedStyle($refs.borderColorElement).color,
                                    borderWidth: 2,
                                    fill: 'start',
                                    tension: 0.5,
                                }],
                            },
                            options: {
                                elements: {
                                    point: {
                                        radius: 0,
                                    },
                                },
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false,
                                    },
                                },
                                scales: {
                                    x:  {
                                        display: false,
                                    },
                                    y:  {
                                        display: false,
                                    },
                                },
                                tooltips: {
                                    enabled: false,
                                },
                            },
                        })
                    }
                }" wire:ignore class="h-6">
                    <span x-ref="backgroundColorElement" @class([
                        match ($data['chartColor']) {
                            'danger' => \Illuminate\Support\Arr::toCssClasses([
                                'text-danger-50',
                                'dark:text-danger-700' => config('filament.dark_mode'),
                            ]),
                            'primary' => \Illuminate\Support\Arr::toCssClasses([
                                'text-primary-50',
                                'dark:text-primary-700' => config('filament.dark_mode'),
                            ]),
                            'success' => \Illuminate\Support\Arr::toCssClasses([
                                'text-success-50',
                                'dark:text-success-700' => config('filament.dark_mode'),
                            ]),
                            'warning' => \Illuminate\Support\Arr::toCssClasses([
                                'text-warning-50',
                                'dark:text-warning-700' => config('filament.dark_mode'),
                            ]),
                            default => \Illuminate\Support\Arr::toCssClasses([
                                'text-gray-50',
                                'dark:text-gray-700' => config('filament.dark_mode'),
                            ])
                        },
                    ])></span>

                    <span x-ref="borderColorElement" @class([
                        match ($data['chartColor']) {
                            'danger' => 'text-danger-400',
                            'primary' => 'text-primary-400',
                            'success' => 'text-success-400',
                            'warning' => 'text-warning-400',
                            default => 'text-gray-400'
                        },
                    ])></span>
                </canvas>
            </div>
        @endif
        <div wire:loading.delay.long wire:target='filter'>
            <div class="absolute inset-0 flex items-center justify-center">
                <x-filament-google-analytics::loading-indicator />
            </div>
        </div>
    </div>

</x-filament-widgets::widget>
