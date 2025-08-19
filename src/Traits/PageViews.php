<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

trait PageViews
{
    use MetricDiff;

    /** @return array{result: int, previous: int} */
    private function pageViewsToday(): array
    {
        $analyticsData = Analytics::fetchTotalVisitorsAndPageViews(Period::days(1));

        return [
            'result' => (int) ($analyticsData->first()['screenPageViews'] ?? 0),
            'previous' => (int) ($analyticsData->last()['screenPageViews'] ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function pageViewsYesterday(): array
    {
        $analyticsData = Analytics::fetchTotalVisitorsAndPageViews(Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'result' => (int) ($analyticsData->first()['screenPageViews'] ?? 0),
            'previous' => (int) ($analyticsData->last()['screenPageViews'] ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function pageViewsLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();

        $currentResults = $this->get('screenPageViews', 'year', $lastWeek['current']);
        $previousResults = $this->get('screenPageViews', 'year', $lastWeek['previous']);

        return [
            'previous' => (int) ($previousResults->pluck('value')->sum() ?? 0),
            'result' => (int) ($currentResults->pluck('value')->sum() ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function pageViewsLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->get('screenPageViews', 'year', $lastMonth['current']);
        $previousResults = $this->get('screenPageViews', 'year', $lastMonth['previous']);

        return [
            'previous' => (int) ($previousResults->pluck('value')->sum() ?? 0),
            'result' => (int) ($currentResults->pluck('value')->sum() ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function pageViewsLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->get('screenPageViews', 'year', $lastSevenDays['current']);
        $previousResults = $this->get('screenPageViews', 'year', $lastSevenDays['previous']);

        return [
            'previous' => (int) ($previousResults->pluck('value')->sum() ?? 0),
            'result' => (int) ($currentResults->pluck('value')->sum() ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function pageViewsLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->get('screenPageViews', 'year', $lastThirtyDays['current']);
        $previousResults = $this->get('screenPageViews', 'year', $lastThirtyDays['previous']);

        return [
            'previous' => (int) ($previousResults->pluck('value')->sum() ?? 0),
            'result' => (int) ($currentResults->pluck('value')->sum() ?? 0),
        ];
    }
}
