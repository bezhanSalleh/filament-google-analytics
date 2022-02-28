<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Filament\Widgets\Widget;
use Illuminate\Support\Arr;

class VisitorsWidget extends Widget
{
    use Traits\Visitors;
    use Traits\CanViewWidget;

    protected static string $view = 'filament-google-analytics::widgets.visitors-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'T';

    public $readyToLoad = false;

    public function init()
    {
        $this->readyToLoad = true;
    }

    public function label(): ?string
    {
        return 'Unique Users';
    }

    protected static function filters(): array
    {
        return [
            'T' => 'Today',
            'Y' => 'Yesterday',
            'LW' => 'Last Week',
            'LM' => 'Last Month',
            'LSD' => 'Last 7 Days',
            'LTD' => 'Last 30 Days',
        ];
    }

    protected function initializeData()
    {
        $lookups = [
            'T' => $this->visitorsToday(),
            'Y' => $this->visitorsYesterday(),
            'LW' => $this->visitorsLastWeek(),
            'LM' => $this->visitorsLastMonth(),
            'LSD' => $this->visitorsLastSevenDays(),
            'LTD' => $this->visitorsLastThirtyDays(),
        ];

        $data = Arr::get(
            $lookups,
            $this->filter,
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        return FilamentGoogleAnalytics::for($data['result'])
            ->previous($data['previous'])
            ->format('%');
    }

    protected function getData(): array
    {
        return [
            'label' => $this->label(),
            'value' => $this->initializeData()->trajectoryValue(),
            'icon' => $this->initializeData()->trajectoryIcon(),
            'color' => $this->initializeData()->trajectoryColor(),
            'description' => $this->initializeData()->trajectoryDescription(),
            'chart' => '',
            'chartColor' => '',
        ];
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->readyToLoad ? $this->getData() : [],
            'filters' => static::filters(),
        ];
    }
}
