@php
    use Filament\Support\Enums\IconPosition;
    use Filament\Widgets\View\Components\StatsOverviewWidgetComponent\StatComponent\DescriptionComponent;
    use Filament\Widgets\View\Components\StatsOverviewWidgetComponent\StatComponent\StatsOverviewWidgetStatChartComponent;
    use Illuminate\View\ComponentAttributeBag;

    $chartColor = $getChartColor() ?? 'gray';
    $descriptionColor = $getDescriptionColor() ?? 'gray';
    $descriptionIcon = $getDescriptionIcon();
    $descriptionIconPosition = $getDescriptionIconPosition();
    $url = $getUrl();
    $tag = $url ? 'a' : 'div';
    $chartDataChecksum = $generateChartDataChecksum();

    $filter = $getFilter();
    $options = $getOptions();

    $hasFilter = filled($filter) || filled($options);

@endphp

<{!! $tag !!}
    @if ($url)
        {{ \Filament\Support\generate_href_html($url, $shouldOpenUrlInNewTab()) }}
    @endif
    {{
        $getExtraAttributeBag()
            ->class([
                'fi-wi-stats-overview-stat',
                '[&_.fi-input-wrp-prefix]:ps-2!'
            ])
    }}
>
    <div class="fi-wi-stats-overview-stat-content">
        <div class="fi-wi-stats-overview-stat-label-ctn @container">
            {{ \Filament\Support\generate_icon_html($getIcon()) }}

            <div class="fi-wi-stats-overview-stat-label">
                {{ $getLabel() }}
            </div>
            <div class="flex-1"></div>
            @if ($hasFilter)
                <x-filament::input.wrapper
                    inline-prefix
                    wire:target="filter"
                    class="fi-wi-chart-filter @[320px]:w-auto w-9 relative mx-auto group ring-0 @[320px]:ring-1"
                >
                    <div class="@[320px]:hidden absolute inset-0 flex items-center justify-center w-9 pointer-events-none z-10 group">
                        <x-filament::icon
                            class="text-gray-400 size-4 dark:text-gray-500 group-hover:text-primary-500 dark:group-hover:text-primary-400"
                            icon="heroicon-o-funnel"
                            wire:loading.class='transition-opacity duration-300 opacity-0'
                            alias="ga::stats.filter"
                        />
                    </div>

                    <x-filament::input.select
                        inline-prefix
                        wire:model.live="filter"
                        class="w-full cursor-pointer [background-size:0!important] @[320px]:[background-size:24px!important]"
                    >
                        @foreach ($options as $value => $label)
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::wrapper>
            @endif
        </div>

        <div class="fi-wi-stats-overview-stat-value">
            {{ $getValue() }}
        </div>

        @if ($description = $getDescription())
            <div
                {{ (new ComponentAttributeBag)->color(DescriptionComponent::class, $descriptionColor)->class(['fi-wi-stats-overview-stat-description']) }}
            >
                @if ($descriptionIcon && in_array($descriptionIconPosition, [IconPosition::Before, 'before']))
                    {{ \Filament\Support\generate_icon_html($descriptionIcon, attributes: (new \Illuminate\View\ComponentAttributeBag)) }}
                @endif

                <span>
                    {{ $description }}
                </span>

                @if ($descriptionIcon && in_array($descriptionIconPosition, [IconPosition::After, 'after']))
                    {{ \Filament\Support\generate_icon_html($descriptionIcon, attributes: (new \Illuminate\View\ComponentAttributeBag)) }}
                @endif
            </div>
        @endif
    </div>

    @if ($chart = $getChart())
        {{-- An empty function to initialize the Alpine component with until it's loaded with `x-load`. This removes the need for `x-ignore`, allowing the chart to be updated via Livewire polling. --}}
        <div x-data="{ statsOverviewStatChart() {} }">
            <div
                x-load
                x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('stats-overview/stat/chart', 'filament/widgets') }}"
                x-data="statsOverviewStatChart({
                            dataChecksum: @js($chartDataChecksum),
                            labels: @js(array_keys($chart)),
                            values: @js(array_values($chart)),
                        })"
                {{ (new ComponentAttributeBag)->color(StatsOverviewWidgetStatChartComponent::class, $chartColor)->class(['fi-wi-stats-overview-stat-chart']) }}
            >
                <canvas x-ref="canvas"></canvas>

                <span
                    x-ref="backgroundColorElement"
                    class="fi-wi-stats-overview-stat-chart-bg-color"
                ></span>

                <span
                    x-ref="borderColorElement"
                    class="fi-wi-stats-overview-stat-chart-border-color"
                ></span>
            </div>
        </div>
    @endif
</{!! $tag !!}>
