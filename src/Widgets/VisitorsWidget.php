<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Illuminate\Support\Arr;
use Filament\Widgets\Widget;
use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;

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
        return __('filament-google-analytics::widgets.visitors');
    }

    protected static function filters(): array
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
            'filters' => static::filters()
        ];
    }
}
