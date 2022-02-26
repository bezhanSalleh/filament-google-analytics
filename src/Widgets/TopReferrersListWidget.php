<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Filament\Widgets\Widget;
use Spatie\Analytics\Period;
use Spatie\Analytics\Analytics;

class TopReferrersListWidget extends Widget
{
    protected static string $view = 'filament-google-analytics::widgets.top-referrers-list-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'today';

    protected function getHeading(): ?string
    {
        return 'Top Referrers';
    }

    protected function getData()
    {
        $lookups = [
            'today' => Period::days(1),
            'week' => Period::days(7),
            'month' => Period::months(1),
            'year' => Period::years(1),
        ];

        $analyticsData = app(Analytics::class)
            ->performQuery(
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
