<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Filament\Widgets\Widget;
use Spatie\Analytics\Period;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Facades\Analytics;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;

class SessionsByCountryWidget extends Widget
{
    use Traits\CanViewWidget;

    protected static string $view = 'filament-google-analytics::widgets.sessions-by-country-widget';

    protected static ?int $sort = 3;

    public ?string $total = null;

    public bool $readyToLoad = false;

    public function init()
    {
        $this->readyToLoad = true;
    }

    protected function label(): ?string
    {
        return __('filament-google-analytics::widgets.sessions_by_country');
    }

    protected function getChartData()
    {

        //$analyticsData = Analytics::get(Period::days(7));
        $analyticsData = Analytics::get(
            Period::months(1),
            ['sessions'],
            ['country'],
            6,
            [OrderBy::metric('sessions', true)],
        );

        $results = [];
        foreach ($analyticsData as $row) {
            $results[Str::studly($row['country'])] = $row['sessions'];
        }

        $total = 0;
        foreach ($results as $result) {
            $total += $result;
        }
        $this->total = number_format($total);
        //$this->total = number_format($analyticsData->totalsForAllResults['sessions']);

        return [
            'labels' => array_keys($results),
            'datasets' => [
                [
                    'label' => 'Country',
                    'data' => array_map('intval', array_values($results)),
                    'backgroundColor' => [
                        '#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',
                    ],
                    'cutout' => '55%',
                    'hoverOffset' => 4,
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

    protected function getData()
    {
        return [
            'chartData' => $this->getChartData(),
            'chartOptions' => $this->getOptions(),
            'total' => $this->total,
        ];
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->readyToLoad ? $this->getData() : [],
        ];
    }
}
