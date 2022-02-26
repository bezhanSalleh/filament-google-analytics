<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Filament\Widgets\Widget;
use Spatie\Analytics\Period;
use Spatie\Analytics\Analytics;

class MostVisitedPagesWidget extends Widget
{
    protected static string $view = 'filament-google-analytics::widgets.most-visited-pages-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'today';

    protected function getHeading(): ?string
    {
        return 'Top 10 - Most Visited Pages';
    }

    protected function getData()
    {
        $lookups = [
            'today' => Period::days(1),
            'week' => Period::days(7),
            'month' => Period::months(1),
            'year' => Period::years(1),
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
            'today' => 'Today',
            'week' => 'This Week',
            'month' => 'This Month',
            'year' => 'This Year',
        ];
    }
}
