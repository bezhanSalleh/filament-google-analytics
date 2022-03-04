<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;

trait PageViews
{
    use MetricDiff;

    private function pageViewsToday(): array
    {
        $analyticsData = app(Analytics::class)
            ->fetchTotalVisitorsAndPageViews(Period::days(0));

        return [
            'result' => $analyticsData->last()['pageViews'] ?? 0,
            'previous' => $analyticsData->first()['pageViews'] ?? 0,
        ];
    }

    private function pageViewsYesterday(): array
    {
        $analyticsData = app(Analytics::class)
            ->fetchTotalVisitorsAndPageViews(Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'result' => $analyticsData->last()['pageViews'] ?? 0,
            'previous' => $analyticsData->first()['pageViews'] ?? 0,
        ];
    }

    private function pageViewsLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();
        $currentResults = $this->performQuery('ga:pageviews', 'ga:year', $lastWeek['current']);
        $previousResults = $this->performQuery('ga:pageviews', 'ga:year', $lastWeek['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function pageViewsLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->performQuery('ga:pageviews', 'ga:year', $lastMonth['current']);
        $previousResults = $this->performQuery('ga:pageviews', 'ga:year', $lastMonth['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function pageViewsLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->performQuery('ga:pageviews', 'ga:year', $lastSevenDays['current']);
        $previousResults = $this->performQuery('ga:pageviews', 'ga:year', $lastSevenDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function pageViewsLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->performQuery('ga:pageviews', 'ga:year', $lastThirtyDays['current']);
        $previousResults = $this->performQuery('ga:pageviews', 'ga:year', $lastThirtyDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }
}
