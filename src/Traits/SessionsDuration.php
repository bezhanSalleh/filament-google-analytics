<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Period;

trait SessionsDuration
{
    use MetricDiff;

    private function sessionDurationToday(): array
    {
        $results = $this->get('averageSessionDuration', 'date', Period::days(1));

        return match (true) {
            ($results->containsOneItem() && ($results->first()['date'])->isYesterday()) => [
                'previous' => $results->first()['value'],
                'result' => 0,
            ],
            ($results->containsOneItem() && ($results->first()['date'])->isToday()) => [
                'previous' => 0,
                'result' => $results->first()['value'],
            ],
            $results->isEmpty() => [
                'previous' => 0,
                'result' => 0,
            ],
            default => [
                'previous' => $results->last()['value'] ?? 0,
                'result' => $results->first()['value'] ?? 0,
            ]
        };
    }

    private function sessionDurationYesterday(): array
    {
        $results = $this->get('averageSessionDuration', 'date', Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'previous' => $results->last()['value'] ?? 0,
            'result' => $results->first()['value'] ?? 0,
        ];
    }

    private function sessionDurationLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();
        $currentResults = $this->get('averageSessionDuration', 'year', $lastWeek['current']);
        $previousResults = $this->get('averageSessionDuration', 'year', $lastWeek['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionDurationLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->get('averageSessionDuration', 'year', $lastMonth['current']);
        $previousResults = $this->get('averageSessionDuration', 'year', $lastMonth['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionDurationLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->get('averageSessionDuration', 'year', $lastSevenDays['current']);
        $previousResults = $this->get('averageSessionDuration', 'year', $lastSevenDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionDurationLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->get('averageSessionDuration', 'year', $lastThirtyDays['current']);
        $previousResults = $this->get('averageSessionDuration', 'year', $lastThirtyDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }
}
