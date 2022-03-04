<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Period;

trait SessionsDuration
{
    use MetricDiff;

    private function sessionDurationToday(): array
    {
        $results = $this->performQuery('ga:avgSessionDuration', 'ga:date', Period::days(0));

        return [
            'previous' => $results->first()['value'] ?? 0,
            'result' => $results->last()['value'] ?? 0,
        ];
    }

    private function sessionDurationYesterday(): array
    {
        $results = $this->performQuery('ga:avgSessionDuration', 'ga:date', Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'previous' => $results->first()['value'] ?? 0,
            'result' => $results->last()['value'] ?? 0,
        ];
    }

    private function sessionDurationLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();
        $currentResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastWeek['current']);
        $previousResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastWeek['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionDurationLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastMonth['current']);
        $previousResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastMonth['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionDurationLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastSevenDays['current']);
        $previousResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastSevenDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionDurationLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastThirtyDays['current']);
        $previousResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastThirtyDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }
}
