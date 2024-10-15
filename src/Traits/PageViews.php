<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

trait PageViews
{
    use MetricDiff;

    private function pageViewsToday(): array
    {
        $analyticsData = Analytics::fetchTotalVisitorsAndPageViews(Period::days(1));

        return [
            'result' => $analyticsData->first()['screenPageViews'] ?? 0,
            'previous' => $analyticsData->last()['screenPageViews'] ?? 0,
        ];
    }

    private function pageViewsYesterday(): array
    {
        $analyticsData = Analytics::fetchTotalVisitorsAndPageViews(Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'result' => $analyticsData->first()['screenPageViews'] ?? 0,
            'previous' => $analyticsData->last()['screenPageViews'] ?? 0,
        ];
    }

    private function pageViewsLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();

        $currentResults = $this->get('screenPageViews', 'year', $lastWeek['current']);
        $previousResults = $this->get('screenPageViews', 'year', $lastWeek['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function pageViewsLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->get('screenPageViews', 'year', $lastMonth['current']);
        $previousResults = $this->get('screenPageViews', 'year', $lastMonth['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function pageViewsLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->get('screenPageViews', 'year', $lastSevenDays['current']);
        $previousResults = $this->get('screenPageViews', 'year', $lastSevenDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function pageViewsLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->get('screenPageViews', 'year', $lastThirtyDays['current']);
        $previousResults = $this->get('screenPageViews', 'year', $lastThirtyDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }
}
