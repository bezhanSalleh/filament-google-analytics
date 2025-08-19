<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

trait MetricDiff
{
    /** @return Collection<int, array{date: string, value: mixed}> */
    private function get(string $metric, string $dimensions, Period $period): Collection
    {
        $analyticsData = Analytics::get(
            $period,
            [$metric],
            [$dimensions],
            orderBy: [
                OrderBy::dimension($dimensions, true),
            ],
        );

        $results = $analyticsData;

        return collect($results)->map(fn (array $dateRow): array => [
            'date' => (string) $dateRow[$dimensions],
            'value' => $dateRow[$metric],
        ])->values();
    }

    /** @return array{current: Period, previous: Period} */
    private function getLastWeek(): array
    {
        $period = Period::create(
            Carbon::today()
                ->clone()
                ->startOfWeek(Carbon::SUNDAY)
                ->subWeek(),
            Carbon::today()
                ->clone()
                ->subWeek()
                ->endOfWeek(Carbon::SATURDAY)
        );

        $previous = Period::create(
            Carbon::today()
                ->clone()
                ->startOfWeek(Carbon::SUNDAY)
                ->subWeeks(2),
            Carbon::today()
                ->clone()
                ->subWeeks(2)
                ->endOfWeek(Carbon::SATURDAY)
        );

        return [
            'current' => $period,
            'previous' => $previous,
        ];
    }

    /** @return array{current: Period, previous: Period} */
    private function getLastMonth(): array
    {
        $period = Period::create(
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonth(),
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonth()
                ->endOfMonth()
        );

        $previous = Period::create(
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonths(2),
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonths(2)
                ->endOfMonth()
        );

        return [
            'current' => $period,
            'previous' => $previous,
        ];
    }

    /** @return array{current: Period, previous: Period} */
    private function getLastSevenDays(): array
    {
        $period = Period::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(6),
            Carbon::yesterday()
        );

        $previous = Period::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(13),
            Carbon::yesterday()
                ->clone()
                ->subDays(7)
        );

        return [
            'current' => $period,
            'previous' => $previous,
        ];
    }

    /** @return array{current: Period, previous: Period} */
    private function getLastThirtyDays(): array
    {
        $period = Period::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(29),
            Carbon::yesterday()
        );

        $previous = Period::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(59),
            Carbon::yesterday()
                ->clone()
                ->subDays(30)
        );

        return [
            'current' => $period,
            'previous' => $previous,
        ];
    }
}
