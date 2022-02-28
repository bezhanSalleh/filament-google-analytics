<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Filament\Widgets\Widget;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;

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
        return 'Most Visited Pages - Top 10';
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->readyToLoad ? $this->getData() : [],
            'filters' => $this->getFilters()
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
        
        $analyticsData = app(Analytics::class)->performQuery(
            $lookups[$this->filter],
            'ga:users',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:pageTitle,ga:hostname,ga:pagePath',
                'sort' => '-ga:pageviews',
                'max-results' => 10,
            ]
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
            $analyticsData->rows ?? []
        );
    }

    public function getFilters(): array
    {
        return [
            'T' => 'Today',
            'TW' => 'This Week',
            'TM' => 'This Month',
            'TY' => 'This Year',
        ];
    }
}
