<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

trait Visitors
{
    use MetricDiff;

    private function visitorsToday(): array
    {
        $analyticsData = Analytics::fetchTotalVisitorsAndPageViews(Period::days(1));

        return [
            'result' => $analyticsData[0]['activeUsers'] ?? 0,
            'previous' => $analyticsData[1]['activeUsers'] ?? 0,
        ];
    }

    private function visitorsYesterday(): array
    {
        $analyticsData = Analytics::fetchTotalVisitorsAndPageViews(Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'result' => $analyticsData[0]['activeUsers'] ?? 0,
            'previous' => $analyticsData[1]['activeUsers'] ?? 0,
        ];
    }

    private function visitorsLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();
        $currentResults = $this->get('activeUsers', 'date', $lastWeek['current']);
        $previousResults = $this->get('activeUsers', 'date', $lastWeek['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function visitorsLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->get('activeUsers', 'year', $lastMonth['current']);
        $previousResults = $this->get('activeUsers', 'year', $lastMonth['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function visitorsLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->get('activeUsers', 'year', $lastSevenDays['current']);
        $previousResults = $this->get('activeUsers', 'year', $lastSevenDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function visitorsLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->get('activeUsers', 'year', $lastThirtyDays['current']);
        $previousResults = $this->get('activeUsers', 'year', $lastThirtyDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }
}
