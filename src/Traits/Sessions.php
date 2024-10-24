<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Period;

trait Sessions
{
    use MetricDiff;

    private function sessionsToday(): array
    {
        $results = $this->get('sessions', 'date', Period::days(1));

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

    private function sessionsYesterday(): array
    {
        $results = $this->get('sessions', 'date', Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'previous' => $results->last()['value'] ?? 0,
            'result' => $results->first()['value'] ?? 0,
        ];
    }

    private function sessionsLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();
        $currentResults = $this->get('sessions', 'year', $lastWeek['current']);
        $previousResults = $this->get('sessions', 'year', $lastWeek['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionsLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->get('sessions', 'year', $lastMonth['current']);
        $previousResults = $this->get('sessions', 'year', $lastMonth['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionsLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->get('sessions', 'year', $lastSevenDays['current']);
        $previousResults = $this->get('sessions', 'year', $lastSevenDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionsLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->get('sessions', 'year', $lastThirtyDays['current']);
        $previousResults = $this->get('sessions', 'year', $lastThirtyDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }
}
