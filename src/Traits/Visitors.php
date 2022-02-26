<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;

trait Visitors
{
    use MetricDiff;

    private function visitorsToday(): array
    {
        $analyticsData = app(Analytics::class)
            ->fetchTotalVisitorsAndPageViews(Period::days(1));

        return [
            'result' => $analyticsData->last()['visitors'] ?? 0,
            'previous' => $analyticsData->first()['visitors'] ?? 0,
        ];
    }

    private function visitorsYesterday(): array
    {
        $analyticsData = app(Analytics::class)
            ->fetchTotalVisitorsAndPageViews(Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'result' => $analyticsData->last()['visitors'] ?? 0,
            'previous' => $analyticsData->first()['visitors'] ?? 0,
        ];
    }

    private function visitorsLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();
        $currentResults = $this->performQuery('ga:users', 'ga:date', $lastWeek['current']);
        $previousResults = $this->performQuery('ga:users', 'ga:date', $lastWeek['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function visitorsLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->performQuery('ga:users', 'ga:year', $lastMonth['current']);
        $previousResults = $this->performQuery('ga:users', 'ga:year', $lastMonth['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function visitorsLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->performQuery('ga:users', 'ga:year', $lastSevenDays['current']);
        $previousResults = $this->performQuery('ga:users', 'ga:year', $lastSevenDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function visitorsLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->performQuery('ga:users', 'ga:year', $lastThirtyDays['current']);
        $previousResults = $this->performQuery('ga:users', 'ga:year', $lastThirtyDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }
}
