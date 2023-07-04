<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Filament\Widgets\Widget;
use Illuminate\Support\Str;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class SessionsByDeviceWidget extends Widget
{
    use Traits\CanViewWidget;

    protected static string $view = 'filament-google-analytics::widgets.sessions-by-device-widget';

    protected static ?int $sort = 3;

    public ?string $total = null;

    public bool $readyToLoad = false;

    public array|null $pagePath = null;

    public function init()
    {
        $this->readyToLoad = true;
    }

    protected function label(): ?string
    {
        return __('filament-google-analytics::widgets.sessions_by_device');
    }

    protected function getChartData()
    {
        $analyticsData = Analytics::get(
            Period::months(1),
            ['sessions'],
            ['deviceCategory']
        );

        $results = [];

        foreach ($analyticsData as $row) {
            $results[Str::studly($row['deviceCategory'])] = $row['sessions'];
        }

        $total = 0;
        foreach($results as $result){
                $total += $result;
        }
        $this->total = number_format($total);
        //$this->total = number_format($analyticsData->totalsForAllResults['sessions']);

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
