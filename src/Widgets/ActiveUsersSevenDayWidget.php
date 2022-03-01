<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Illuminate\Support\Arr;
use Filament\Widgets\Widget;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;

class ActiveUsersSevenDayWidget extends Widget
{
    use Traits\ActiveUsers;
    use Traits\CanViewWidget;

    protected static string $view = 'filament-google-analytics::widgets.active-users-seven-day-widget';

    protected static ?int $sort = 3;

    public ?string $filter = '5';

    public $readyToLoad = false;

    public function init()
    {
        $this->readyToLoad = true;
    }

    public function label(): ?string
    {
        return __('filament-google-analytics::widgets.seven_day_active_users');
    }

    function updatedFilter()
    {
        $this->emitSelf('filterChartData', [
            'data' => array_values($this->initializeData()['results']),
        ]);
    }

    protected static function filters(): array
    {
        return [
            '5' => __('filament-google-analytics::widgets.FD'),
            '10' => __('filament-google-analytics::widgets.TD'),
            '15' => __('filament-google-analytics::widgets.FFD'),
        ];
    }

    protected function initializeData()
    {
        $lookups = [
            '5' => $this->performActiveUsersQuery('ga:7dayUsers', 5),
            '10' => $this->performActiveUsersQuery('ga:7dayUsers', 10),
            '15' => $this->performActiveUsersQuery('ga:7dayUsers', 15),
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
            'value' => FilamentGoogleAnalytics::for(last($this->initializeData()['results']))->trajectoryValue(),
            'color' => 'primary',
            'chart' => array_values($this->initializeData()['results']),
        ];
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->readyToLoad ? $this->getData() : [],
            'filters' => static::filters()
        ];
    }
}
