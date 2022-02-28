<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Illuminate\Support\Str;
use Filament\Widgets\Widget;
use Spatie\Analytics\Period;
use Spatie\Analytics\Analytics;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;

class SessionsByDeviceWidget extends Widget
{
    use Traits\CanViewWidget;

    protected static string $view = 'filament-google-analytics::widgets.sessions-by-device-widget';

    protected static ?int $sort = 3;

    public ?string $total = null;

    public bool $readyToLoad = false;

    public function init()
    {
        $this->readyToLoad = true;
    }

    protected function label(): ?string
    {
        return 'Sessions By Device';
    }

    protected function getChartData()
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
                    'borderColor' => config('filament.dark_mode') ? 'transparent' : '#fff',

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

    protected function getData()
    {
        return [
            'chartData' => $this->getChartData(),
            'chartOptions' => $this->getOptions(),
            'total' => $this->total
        ];
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->readyToLoad ? $this->getData() : [],
        ];
    }
}
