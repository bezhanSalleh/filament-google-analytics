<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Filament\Widgets\DoughnutChartWidget;
use Illuminate\Support\Str;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;

class SessionsByDeviceWidget extends DoughnutChartWidget
{
    protected static ?string $pollingInterval = null;

    public ?string $total = null;

    protected static ?int $sort = 2;

    protected function getHeading(): ?string
    {
        return 'Sessions By Device ' . $this->total;
    }

    protected function getData(): array
    {
        $analyticsData = app(Analytics::class)->performQuery(
            Period::months(1),
            'ga:sessions',
            [
                'metrics' => 'ga:sessions',
                'dimensions' => 'ga:deviceCategory',
            ]
        );

        $results = [];
        foreach (collect($analyticsData->getRows()) as $row) {
            $results[Str::studly($row[0])] = $row[1];
        }

        $this->total = number_format($analyticsData->totalsForAllResults['ga:sessions']);

        return [
            'labels' => array_keys($results),
            'datasets' => [
                [
                    'label' => 'Device',
                    'data' => array_map('intval', array_values($results)),
                    'backgroundColor' => [
                        '#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',
                    ],
                    'cutout' => '75%',
                    'hoverOffset' => 7,
                    'borderColor' => '#fff',

                ],
            ],
        ];
    }

    protected function getOptions(): ?array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'left',
                    'align' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                    ],
                ],
            ],

            'maintainAspectRatio' => false,
            'radius' => '70%',
            'borderRadius' => 4,
            'cutout' => 95,
            'scaleBeginAtZero' => true,
        ];
    }
}
