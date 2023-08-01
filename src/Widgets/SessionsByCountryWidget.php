<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Carbon\Carbon;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

class SessionsByCountryWidget extends ChartWidget
{
    use Traits\CanViewWidget;

    protected static string $view = 'filament-google-analytics::widgets.sessions-by-category';

    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 3;

    public ?string $total = null;

    public ?string $filter = 'T';

    public string $category = 'country';

    protected function getType(): string
    {
        return 'doughnut';
    }

    public function getHeading(): string | Htmlable | null
    {
        return __('filament-google-analytics::widgets.sessions');
    }

    protected function getFilters(): array
    {
        return [
            'T' => __('filament-google-analytics::widgets.T'),
            'Y' => __('filament-google-analytics::widgets.Y'),
            'LW' => __('filament-google-analytics::widgets.LW'),
            'LM' => __('filament-google-analytics::widgets.LM'),
            'LSD' => __('filament-google-analytics::widgets.LSD'),
            'LTD' => __('filament-google-analytics::widgets.LTD'),
        ];
    }

    protected function initializeData()
    {
        $lookups = [
            'T' => Period::create(Carbon::yesterday(), Carbon::today()),
            'Y' => Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()),
            'LW' => Period::create(
                Carbon::today()
                    ->clone()
                    ->startOfWeek(Carbon::SUNDAY)
                    ->subWeek(),
                Carbon::today()
                    ->clone()
                    ->subWeek()
                    ->endOfWeek(Carbon::SATURDAY)
            ),
            'LM' => Period::create(
                Carbon::today()
                    ->clone()
                    ->startOfMonth()
                    ->subMonth(),
                Carbon::today()
                    ->clone()
                    ->startOfMonth()
                    ->subMonth()
                    ->endOfMonth()
            ),
            'LSD' => Period::create(
                Carbon::yesterday()
                    ->clone()
                    ->subDays(6),
                Carbon::yesterday()
            ),
            'LTD' => Period::create(
                Carbon::yesterday()
                    ->clone()
                    ->subDays(29),
                Carbon::yesterday()
            ),
        ];

        $analyticsData = Analytics::get(
            $lookups[$this->filter],
            ['sessions'],
            ['country'],
            10,
            [OrderBy::metric('sessions', true)],
        );

        $results = [];
        foreach ($analyticsData as $row) {
            $results[str($row['country'])->studly()->append(' (' . number_format($row['sessions']) . ')')->toString()] = $row['sessions'];
        }

        $total = 0;
        foreach ($results as $result) {
            $total += $result;
        }

        $this->total = number_format($total);

        return $results;
    }

    protected function getData(): array
    {
        return [
            'labels' => array_keys($this->initializeData()),
            'datasets' => [
                [
                    'label' => 'Country',
                    'data' => array_map('intval', array_values($this->initializeData())),
                    'backgroundColor' => [
                        '#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',
                    ],
                    'cutout' => '55%',
                    'hoverOffset' => 5,
                    'borderColor' => 'transparent',
                ],
            ],
        ];
    }

    protected function getOptions(): array | RawJs | null
    {
        return RawJs::make(<<<'JS'
            {
                animation: {
                    duration: 0,
                },
                elements: {
                    point: {
                        radius: 0,
                    },
                    hit: {
                        radius: 0,
                    },

                },
                maintainAspectRatio: false,
                borderRadius: 4,
                scaleBeginAtZero: true,
                radius: '85%',
                plugins: {
                    legend: {
                        display: true,
                        position: 'left',
                        align: 'bottom',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10
                            }
                        }
                    },
                },
                scales: {
                    x: {
                        display: false,
                    },
                    y: {
                        display: false,
                    },
                },
                tooltips: {
                    enabled: false,
                },
            }
        JS);
    }
}
