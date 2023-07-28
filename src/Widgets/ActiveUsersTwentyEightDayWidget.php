<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;

class ActiveUsersTwentyEightDayWidget extends ChartWidget
{
    use Traits\ActiveUsers;
    use Traits\CanViewWidget;

    protected static bool $isLazy = false;

    /**
     * @var view-string
     */
    protected static string $view = 'filament-google-analytics::widgets.active-users-widget';

    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 3;

    public ?string $filter = '5';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): array
    {
        return [
            '5' => __('filament-google-analytics::widgets.FD'),
            '10' => __('filament-google-analytics::widgets.TD'),
            '15' => __('filament-google-analytics::widgets.FFD'),
        ];
    }

    public function getHeading(): string | Htmlable | null
    {
        return FilamentGoogleAnalytics::for(last($this->initializeData()['results']))->trajectoryValue();
    }

    public function getDescription(): string | Htmlable | null
    {
        return
            __('filament-google-analytics::widgets.twenty_eight_day_active_users')
            ?? static::$description;
    }

    protected function initializeData()
    {
        $lookups = [
            '5' => $this->performActiveUsersQuery('active28DayUsers', 5),
            '10' => $this->performActiveUsersQuery('active28DayUsers', 10),
            '15' => $this->performActiveUsersQuery('active28DayUsers', 15),
        ];

        $data = Arr::get(
            $lookups,
            $this->filter,
            [
                'results' => [0],
            ],
        );

        return $data;
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'data' => array_values($this->initializeData()['results']),
                    'borderWidth' => 2,
                    'fill' => 'start',
                    'tension' => 0.5,
                    'borderColor' => ['rgb(245, 158, 11)'],
                ],
            ],
            'labels' => array_values($this->initializeData()['results']),
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
                },
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
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
