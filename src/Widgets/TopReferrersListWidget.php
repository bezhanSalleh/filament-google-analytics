<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Filament\Widgets\Widget;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class TopReferrersListWidget extends Widget
{
    use Traits\CanViewWidget;

    protected static string $view = 'filament-google-analytics::widgets.top-referrers-list-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'T';

    public bool $readyToLoad = false;

    public function init()
    {
        $this->readyToLoad = true;
    }

    protected function getHeading(): ?string
    {
        return __('filament-google-analytics::widgets.top_referrers');
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->readyToLoad ? $this->getData() : [],
            'filters' => static::filters(),
        ];
    }

    protected function getData()
    {
        $lookups = [
            'T' => Period::days(1),
            'TW' => Period::days(7),
            'TM' => Period::months(1),
            'TY' => Period::years(1),
        ];

        $analyticsData = app(Analytics::class)
            ->get(
                $lookups[$this->filter],
                'ga:users',
                [
                    'dimensions' => 'ga:fullReferrer',
                    'sort' => '-ga:users',
                    'max-results' => 10,
                ]
            );

        return collect($analyticsData['rows'] ?? [])->map(function (array $pageRow) {
            return [
                'url' => $pageRow[0],
                'pageViews' => (int) $pageRow[1],
            ];
        });
    }

    protected static function filters(): array
    {
        return [
            'T' => __('filament-google-analytics::widgets.T'),
            'TW' => __('filament-google-analytics::widgets.TW'),
            'TM' => __('filament-google-analytics::widgets.TM'),
            'TY' => __('filament-google-analytics::widgets.TY'),
        ];
    }
}
