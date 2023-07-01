<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Filament\Widgets\Widget;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

class MostVisitedPagesWidget extends Widget
{
    use Traits\CanViewWidget;

    protected static string $view = 'filament-google-analytics::widgets.most-visited-pages-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'T';

    public bool $readyToLoad = false;

    public function init()
    {
        $this->readyToLoad = true;
    }

    protected function getHeading(): ?string
    {
        return __('filament-google-analytics::widgets.most_visited_pages');
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->readyToLoad ? $this->getData() : [],
            'filters' => $this->getFilters(),
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

        $analyticsData = Analytics::get(
            $lookups[$this->filter],
            ['screenPageViews'],
            ['pageTitle','hostName','pagePath'],
            10,
            [OrderBy::metric('screenPageViews')],
        );

        $headers = [
            'name',
            'hostname',
            'path',
            'visits',
        ];

        return array_map(
            function ($row) use ($headers) {
                return array_combine($headers, $row);
            },
            $analyticsData->toArray() ?? []
        );
    }

    public function getFilters(): array
    {
        return [
            'T' => __('filament-google-analytics::widgets.T'),
            'TW' => __('filament-google-analytics::widgets.TW'),
            'TM' => __('filament-google-analytics::widgets.TM'),
            'TY' => __('filament-google-analytics::widgets.TY'),
        ];
    }
}
