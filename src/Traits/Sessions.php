<?php

namespace BezhanSalleh\GoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Period;

trait Sessions
{
    use MetricDiff;

    /** @return array{result: int, previous: int} */
    private function sessionsToday(): array
    {
        $results = $this->get('sessions', 'date', Period::days(1));

        return match (true) {
            ($results->containsOneItem() && ($results->first()['date'])->isYesterday()) => [ // @phpstan-ignore-line
                'previous' => (filled($results->first()) && array_key_exists('value', $results->first())) ? $results->first()['value'] : 0,
                'result' => 0,
            ],
            ($results->containsOneItem() && ($results->first()['date'])->isToday()) => [ // @phpstan-ignore-line
                'previous' => 0,
                'result' => (filled($results->first()) && array_key_exists('value', $results->first())) ? $results->first()['value'] : 0,
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

    /** @return array{result: int, previous: int} */
    private function sessionsYesterday(): array
    {
        $results = $this->get('sessions', 'date', Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'previous' => $results->last()['value'] ?? 0,
            'result' => $results->first()['value'] ?? 0,
        ];
    }

    /** @return array{result: int, previous: int} */
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

    /** @return array{result: int, previous: int} */
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

    /** @return array{result: int, previous: int} */
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

    /** @return array{result: int, previous: int} */
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
