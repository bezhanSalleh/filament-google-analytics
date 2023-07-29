<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Illuminate\Support\Arr;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;

class SessionsDurationWidget extends ChartWidget
{
    use Traits\SessionsDuration;
    use Traits\CanViewWidget;

    protected static ?string $pollingInterval = null;

    protected static string $view = 'filament-google-analytics::widgets.stat-views-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'T';

    public function getHeading(): string | Htmlable | null
    {
        return __('filament-google-analytics::widgets.sessions_duration');
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
            'T' => $this->sessionDurationToday(),
            'Y' => $this->sessionDurationYesterday(),
            'LW' => $this->sessionDurationLastWeek(),
            'LM' => $this->sessionDurationLastMonth(),
            'LSD' => $this->sessionDurationLastSevenDays(),
            'LTD' => $this->sessionDurationLastThirtyDays(),
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
            'value' => $this->initializeData()->trajectoryValueAsTimeString(),
            'icon' => $this->initializeData()->trajectoryIcon(),
            'color' => $this->initializeData()->trajectoryColor(),
            'description' => $this->initializeData()->trajectoryDescription(),
        ];
    }

    public function placeholder()
    {
        return view('filament-google-analytics::widgets.no-chart-placeholder');
    }

    protected function getType(): string
    {
        return 'line';
    }
}
