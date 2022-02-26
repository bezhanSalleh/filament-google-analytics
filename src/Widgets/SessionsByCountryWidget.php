<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Illuminate\Support\Str;
use Spatie\Analytics\Period;
use Spatie\Analytics\Analytics;
use Filament\Widgets\DoughnutChartWidget;

class SessionsByCountryWidget extends DoughnutChartWidget
{
    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = null;

    public ?string $total = null;

    protected function getHeading(): ?string
    {
        return 'Sessions By Country - Top 5 '. $this->total;
    }
    protected function getData(): array
    {

        $analyticsData = app(Analytics::class)->performQuery( Period::months(1),'ga:sessions',[
                    'metrics' => 'ga:sessions',
                    'dimensions' => 'ga:country',
                    'sort' => '-ga:sessions',
                    'max-results' => 5,
                ]
            );

        $results = [];
        foreach(collect($analyticsData->getRows()) as $row) {
            $results[Str::studly($row[0])] = $row[1];
        }
        $this->total = number_format($analyticsData->totalsForAllResults['ga:sessions']);

        return [
            'labels' => array_keys($results),
            'datasets' => [
                [
                    'label' =>  'Country',
                    'data' => array_map('intval',array_values($results)),
                    'backgroundColor' => [
                        '#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',
                    ],
                    'cutout' => '75%',
                    'hoverOffset' => 4,
                    'borderColor' => '#fff'

                ],
            ],
        ];
    }

    protected function getOptions(): ?array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display'=> true,
                    'position' => 'left',
                    'align' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                    ]
                ]
            ],
            'maintainAspectRatio' => false,
            'radius' => '70%',
            'borderRadius' => 4,
            'cutout' => 95,
            'scaleBeginAtZero' => true
        ];
    }
}
