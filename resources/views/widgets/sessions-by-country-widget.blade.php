<x-filament::widget class="filament-wigets-chart-widget">
    <x-filament::card>
        <div wire:init='init'>
            @if ($readyToLoad)
                <div class="flex items-center justify-between gap-8">
                    <div @class([
                        'text-lg font-medium text-gray-500',
                        'dark:text-gray-200' => config('filament.dark_mode'),
                    ])>
                        {{ $this->label() }}
                    </div>
                    <span
                        class="inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-lg font-medium tracking-tight rounded-xl text-primary-700 bg-primary-500/10 whitespace-normal dark:text-primary-500">
                        {{ $data['total'] }}
                    </span>
                </div>

                <div>
                    <canvas x-data="{
                    chart: null,

                    init: function () {
                        let chart = this.initChart()

                        $wire.on('updateChartData', async ({ data }) => {
                            chart.data = this.applyColorToData(data)
                            chart.update('resize')
                        })
                    },

                    initChart: function (data = null) {
                        data = data ?? @js($data['chartData'])

                        return this.chart = new Chart($el, {
                            type: 'doughnut',
                            data: this.applyColorToData(data),
                            options: @js($data['chartOptions']) ?? {},
                        })
                    },

                    applyColorToData: function (data) {
                        data.datasets.forEach((dataset, datasetIndex) => {
                            if (! dataset.backgroundColor) {
                                data.datasets[datasetIndex].backgroundColor = getComputedStyle($refs.backgroundColorElement).color
                            }

                            if (! dataset.borderColor) {
                                data.datasets[datasetIndex].borderColor = getComputedStyle($refs.borderColorElement).color
                            }
                        })

                        return data
                    },
                }" wire:ignore>
                        <span x-ref="backgroundColorElement" @class([
                            'text-gray-50',
                            'dark:text-gray-300' => config('filament.dark_mode'),
                        ])></span>

                        <span x-ref="borderColorElement" @class([
                            'text-gray-500',
                            'dark:text-gray-200' => config('filament.dark_mode'),
                        ])></span>
                    </canvas>
                </div>
            @else
                <div class="flex justify-center items-center h-[270px] w-full">
                    <x-filament-google-analytics::loading-indicator />
                </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget>
